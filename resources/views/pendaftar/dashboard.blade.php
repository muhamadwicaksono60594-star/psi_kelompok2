<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Radar Kediri</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

        .header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            padding: 15px 25px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            width: 40px;
            height: auto;
        }

        .logo-text {
            font-size: 20px;
            font-weight: bold;
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
            background-color: #ffa500;
            color: white;
            font-weight: bold;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar {
            width: 250px;
            background: rgba(44, 62, 80, 0.9);
            color: white;
            padding-top: 80px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .sidebar-menu {
            list-style: none;
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
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding-top: 100px;
            padding: 100px 30px 30px 30px;
            transition: margin-left 0.3s ease;
        }

        .hero-section {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .hero-title {
            font-size: 2.2rem;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .lowongan-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .lowongan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .lowongan-card .card-body {
            padding: 1.5rem;
        }

        .lowongan-card .card-title {
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
        }

        .lowongan-card .card-subtitle {
            color: #3498db;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .lowongan-card .btn-primary {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
            padding: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .lowongan-card .btn-primary:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(37, 117, 252, 0.4);
        }

        @media (max-width: 768px) {
            .hamburger {
                display: flex !important;
            }
            .sidebar {
                transform: translateX(-100%);
                z-index: 2000;
                position: absolute;
                left: -250px;
                top:0;
                width: 250px;
                height: 100%;
                background-color: #2f3e4e;
                transition: left 0.3s ease;
            }
            .sidebar.active {
                transform: translateX(0);
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container-wrapper">
        
        {{-- Navbar --}}
        @include('sidebar.navbar')

        {{-- Sidebar --}}
        @include('sidebar.sidebarpendaftar')

        {{-- Main Content --}}
        <div class="main-content">
            <div class="hero-section">
                <h1 class="hero-title">Daftar Lowongan Magang</h1>
                <p class="hero-subtitle">Temukan peluang magang terbaik untuk mengembangkan karirmu</p>
            </div>

            <div class="container-fluid">
                <div class="row">
                    @forelse ($lowongan as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card lowongan-card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->judul }}</h5>
                                    <h6 class="card-subtitle mb-3">
                                        <i class="fas fa-building"></i> Divisi: {{ $item->divisi->nama_divisi ?? '-' }}
                                    </h6>
                                    <p class="card-text">
                                        <i class="fas fa-users"></i> <strong>Kuota:</strong> {{ $item->kuota }} orang<br>
                                        <i class="fas fa-calendar-alt"></i> <strong>Periode:</strong><br>
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} 
                                        - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                    </p>
                                    <p class="card-text text-muted">{{ Str::limit($item->deskripsi, 100) }}</p>
                                    <a href="{{ route('pendaftar.create', $item->id) }}" class="btn btn-primary w-100">
                                        <i class="fas fa-paper-plane"></i> Daftar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i> Belum ada lowongan tersedia saat ini.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form> --}}

    <script>
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Yakin mau logout?',
                text: "Anda akan keluar dari aplikasi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4a5fe7',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Hamburger menu toggle
        document.querySelector('.hamburger')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>