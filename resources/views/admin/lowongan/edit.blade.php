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
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .card.green {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }
        .card.yellow {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }
        .card.pink {
            background: linear-gradient(135deg, #fce7f3 0%, #f9a8d4 100%);
            color: #831843;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .count {
            font-size: 3rem;
            font-weight: 700; /* Bold angka */
        }
        .card.green .count {
            color: #065f46; /* Hijau gelap */
        }
        .card.yellow .count {
            color: #92400e; /* Kuning gelap */
        }
        .card.pink .count {
            color: #831843; /* Pink gelap */
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
        <h3>Edit Lowongan</h3>
        <form action="{{ route('admin.lowongan.update', $lowongan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Lowongan</label>
                <input type="text" name="judul" id="judul" class="form-control" value="{{ $lowongan->judul }}" required>
            </div>

            <div class="mb-3">
                <label for="divisi_id" class="form-label">Divisi</label>
                <select name="divisi_id" id="divisi_id" class="form-select" required>
                    <option value="">-- Pilih Divisi --</option>
                    @foreach ($divisi as $d)
                        <option value="{{ $d->id }}" {{ $lowongan->divisi_id == $d->id ? 'selected' : '' }}>
                            {{ $d->nama_divisi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ $lowongan->tanggal_mulai }}" required>
            </div>

            <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ $lowongan->tanggal_selesai }}" required>
            </div>

            <div class="mb-3">
                <label for="kuota" class="form-label">Kuota</label>
                <input type="number" name="kuota" id="kuota" class="form-control" value="{{ $lowongan->kuota }}" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" required>{{ $lowongan->deskripsi }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.lowongan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    </main>

    {{-- <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form> --}}

    <script>
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
    </script>
</body>
</html>
