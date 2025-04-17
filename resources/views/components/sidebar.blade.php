<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="overflow-y: auto; max-height: 100vh;">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <h2>E-ARSIP</h2>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <br>
        <!-- Home -->
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="{{ __('menu.home') }}">{{ __('menu.home') }}</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('HALAMAN SURAT') }}</span>
        </li>

        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('transaction.incoming.*') || \Illuminate\Support\Facades\Route::is('transaction.disposition.*') ? 'active' : '' }}">
            <a href="{{ route('transaction.incoming.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-mail-send"></i>
                <div data-i18n="{{ __('menu.transaction.incoming_letter') }}">{{ __('menu.transaction.incoming_letter') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('transaction.outgoing.*') ? 'active' : '' }}">
            <a href="{{ route('transaction.outgoing.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-mail-send"></i>
                <div data-i18n="{{ __('menu.transaction.outgoing_letter') }}">{{ __('menu.transaction.outgoing_letter') }}</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('HALAMAN GALERI SURAT') }}</span>
        </li>

        <li class="menu-sub">
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('gallery.incoming') ? 'active' : '' }}">
                <a href="{{ route('gallery.incoming') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-images"></i>
                    <div data-i18n="{{ __('menu.gallery.incoming_letter') }}">{{ __('menu.gallery.incoming_letter') }}</div>
                </a>
            </li>
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('gallery.outgoing') ? 'active' : '' }}">
                <a href="{{ route('gallery.outgoing') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-images"></i>
                    <div data-i18n="{{ __('menu.gallery.outgoing_letter') }}">{{ __('menu.gallery.outgoing_letter') }}</div>
                </a>
            </li>
        </li>

        {{-- @if(auth()->user()->role == 'admin') --}}
        @if (Auth::check() && Auth::user()->role != 'admin')
        <!-- Laporan -->
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('laporan.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon fa fa-file-text"></i>
                <div data-i18n="Laporan">{{ __('Laporan') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('') ? 'active' : '' }}">
                    <a href="{{ route('laporanmasuk') }}" class="menu-link">
                        <div data-i18n="Surat Masuk">{{ __('Surat Masuk') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('') ? 'active' : '' }}">
                    <a href="{{ route('laporankeluar') }}" class="menu-link">
                        <div data-i18n="Surat Keluar">{{ __('Surat Keluar') }}</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if (Auth::check() && Auth::user()->role == 'admin')
        <!-- User Management -->
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('user.*') ? 'active' : '' }}">
            <a href="{{ route('user.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div data-i18n="{{ __('menu.users') }}">{{ __('menu.users') }}</div>
            </a>
        </li>
        @endif

    </ul>
</aside>
