{{-- Navbar --}}
@include('sidebar.navbar')

{{-- Sidebar --}}
@include('sidebar.sidebaradmin')

<div class="main-content">
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div class="page-header">
            <div class="header-content">
                <h2 class="page-title">{{ $title }}</h2>
                <p class="page-subtitle">Data lengkap peserta magang dan praktik kerja</p>
            </div>
        </div>

        {{-- Card Table --}}
        <div class="data-card">
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>
                                <div class="th-content">
                                    <i class="bi bi-person-fill"></i>
                                    <span>Nama</span>
                                </div>
                            </th>
                            <th>
                                <div class="th-content">
                                    <i class="bi bi-building"></i>
                                    <span>Asal Instansi</span>
                                </div>
                            </th>
                            <th>
                                <div class="th-content">
                                    <i class="bi bi-mortarboard-fill"></i>
                                    <span>Jurusan</span>
                                </div>
                            </th>
                            <th>
                                <div class="th-content">
                                    <i class="bi bi-calendar-check"></i>
                                    <span>Tanggal Mulai</span>
                                </div>
                            </th>
                            <th>
                                <div class="th-content">
                                    <i class="bi bi-calendar-x"></i>
                                    <span>Tanggal Selesai</span>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $row)
                        <tr class="data-row">
                            <td>
                                <div class="name-cell">
                                    <span class="name-text">{{ $row->nama }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary">{{ $row->asal_instansi }}</span>
                            </td>
                            <td>
                                <span class="text-secondary">{{ $row->jurusan }}</span>
                            </td>
                            <td>
                                <div class="date-cell">
                                    <span class="date-badge date-start">
                                        <i class="bi bi-calendar-check-fill"></i>
                                        {{ \Carbon\Carbon::parse($row->tanggal_mulai)->format('d M Y') }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="date-cell">
                                    <span class="date-badge date-end">
                                        <i class="bi bi-calendar-x-fill"></i>
                                        {{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M Y') }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h4 class="empty-title">Belum Ada Data</h4>
                                    <p class="empty-text">Data peserta akan ditampilkan di sini</p>
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

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
        min-height: 100vh;
    }

    /* Main Content Layout */
    .main-content {
        margin-left: 250px;
        margin-top: 72px;
        padding: 2rem;
        min-height: calc(100vh - 72px);
    }

    .content-wrapper {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 2rem;
        animation: fadeInDown 0.6s ease-out;
    }

    .header-content {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border-left: 5px solid #3b82f6;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0;
    }

    /* Data Card */
    .data-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out;
    }

    /* Table Container */
    .table-container {
        overflow-x: auto;
    }

    /* Modern Table */
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    }

    .modern-table thead tr th {
        padding: 1.25rem 1.5rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 3px solid #1e40af;
    }

    .modern-table thead tr th:first-child {
        border-top-left-radius: 0;
    }

    .modern-table thead tr th:last-child {
        border-top-right-radius: 0;
    }

    .th-content {
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }

    .th-content i {
        font-size: 1.125rem;
        opacity: 0.9;
    }

    /* Table Body */
    .modern-table tbody tr.data-row {
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modern-table tbody tr.data-row:hover {
        background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);
        transform: translateX(4px);
        box-shadow: -4px 0 0 0 #3b82f6;
    }

    .modern-table tbody tr.data-row:last-child {
        border-bottom: none;
    }

    .modern-table tbody td {
        padding: 1.25rem 1.5rem;
        color: #334155;
        font-size: 0.9375rem;
    }

    /* Name Cell */
    .name-cell {
        display: flex;
        align-items: center;
    }

    .name-text {
        font-weight: 600;
        color: #1e293b;
        font-size: 1rem;
    }

    .text-secondary {
        color: #64748b;
        font-size: 0.9375rem;
    }

    /* Date Cell */
    .date-cell {
        display: flex;
        justify-content: center;
    }

    .date-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.125rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .date-badge i {
        font-size: 0.875rem;
    }

    .date-start {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .date-start:hover {
        background: linear-gradient(135deg, #a7f3d0 0%, #6ee7b7 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .date-end {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .date-end:hover {
        background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1.5rem;
        animation: float 3s ease-in-out infinite;
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #94a3b8;
        font-size: 0.9375rem;
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-15px);
        }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .main-content {
            margin-left: 0;
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .modern-table thead tr th,
        .modern-table tbody td {
            padding: 1rem;
            font-size: 0.875rem;
        }
    }

    @media (max-width: 768px) {
        .main-content {
            padding: 1rem;
        }

        .header-content {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.25rem;
        }

        .page-subtitle {
            font-size: 0.875rem;
        }

        .table-container {
            border-radius: 12px;
        }

        .date-badge {
            padding: 0.5rem 0.875rem;
            font-size: 0.8125rem;
        }

        .modern-table thead tr th,
        .modern-table tbody td {
            padding: 0.875rem;
            font-size: 0.8125rem;
        }

        .th-content span {
            display: none;
        }

        .th-content i {
            font-size: 1rem;
        }
    }

    /* Scrollbar Styling */
    .table-container::-webkit-scrollbar {
        height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background: linear-gradient(90deg, #3b82f6, #2563eb);
        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(90deg, #2563eb, #1d4ed8);
    }

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
        
        /* Detail Card Styles */
        .detail-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }
        
        .detail-card-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 1.5rem 2rem;
        }
        
        .detail-card-header h4 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .detail-card-body {
            padding: 2rem;
        }
        
        .detail-table {
            width: 100%;
        }
        
        .detail-table tr {
            border-bottom: 1px solid #e5e7eb;
        }
        
        .detail-table tr:last-child {
            border-bottom: none;
        }
        
        .detail-table th {
            padding: 1rem 0;
            font-weight: 600;
            color: #1e3a8a;
            width: 200px;
            vertical-align: top;
        }
        
        .detail-table td {
            padding: 1rem 0;
            color: #374151;
        }
        
        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e5e7eb;
        }
        
        .btn-action {
            min-width: 120px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .badge {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .count {
            font-size: 3rem;
            font-weight: 700;
        }
        /* ---- SUBMENU ---- */
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

/* Untuk panah */
.submenu-arrow {
    margin-left: auto;
    transition: transform 0.3s ease;
}

/* Bila submenu terbuka */
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

</style>
<script>
document.querySelectorAll('.submenu-toggle').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();

        const parent = this.closest('.has-submenu');
        parent.classList.toggle('open');
    });
});

</script>
