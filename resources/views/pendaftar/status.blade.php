<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftar - Kadar Kediri</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f2f5;
    color: #333;
    overflow-x: hidden;
    
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
            gap: 10px; /* Jarak otomatis antar elemen */
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

.container {
    display: flex;
    min-height: 100vh;
    padding-top: 60px; /* Biar tidak ketiban header */
}

.sidebar {
    width: 250px;
    background: rgba(44, 62, 80, 0.9);
    color: white;
    padding-top: 20px;
    height: 100vh;
    overflow-y: auto;
    box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
    position: relative;
    z-index: 1;
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
    display: block;
    padding: 15px 20px;
    color: #ecf0f1;
    text-decoration: none;
    transition: all 0.3s ease;
}

.sidebar-menu a:hover {
    background: rgba(255, 255, 255, 0.1);
    padding-left: 30px;
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
    padding: 30px;
    background-color: #f9f9f9;
}

        .table-container { background: white; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); overflow: hidden; }
        .table-header { background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 20px 30px; font-size: 24px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
        tr:hover { background-color: #f1f1f1; }
        .badge {
            display: inline-block; padding: 5px 10px; border-radius: 12px; color: white; font-size: 12px;
        }
        .badge.waiting { background-color: #f39c12; }
        .badge.approved { background-color: #27ae60; }
        .badge.rejected { background-color: #e74c3c; }
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: static; padding-top: 0; }
            .main-content { margin-left: 0; padding: 20px; }
            table, th, td { font-size: 14px; }
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Navbar --}}
        @include('sidebar.navbar')

        {{-- Sidebar --}}
        @include('sidebar.sidebarpendaftar')
        <!-- Main Content -->
        <div class="main-content">
            <div class="table-container">
                <div class="table-header">Status Pendaftaran</div>
                <div class="table-body">
                    @if($pendaftaran)
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Asal Sekolah/Perguruan tinggi</th>
                                <th>Jurusan</th>
                                <th>NIM/NIS</th>
                                <th>Tanggal Pendaftaran</th>
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
                                <td>{{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai)->format('d M Y') }}</td>
                                <td>
                                    @if($pendaftaran->status == 'menunggu')
                                        <span class="badge waiting">Menunggu</span>
                                    @elseif($pendaftaran->status == 'diterima')
                                        <span class="badge approved">Diterima</span>
                                    @else
                                        <span class="badge rejected">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @else
                    <p style="padding: 20px;">Belum ada data pendaftaran. Silakan isi formulir pendaftaran terlebih dahulu.</p>
                    @endif
                    @if($pendaftaran && ($pendaftaran->status == 'Diterima' || $pendaftaran->status == 'Ditolak'))
                        <div class="table-header" style="display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                            <div class="mt-4">
                                <h5>Surat Balasan:</h5>
                                <a href="{{ Storage::url($pendaftaran->surat_balasan) }}" 
                                class="btn btn-success" target="_blank">📄 Download Surat Balasan</a>
                            </div>
                        </div>
                    @endif

            </div>
        </div>
    </div>

    <!-- SweetAlert Success -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#4a5fe7'
        });
    </script>
    @endif
</body>
<script>
function confirmLogout(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Yakin mau logout?',
        text: "Anda akan keluar dari aplikasi.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4a5fe7',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}
</script>
</html>
