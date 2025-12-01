<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RadarKediri - Detail Pendaftar</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
    </style>
</head>
<body>
    {{-- Navbar --}}
    @include('sidebar.navbar')

    {{-- Sidebar --}}
    @include('sidebar.sidebaradmin')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container mt-4">
            <div class="detail-card">
                <div class="detail-card-header">
                    <h4><i class="bi bi-person-circle"></i> Detail Pendaftar</h4>
                </div>
                <div class="detail-card-body">
                    <table class="detail-table table-borderless">
                        <tr>
                            <th><i class="bi bi-person-fill"></i> Nama</th>
                            <td>{{ $pendaftar->nama }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-building"></i> Asal Instansi</th>
                            <td>{{ $pendaftar->asal_instansi }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-book"></i> Jurusan</th>
                            <td>{{ $pendaftar->jurusan }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-mortarboard-fill"></i> Jenjang</th>
                            <td>{{ $pendaftar->user->jenjang ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-card-text"></i> NIM/NIS</th>
                            <td>{{ $pendaftar->nim_nis }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-telephone-fill"></i> No Telepon</th>
                            <td>{{ $pendaftar->no_telepon }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-geo-alt-fill"></i> Alamat</th>
                            <td>{{ $pendaftar->alamat }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-file-earmark-text-fill"></i> Berkas</th>
                            <td>
                                @if ($pendaftar->berkas && $pendaftar->berkas->isNotEmpty())
                                    @foreach ($pendaftar->berkas as $berkas)
                                        <a href="{{ asset('storage/' . $berkas->path) }}" 
                                        target="_blank" 
                                        class="btn btn-sm btn-outline-primary mb-2">
                                        <i class="bi bi-download"></i> {{ $berkas->nama_file }}
                                        </a><br>
                                    @endforeach
                                @else
                                    <span class="text-muted">Tidak ada berkas</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-info-circle-fill"></i> Status</th>
                            <td>
                                @if($pendaftar->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($pendaftar->status == 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    
                    <div class="action-buttons">    
                        <a href="{{ route('admin.tabel') }}" class="btn btn-secondary btn-action">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        
                        @if($pendaftar->status == 'menunggu')
                            <div>
                                <button type="button" class="btn btn-success btn-action"
                                    onclick="confirmTerima({{ $pendaftar->id }}, '{{ $pendaftar->nama }}', '{{ $pendaftar->asal_instansi }}')">
                                    <i class="bi bi-check-circle"></i> Terima
                                </button>

                                <button type="button" class="btn btn-danger btn-action"
                                    onclick="confirmTolak({{ $pendaftar->id }}, '{{ $pendaftar->nama }}', '{{ $pendaftar->asal_instansi }}')">
                                    <i class="bi bi-x-circle"></i> Tolak
                                </button>
                            </div>
                        @else
                            <div class="d-flex align-items-center gap-3">
                                @if($pendaftar->status == 'diterima' || $pendaftar->status == 'ditolak')
                                    <a href="{{ route('admin.cetakSuratBalasanPendaftar', $pendaftar->id) }}" 
                                       target="_blank"
                                       class="btn btn-primary btn-action">
                                        <i class="bi bi-printer-fill"></i> Cetak Surat Balasan
                                    </a>
                                @endif
                                <div class="alert {{ $pendaftar->status == 'diterima' ? 'alert-success' : 'alert-danger' }} mb-0">
                                    <i class="bi {{ $pendaftar->status == 'diterima' ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                    Pendaftar ini sudah <strong>{{ $pendaftar->status == 'diterima' ? 'diterima' : 'ditolak' }}</strong>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form> --}}

    <script>
        // Konfirmasi Aksi Terima/Tolak
        function confirmTerima(id, nama, instansi) {
        Swal.fire({
            title: 'Terima Pendaftar?',
            html: `Anda yakin ingin <strong>menerima</strong> pendaftar:<br><br>
                   <strong>${nama}</strong><br>${instansi}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="bi bi-check"></i> Ya, Terima',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/pendaftar/${id}/terima`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil!', 'Pendaftar berhasil diterima.', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error!', data.message || 'Terjadi kesalahan.', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
                });
            }
        });
    }

    // ✅ Fungsi untuk tombol TOLAK (dengan alasan)
    function confirmTolak(id, nama, instansi) {
        Swal.fire({
            title: 'Masukkan Alasan Penolakan',
            html: `Tolak pendaftar:<br><br><strong>${nama}</strong><br>${instansi}`,
            input: 'textarea',
            inputPlaceholder: 'Tuliskan alasan penolakan...',
            showCancelButton: true,
            confirmButtonText: 'Kirim',
            preConfirm: (alasan) => {
                if (!alasan) {
                    Swal.showValidationMessage('Alasan wajib diisi!');
                }
                return alasan;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/pendaftar/${id}/tolak`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ alasan: result.value })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil!', 'Pendaftar berhasil ditolak.', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error!', data.message || 'Terjadi kesalahan.', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
                });
            }
        });
    }
        // Konfirmasi Logout
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin Logout?',
                text: "Anda akan keluar dari aplikasi.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }

        // Animasi angka counter
        const counters = document.querySelectorAll('.count');
        counters.forEach(counter => {
            counter.innerText = '0';

            const updateCounter = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = target / 100;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(updateCounter, 20);
                } else {
                    counter.innerText = target;
                }
            };

            updateCounter();
        });

        // Tampilkan alert jika ada session success
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#3b82f6'
            });
        @endif

        // Tampilkan alert jika ada session error
        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
        @endif

            document.querySelectorAll('.submenu-toggle').forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();

                let parent = this.parentElement;

                // toggle buka / tutup
                parent.classList.toggle('open');
            });
        });
    </script>
</body>
</html>