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
            <li class="sidebar-item">
                <a href="javascript:void(0);" onclick="confirmLogout()" class="sidebar-link">
                    <div class="sidebar-icon">🚪</div>
                    Logout
                </a>
            </li>
        </ul>
    </nav>
</aside>
