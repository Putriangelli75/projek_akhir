@extends('layouts.app')

@section('title', 'Dashboard - SPLJ')
@section('app_sidebar', true)

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow-clean mb-3">Dashboard</p>
            <h1 class="text-3xl font-semibold tracking-[-0.01em] text-slate-950">Ringkasan SPLJ</h1>
            <p class="mt-2 text-sm leading-6 text-slate-600">Pantau jumlah lapangan dan status ketersediaan terbaru.</p>
        </div>
        <a class="btn-clean" href="{{ route('lapangan.index') }}">Lihat Lapangan</a>
    </div>

    <div class="mt-8" id="dashboardAlert"></div>

    <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="surface metric-card p-5">
            <p class="text-sm font-semibold text-slate-500">Total Lapangan</p>
            <h2 class="mt-2 text-3xl font-semibold text-slate-950" id="jumlahLapangan">0</h2>
        </div>
        <div class="surface metric-card p-5">
            <p class="text-sm font-semibold text-slate-500">Tersedia</p>
            <h2 class="mt-2 text-3xl font-semibold text-slate-950" id="lapanganTersedia">0</h2>
        </div>
        <div class="surface metric-card p-5">
            <p class="text-sm font-semibold text-slate-500">Maintenance</p>
            <h2 class="mt-2 text-3xl font-semibold text-slate-950" id="lapanganMaintenance">0</h2>
        </div>
        <div class="surface metric-card p-5">
            <p class="text-sm font-semibold text-slate-500">Booking Saya</p>
            <h2 class="mt-2 text-3xl font-semibold text-slate-950" id="jumlahBooking">0</h2>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
        <div class="surface p-5">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-slate-950">Lapangan terbaru</h2>
                <span class="text-sm text-slate-500">Data dari API</span>
            </div>
            <div class="mt-5 grid gap-4" id="lapanganPreview"></div>
        </div>

        <div class="surface p-5">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-slate-950">Riwayat booking</h2>
                <a class="text-sm font-semibold text-emerald-950 hover:underline" href="{{ route('lapangan.index') }}">Buat booking</a>
            </div>
            <div class="mt-5 grid gap-3" id="bookingHistory">
                <p class="rounded-lg border border-slate-200 p-4 text-sm text-slate-500">Memuat riwayat...</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        requireAuth();
        loadDashboard();

        async function loadDashboard() {
            const [lapanganResponse, bookingResponse] = await Promise.all([
                fetch('/api/lapangan', {
                    headers: apiHeaders()
                }),
                fetch('/api/riwayat-booking', {
                    headers: apiHeaders()
                })
            ]);

            if (!lapanganResponse.ok) {
                showAlert('dashboardAlert', await getErrorMessage(lapanganResponse));
                return;
            }

            if (!bookingResponse.ok) {
                showAlert('dashboardAlert', await getErrorMessage(bookingResponse));
                return;
            }

            const data = await lapanganResponse.json();
            const bookings = await bookingResponse.json();
            const tersedia = data.filter((item) => item.status === 'tersedia').length;
            const maintenance = data.filter((item) => item.status === 'maintenance').length;

            document.getElementById('jumlahLapangan').innerText = data.length;
            document.getElementById('lapanganTersedia').innerText = tersedia;
            document.getElementById('lapanganMaintenance').innerText = maintenance;
            document.getElementById('jumlahBooking').innerText = bookings.length;

            document.getElementById('lapanganPreview').innerHTML = data.slice(0, 3).map((item) => `
                <div class="rounded-lg border border-slate-200 p-4">
                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ${item.status === 'tersedia' ? 'bg-emerald-50 text-emerald-900' : 'bg-amber-50 text-amber-800'}">${escapeHtml(item.status)}</span>
                    <h3 class="mt-3 font-semibold text-slate-950">${escapeHtml(item.nama_lapangan)}</h3>
                    <p class="mt-1 text-sm text-slate-500">${escapeHtml(item.jenis_olahraga)}</p>
                    <p class="mt-3 text-sm font-semibold text-slate-900">${formatRupiah(item.harga_per_jam)} / jam</p>
                </div>
            `).join('');

            document.getElementById('bookingHistory').innerHTML = bookings.length ? bookings.slice(0, 5).map((booking) => `
                <div class="rounded-lg border border-slate-200 p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-semibold text-slate-950">${escapeHtml(booking.lapangan?.nama_lapangan ?? 'Lapangan')}</h3>
                            <p class="mt-1 text-sm text-slate-500">${escapeHtml(booking.tanggal)} / ${escapeHtml(booking.jam_mulai.slice(0, 5))} - ${escapeHtml(booking.jam_selesai.slice(0, 5))}</p>
                        </div>
                        <span class="inline-flex rounded-full bg-stone-100 px-3 py-1 text-xs font-semibold text-slate-700">${escapeHtml(booking.status)}</span>
                    </div>
                    <p class="mt-3 text-sm font-semibold text-slate-950">${formatRupiah(booking.total_harga)}</p>
                </div>
            `).join('') : `
                <div class="rounded-lg border border-slate-200 p-4">
                    <p class="text-sm text-slate-500">Belum ada booking. Pilih lapangan tersedia untuk membuat pesanan pertama.</p>
                </div>
            `;
        }
    </script>
@endpush
