<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background-color: #f5f5f5;
    }
    .header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 1rem 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .logo {
        font-size: 1.5rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .logo-text {
        color: #fdfdfd;
    }
    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .user-avatar {
        width: 40px;
        height: 40px;
        background: #f59e0b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
        color: white;
    }
    .user-name {
        font-weight: 500;
    }
    .sidebar {
        position: fixed;
        left: 0;
        top: 72px;
        bottom: 0;
        width: 250px;
        background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
        color: white;
        padding: 2rem 0;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        z-index: 999;
    }
    .sidebar-menu {
        list-style: none;
    }
    .sidebar-item {
        margin-bottom: 0.5rem;
    }
    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 1rem 2rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    .sidebar-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-left-color: #10b981;
    }
    .sidebar-link.active {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border-left-color: #10b981;
    }
    .sidebar-icon {
        width: 20px;
        height: 20px;
        margin-right: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .main-content {
        margin-left: 250px;
        margin-top: 72px;
        padding: 2rem;
        min-height: calc(100vh - 72px);
    }
    .has-submenu .submenu {
        list-style: none;
        padding-left: 3.5rem;
        padding-top: 0.3rem;
        display: none;
        flex-direction: column;
        gap: 0.3rem;
    }

    .submenu-link {
        display: block;
        padding: 0.6rem 1rem;
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        color: rgba(255,255,255,0.85);
        font-size: 0.875rem;
        text-decoration: none;
        transition: 0.3s;
    }

    .submenu-link:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
    }
    
    .submenu-arrow {
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    .has-submenu.open > .submenu {
        display: flex;
    }

    .has-submenu.open > .sidebar-link .submenu-arrow {
        transform: rotate(180deg);
    }
    
    .has-submenu .submenu {
        display: none;
        padding-left: 20px;
    }

    .has-submenu.open .submenu {
        display: block;
    }

    .submenu-link {
        display: block;
        padding: 0.75rem 2.5rem;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
    }

    .submenu-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.12);
    }

    .dropdown-icon {
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    .has-submenu.open .dropdown-icon {
        transform: rotate(180deg);
    }

    /* Page Header */
    .page-header {
        margin-bottom: 1.5rem;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 0.95rem;
    }

    /* Filter Card */
    .filter-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
    }

    .filter-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: block;
    }

    .filter-input {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 0.875rem;
        transition: 0.2s ease;
    }

    .filter-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }

    /* Button Group Bottom - FIXED */
    .button-group-bottom {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
        flex-wrap: wrap;
    }

    .btn-export,
    .btn-filter {
        padding: 0.75rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-export.excel {
        background: #10b981;
        color: white;
    }

    .btn-export.excel:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
    }

    .btn-export.pdf {
        background: #ef4444;
        color: white;
    }

    .btn-export.pdf:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(239, 68, 68, 0.3);
    }

    .btn-filter {
        background: #3b82f6;
        color: white;
    }

    .btn-filter:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
    }

    /* Data Card */
    .data-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .table-container {
        overflow-x: auto;
    }

    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    }

    .modern-table thead th {
        padding: 1rem 1.25rem;
        color: white;
        font-size: 0.8125rem;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-align: left;
        border: none;
    }

    .modern-table tbody td {
        padding: 1rem 1.25rem;
        color: #1e293b;
        font-size: 0.875rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .data-row {
        transition: all 0.2s ease;
        background: white;
    }

    .data-row:nth-child(even) {
        background: #f9fafb;
    }

    .data-row:hover {
        background: #eff6ff;
        transform: translateX(4px);
        box-shadow: inset -4px 0 0 #3b82f6;
    }

    /* Empty State */
    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
    }

    .empty-icon {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .empty-title {
        font-size: 1.25rem;
        color: #64748b;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #94a3b8;
        font-size: 0.875rem;
    }

    /* Grid System */
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: -0.75rem;
    }

    .g-3 > * {
        padding: 0.75rem;
    }

    .col-md-2 {
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }

    .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .col-md-2,
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .button-group-bottom {
            flex-direction: column;
        }

        .btn-export,
        .btn-filter {
            width: 100%;
        }

        .main-content {
            margin-left: 0;
            padding: 1rem;
        }

        .sidebar {
            transform: translateX(-100%);
        }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

{{-- Navbar --}}
@include('sidebar.navbar')

{{-- Sidebar --}}
@include('sidebar.sidebaradmin')

<div class="main-content">
    <div class="content-wrapper">

        {{-- Page Header --}}
        <div class="page-header">
            <div class="header-content">
                <h2 class="page-title">{{ $title ?? 'Laporan Instansi' }}</h2>
                <p class="page-subtitle">Laporan rekap instansi berdasarkan status pendaftar</p>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="filter-card">
            <form action="{{ route('admin.laporan.instansi') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="filter-label">Periode mulai</label>
                        <input type="date" name="start" class="filter-input"
                            value="{{ request('start', $start ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="filter-label">Periode sampai</label>
                        <input type="date" name="end" class="filter-input"
                            value="{{ request('end', $end ?? '') }}">
                    </div>
                </div>

                <div class="button-group-bottom">
                    <button type="submit" class="btn-filter">
                        <i class="bi bi-funnel-fill"></i> Terapkan Filter
                    </button>

                    <a href="{{ route('admin.laporan.instansi.excel', request()->all()) }}"
                       class="btn-export excel">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>

                    <a href="{{ route('admin.laporan.instansi.pdf', request()->all()) }}"
                       class="btn-export pdf">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </div>
            </form>
        </div>

        {{-- Table Card --}}
        <div class="data-card mt-4">
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Instansi</th>
                            <th>Total Pendaftar</th>
                            <th>Diterima</th>
                            <th>Ditolak</th>
                            <th>Menunggu</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($combined as $k => $row)
                            <tr class="data-row">
                                <td>{{ $k+1 }}</td>
                                <td>{{ $row['asal_instansi'] }}</td>
                                <td>{{ $row['total'] }}</td>
                                <td>{{ $row['diterima'] }}</td>
                                <td>{{ $row['ditolak'] }}</td>
                                <td>{{ $row['menunggu'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                                        <h4 class="empty-title">Tidak ada data</h4>
                                        <p class="empty-text">Silakan ubah filter untuk menampilkan data lain.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
document.querySelectorAll('.submenu-toggle').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();

        const parent = this.closest('.has-submenu');
        parent.classList.toggle('open');
    });
});
</script>