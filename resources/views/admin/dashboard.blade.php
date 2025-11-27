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
        <h2 class="mb-4 text-center fw-bold">📊 Dashboard Rekap Pendaftaran</h2>
        <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label for="tahun" class="form-label">Filter Tahun</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @foreach ($tahunList as $t)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Filter Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
        <div class="row g-3">
            <!-- Total Pendaftar -->
            <div class="col-md-3">
                <a href="{{ route('admin.card.detail', 'total') }}" class="text-decoration-none">
                    <div class="card bg-primary text-white p-4 text-center">
                        <h4>Total Pendaftar</h4>
                        <h2>{{ $totalPendaftar }}</h2>
                    </div>
                </a>
            </div>

            <!-- Diterima -->
            <div class="col-md-3">
                <a href="{{ route('admin.card.detail', 'diterima') }}" class="text-decoration-none">
                    <div class="card bg-success text-white p-4 text-center">
                        <h4>Diterima</h4>
                        <h2>{{ $pendaftarDiterima }}</h2>
                    </div>
                </a>
            </div>

            <!-- Ditolak -->
            <div class="col-md-3">
                <a href="{{ route('admin.card.detail', 'ditolak') }}" class="text-decoration-none">
                    <div class="card bg-danger text-white p-4 text-center">
                        <h4>Ditolak</h4>
                        <h2>{{ $pendaftarDitolak }}</h2>
                    </div>
                </a>
            </div>

            <!-- Menunggu -->
            <div class="col-md-3">
                <a href="{{ route('admin.card.detail', 'menunggu') }}" class="text-decoration-none">
                    <div class="card" style="background:#ff00ff; color:white; padding:20px; text-align:center;">
                        <h4>Menunggu</h4>
                        <h2>{{ $pendaftarMenunggu }}</h2>
                    </div>
                </a>
            </div>

            <!-- Indent -->
            <div class="col-md-3">
                <a href="{{ route('admin.card.detail', 'indent') . '?' . http_build_query(request()->query())  }}" class="text-decoration-none">
                    <div class="card bg-warning text-dark p-4 text-center">
                        <h4>Pendaftar Indent</h4>
                        <h2>{{ $pendaftarIndent }}</h2>
                    </div>
                </a>
            </div>

            <!-- Lowongan -->
            <div class="col-md-3">
                <a href="{{ route('admin.card.detail', 'lowongan') }}" class="text-decoration-none">
                    <div class="card bg-info text-white p-4 text-center">
                        <h4>Pendaftar Lowongan</h4>
                        <h2>{{ $pendaftarLowongan }}</h2>
                    </div>
                </a>
            </div>

        <!-- Kartu Statistik -->
        <div class="row g-4">
            <!-- A. Pie Chart -->
            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5 class="text-center fw-semibold">Perbandingan Mahasiswa vs Siswa</h5>
                    <canvas id="pieChart" height="250"></canvas>
                </div>
            </div>

            <!-- B. Bar Chart -->
            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5 class="text-center fw-semibold">Jumlah Pendaftar per Bulan</h5>
                    <canvas id="barChart" height="250"></canvas>
                </div>
            </div>

            <!-- C. Line Chart -->
            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5 class="text-center fw-semibold">Tren Kenaikan / Penurunan Pendaftar</h5>
                    <canvas id="lineChart" height="250"></canvas>
                </div>
            </div>

            <!-- D. Horizontal Bar Chart -->
            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5 class="text-center fw-semibold">Ranking Asal Instansi Terbanyak</h5>
                    <canvas id="horizontalBarChart" height="250"></canvas>
                </div>
            </div>
        </div>  
    </main>

    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxBar = document.getElementById('grafikPendaftaran');
        const ctxPie = document.getElementById('pieChart');
    // === A. Pie Chart ===
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: @json($pieData['labels']),
            datasets: [{
                data: @json($pieData['data']),
                backgroundColor: ['#36A2EB', '#4CAF50']
            }]
        }
    });

    // === B. Bar Chart (Pendaftar per Bulan) ===
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: @json($bulanLabels),
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: @json($jumlahPendaftar),
                backgroundColor: '#2196F3'
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });

    // === C. Line Chart ===
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: @json($lineLabels),
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: @json($lineData),
                fill: false,
                borderColor: '#9C27B0',
                tension: 0.3
            }]
        }
    });

    // === D. Horizontal Bar Chart (Ranking Instansi) ===
    new Chart(document.getElementById('horizontalBarChart'), {
        type: 'bar',
        data: {
            labels: @json($instansiLabels),
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: @json($instansiTotal),
                backgroundColor: '#FF9800'
            }]
        },
        options: {
            indexAxis: 'y',
            scales: { x: { beginAtZero: true } }
        }
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

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.card-stat').forEach(card => {
                card.addEventListener('click', () => {
                    const type = card.dataset.type;

                    const tahun = document.getElementById('tahun').value;
                    const status = document.getElementById('status').value;

                    fetch(`/dashboard/detail-stat?type=${type}&tahun=${tahun}&status=${status}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.error) {
                                Swal.fire('Oops', data.error, 'error');
                                return;
                            }

                            let html = '<ul class="list-group text-start">';
                            data.list.forEach(item => {
                                html += `<li class="list-group-item">
                                    <strong>${item.nama}</strong><br>
                                    <small>${item.asal_instansi ?? '-'} - 
                                    <span class="text-primary">${item.status}</span></small>
                                </li>`;
                            });
                            html += '</ul>';

                            Swal.fire({
                                title: `Detail ${data.title}`,
                                html: html,
                                width: 600,
                                showCloseButton: true,
                                confirmButtonText: 'Tutup',
                            });
                        })
                        .catch(() => Swal.fire('Error', 'Gagal mengambil data', 'error'));
                });
            });
        });
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
