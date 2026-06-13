<aside class="h-fit rounded-lg border border-slate-200 bg-stone-100/50 p-3 lg:sticky lg:top-24">
    <div class="mb-3 px-3 py-2">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-800">Area pengguna</p>
        <p class="mt-2 text-sm leading-6 text-slate-600">Kelola data booking dan lapangan dari dashboard.</p>
    </div>

    <nav class="grid gap-1">
        <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}" href="{{ route('dashboard') }}">
            <span>Dashboard</span>
            <span aria-hidden="true">/</span>
        </a>
        <a class="sidebar-link {{ request()->routeIs('lapangan.index') ? 'is-active' : '' }}" href="{{ route('lapangan.index') }}">
            <span>Lapangan</span>
            <span aria-hidden="true">/</span>
        </a>
    </nav>
</aside>
