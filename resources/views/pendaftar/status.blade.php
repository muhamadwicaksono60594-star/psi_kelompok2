<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftar - Kadar Kediri</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }

        .container-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* HEADER */
        .header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            padding: 15px 25px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo img {
            width: 45px;
            height: 45px;
            object-fit: contain;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: white;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background-color: white;
            border-radius: 2px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            background-color: #ff9f1c;
            color: white;
            font-weight: bold;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .user-name {
            font-weight: 500;
            font-size: 15px;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: rgba(44, 62, 80, 0.95);
            color: white;
            padding-top: 70px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            z-index: 999;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            color: #ecf0f1;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 30px;
            color: #fff;
        }

        .sidebar-menu a.active {
            background: #3498db;
            border-left: 4px solid #fff;
            font-weight: bold;
        }

        .sidebar-menu a i {
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: 250px;
            margin-top: 70px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        /* TABLE STYLES */
        .table-container { 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.1); 
            overflow: hidden; 
        }
        
        .table-header { 
            background: linear-gradient(135deg, #667eea, #764ba2); 
            color: white; 
            padding: 20px 30px; 
            font-size: 24px; 
            font-weight: bold; 
        }

        .table-body {
            padding: 0;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        
        th, td { 
            padding: 15px; 
            text-align: left; 
            border-bottom: 1px solid #ddd; 
        }
        
        th { 
            background-color: #f4f4f4;
            font-weight: 600;
            color: #2c3e50;
        }
        
        tbody tr:hover { 
            background-color: #f8f9fa; 
        }
        
        .badge {
            display: inline-block; 
            padding: 6px 12px; 
            border-radius: 12px; 
            color: white; 
            font-size: 13px;
            font-weight: 500;
        }
        
        .badge.waiting { 
            background-color: #f39c12; 
        }
        
        .badge.approved { 
            background-color: #27ae60; 
        }
        
        .badge.rejected { 
            background-color: #e74c3c; 
        }

        .download-section {
            padding: 20px 30px;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .download-section h5 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .btn-success {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            border: none;
            padding: 12px 24px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.4);
            color: white;
        }

        .empty-state {
            padding: 40px 30px;
            text-align: center;
            color: #7f8c8d;
            font-style: italic;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .hamburger {
                display: flex !important;
            }

            .user-name {
                display: none;
            }

            .sidebar {
                transform: translateX(-100%);
                z-index: 2000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }

            .table-header {
                font-size: 20px;
                padding: 15px 20px;
            }

            .logo-text {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container-wrapper">
        <!-- HEADER -->
        <div class="header">
            <div class="logo">
                <div class="hamburger" onclick="toggleSidebar()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" onerror="this.style.display='none'">
                <span class="logo-text">Radar Kediri</span>
            </div>
            <div class="user-info">
                <div class="user-avatar">W</div>
                <span class="user-name">wildan</span>
            </div>
        </div>

        <!-- SIDEBAR -->
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
                    <a href="{{ route('status.status') }}" class="{{ request()->routeIs('status.status') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i> Status Pendaftar
                    </a>
                </li>
                <li>
                    <a href="#" onclick="confirmLogout(event)">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="table-container">
                <div class="table-header">
                    <i class="fas fa-clipboard-list"></i> Status Pendaftaran
                </div>
                <div class="table-body">
                    @if($pendaftaran)
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Asal Sekolah/Perguruan Tinggi</th>
                                <th>Jurusan</th>
                                <th>NIM/NIS</th>
                                <th>Periode Magang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{ $pendaftaran->nama }}</td>
                                <td>{{ $pendaftaran->asal_instansi }}</td>
                                <td>{{ $pendaftaran->jurusan }}</td>
                                <td>{{ $pendaftaran->nim_nis }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)->format('d M Y') }} 
                                    - 
                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai)->format('d M Y') }}
                                </td>
                                <td>
                                    @if($pendaftaran->status == 'menunggu')
                                        <span class="badge waiting">
                                            <i class="fas fa-clock"></i> Menunggu
                                        </span>
                                    @elseif($pendaftaran->status == 'diterima')
                                        <span class="badge approved">
                                            <i class="fas fa-check-circle"></i> Diterima
                                        </span>
                                    @else
                                        <span class="badge rejected">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @if($pendaftaran->status == 'diterima' || $pendaftaran->status == 'ditolak')
                        <div class="download-section">
                            <h5><i class="fas fa-file-alt"></i> Surat Balasan</h5>
                            <a href="{{ Storage::url($pendaftaran->surat_balasan) }}" 
                               class="btn-success" 
                               target="_blank">
                                <i class="fas fa-download"></i> Download Surat Balasan
                            </a>
                        </div>
                    @endif

                    @else
                    <div class="empty-state">
                        <i class="fas fa-inbox" style="font-size: 48px; color: #bdc3c7; margin-bottom: 15px;"></i>
                        <p>Belum ada data pendaftaran. Silakan isi formulir pendaftaran terlebih dahulu.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Form Logout (Hidden) -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

    <!-- SweetAlert Success -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3498db'
        });
    </script>
    @endif

    <script>
        // Toggle Sidebar Mobile
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // Confirm Logout
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Yakin mau logout?',
                text: "Anda akan keluar dari aplikasi.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3498db',
                cancelButtonColor: '#e74c3c',
                confirmButtonText: 'Ya, Logout!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Close sidebar when clicking outside (mobile)
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const hamburger = document.querySelector('.hamburger');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    </script>
</body>
</html>