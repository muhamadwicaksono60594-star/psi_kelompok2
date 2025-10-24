<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RadarKediri - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        .content-header {
            margin-bottom: 2rem;
        }
        .content-header h2 {
            color: #1e3a8a;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    @include('sidebar.navbar')

    {{-- Sidebar --}}
    @include('sidebar.sidebaradmin')

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Data Pendaftar {{ ucfirst($filter) }}</h2>
                <div>
                    <a href="{{ route('admin.tabelindent') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Data Indent
                    </a>
                </div>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Asal Instansi</th>
                        <th>Jurusan</th>
                        <th>Jenjang</th>
                        @if($filter == 'indent')
                            <th>Periode</th>
                        @endif
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftars as $key => $pendaftar)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $pendaftar->nama }}</td>
                            <td>{{ $pendaftar->asal_instansi }}</td>
                            <td>{{ $pendaftar->jurusan }}</td>
                            <td>{{ $pendaftar->user->jenjang ?? '-' }}</td> 

                            <td>
                                @if($pendaftar->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($pendaftar->status == 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if (request()->has('tipe') && request('tipe') == 'indent')
                                    <a href="{{ route('admin.indent.verifikasi', $pendaftar->id) }}" class="btn btn-info">Verifikasi</a>
                                @else
                                    <a href="{{ route('admin.pendaftar.detail', $pendaftar->id) }}" class="btn btn-info">Verifikasi</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $filter == 'indent' ? '8' : '7' }}" class="text-center">
                                Belum ada pendaftar {{ $filter }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <form id="logoutForm" style="display: none;"></form>
</body>
</html>
