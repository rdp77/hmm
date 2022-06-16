<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ __('pages.title') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">{{ __('pages.brand') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('Menu Utama') }}</li>
            <li class="{{ Request::route()->getName() == 'dashboard' ? 'active' : (
                Request::route()->getName() == 'dashboard.log' ? 'active' : '') }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-fire"></i><span>{{ __('pages.dashboard') }}</span>
                </a>
            </li>
            <li class="{{ Request::route()->getName() == 'maintenance' ? 'active' : (
                Request::route()->getName() == 'dashboard.log' ? 'active' : '') }}">
                <a href="{{ route('maintenance') }}" class="nav-link">
                    <i class="fas fa-toolbox"></i><span>{{ __('Maintenance') }}</span>
                </a>
            </li>
            <li class="menu-header">{{ __('Data') }}</li>
            <li class="nav-item dropdown {{ Request::route()->getName() == 'activity' ? 'active' : (
                Request::route()->getName() == 'activity.list.index' ? 'active' : (
                        Request::route()->getName() == 'activity.type.index' ? 'active' : '')) }}">
                <a href="{{ route('activity') }}" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-clock-rotate-left"></i>
                    <span>{{ __('Aktivitas') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'activity' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('activity') }}">{{ __('Semua') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'activity.list.index' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('activity.list.index') }}">{{ __('Daftar') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'activity.type.index' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('activity.type.index') }}">{{ __('Tipe') }}</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ Request::route()->getName() == 'users.index' ? 'active' : (
                Request::route()->getName() == 'users.create' ? 'active' : (
                        Request::route()->getName() == 'users.edit' ? 'active' : (
                            Request::route()->getName() == 'users.show' ? 'active' : ''))) }}">
                <a href="{{ route('users.index') }}" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-users"></i>
                    <span>{{ __('Pengguna') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'users.index' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.index') }}">{{ __('Daftar') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'users.create' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.create') }}">{{ __('Tambah') }}</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ Request::route()->getName() == 'hardware.index' ? 'active' : (
                Request::route()->getName() == 'hardware.create' ? 'active' : (
                        Request::route()->getName() == 'hardware.edit' ? 'active' : (
                            Request::route()->getName() == 'brand.index' ? 'active' : (
                        Request::route()->getName() == 'brand.create' ? 'active' : (
                            Request::route()->getName() == 'brand.update' ? 'active' : (
                                Request::route()->getName() == 'brand.recycle' ? 'active' : (
                                    Request::route()->getName() == 'sparepart.index' ? 'active' : (
                        Request::route()->getName() == 'sparepart.create' ? 'active' : (
                            Request::route()->getName() == 'sparepart.update' ? 'active' : (
                                Request::route()->getName() == 'sparepart.recycle' ? 'active' : '')))))))))) }}">
                <a href="{{ route('hardware.index') }}" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-microchip"></i>
                    <span>{{ __('Hardware') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'hardware.index' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('hardware.index') }}">{{ __('Daftar') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'brand.index' ? 'active' : (
                        Request::route()->getName() == 'brand.create' ? 'active' : (
                            Request::route()->getName() == 'brand.update' ? 'active' : (
                                Request::route()->getName() == 'brand.recycle' ? 'active' : ''))) }}">
                        <a class="nav-link" href="{{ route('brand.index') }}">{{ __('Merk') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'sparepart.index' ? 'active' : (
                        Request::route()->getName() == 'sparepart.create' ? 'active' : (
                            Request::route()->getName() == 'sparepart.update' ? 'active' : (
                                Request::route()->getName() == 'sparepart.recycle' ? 'active' : ''))) }}">
                        <a class="nav-link" href="{{ route('sparepart.index') }}">{{ __('Sparepart') }}</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::route()->getName() == 'mtbf.index' ? 'active' : (
                Request::route()->getName() == 'dashboard.log' ? 'active' : '') }}">
                <a href="{{ route('mtbf.index') }}" class="nav-link">
                    <i class="fas fa-divide"></i><span>{{ __('MTBF') }}</span>
                </a>
            </li>
            <li class="{{ Request::route()->getName() == 'mttr.index' ? 'active' : (
                Request::route()->getName() == 'dashboard.log' ? 'active' : '') }}">
                <a href="{{ route('mttr.index') }}" class="nav-link">
                    <i class="fas fa-tools"></i><span>{{ __('MTTR') }}</span>
                </a>
            </li>
            <li class="menu-header">{{ __('Laporan') }}</li>
            <li class="{{ Request::route()->getName() == 'maintenance' ? 'active' : (
                Request::route()->getName() == 'dashboard.log' ? 'active' : '') }}">
                <a href="{{ route('maintenance') }}" class="nav-link">
                    <i class="fas fa-file-alt"></i><span>{{ __('MTBF') }}</span>
                </a>
            </li>
            <li class="{{ Request::route()->getName() == 'maintenance' ? 'active' : (
                Request::route()->getName() == 'dashboard.log' ? 'active' : '') }}">
                <a href="{{ route('maintenance') }}" class="nav-link">
                    <i class="fas fa-file-alt"></i><span>{{ __('MTTR') }}</span>
                </a>
            </li>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('formula') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-calculator"></i> {{ __('Base Formula') }}
            </a>
        </div>
    </aside>
</div>