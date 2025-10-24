<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RadarKediri - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


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
        <div class="container-fluid">
            <div class="content-header">
                <h2>Daftar Lowongan</h2>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahLowonganModal">
                    + Tambah Lowongan
                </button>
            </div>
            
            <div class="card">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Divisi</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Kuota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lowongan as $item)
                        <tr>
                            <td>{{ $item->divisi->nama_divisi }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}</td>
                            <td>{{ $item->kuota }}</td>
                            <td>
                                <a href="{{ route('admin.lowongan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.lowongan.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Tambah Lowongan -->
    <div class="modal fade" id="tambahLowonganModal" tabindex="-1" aria-labelledby="tambahLowonganLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahLowonganLabel">Tambah Lowongan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Form Laravel --}}
                <form action="{{ route('admin.lowongan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Lowongan</label>
                            <input type="text" name="judul" id="judul" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="divisi_id" class="form-label">Divisi</label>
                            <select name="divisi_id" id="divisi_id" class="form-select" required>
                                <option value="">-- Pilih Divisi --</option>
                                @foreach ($divisi as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama_divisi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="kuota" class="form-label">Kuota</label>
                            <input type="number" name="kuota" id="kuota" class="form-control" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Handle form submit
        document.getElementById('formTambahLowongan').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Ambil data dari form
            const judul = document.getElementById('judul').value;
            const divisi = document.getElementById('divisi_id').options[document.getElementById('divisi_id').selectedIndex].text;
            
            // Tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('tambahLowonganModal'));
            modal.hide();
            
            // Tampilkan notifikasi sukses
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Lowongan berhasil ditambahkan',
                timer: 2000,
                showConfirmButton: false
            });
            
            // Reset form
            this.reset();
        });



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
                    Swal.fire(
                        'Berhasil!',
                        'Anda telah logout.',
                        'success'
                    )
                }
            });
        }
    </>
</body>
</html>