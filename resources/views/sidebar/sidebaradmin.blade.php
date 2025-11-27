<aside class="sidebar">
    <nav>
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link active">
                    <div class="sidebar-icon">📊</div>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.lowongan.index') }}" class="sidebar-link">
                    <div class="sidebar-icon">💼</div>
                    lowongan
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.tabel') }}" class="sidebar-link">
                    <div class="sidebar-icon">👨‍🎓</div>
                    Data Pendaftar
                </a>
            </li>
            <li class="sidebar-item has-submenu">
                <a href="#" class="sidebar-link submenu-toggle">
                    <i class="bi bi-file-earmark-text sidebar-icon"></i>
                    <span>Laporan</span>
                    <i class="bi bi-chevron-down dropdown-icon"></i>
                </a>

                <ul class="submenu">
                    <li><a href="{{ route('admin.laporan.pendaftar') }}" class="submenu-link">Laporan Pendaftar</a></li>
                    <li><a href="{{ route('admin.laporan.diterima') }}" class="submenu-link">Laporan Diterima</a></li>
                    <li><a href="{{ route('admin.laporan.ditolak') }}" class="submenu-link">Laporan Ditolak</a></li>
                    <li><a href="{{ route('admin.laporan.instansi') }}" class="submenu-link">Laporan Instansi</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="javascript:void(0);" onclick="confirmLogout()" class="sidebar-link">
                    <div class="sidebar-icon">🚪</div>
                    Logout
                </a>
            </li>
        </ul>
    </nav>
</aside>
