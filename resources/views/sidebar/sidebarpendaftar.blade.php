<div class="sidebar" id="sidebar">
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('pendaftar.dashboard') }}" class="{{ request()->routeIs('pendaftar.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Lowongan
            </a>
        </li>
        <li>
            <a href="{{ route('pendaftar.indent.create') }}" class="{{ request()->routeIs('pendaftaran.index') ? 'active' : '' }}">
                <i class="fas fa-edit"></i> Pendaftaran
            </a>
        </li>
        <li>
            <a href="{{ route('status.status') }}" class="{{ request()->routeIs('status.pendaftar') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Status Pendaftar
            </a>
        </li>
        <li>
            <a href="#" onclick="confirmLogout(event)">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </li>
    </ul>
</div>
