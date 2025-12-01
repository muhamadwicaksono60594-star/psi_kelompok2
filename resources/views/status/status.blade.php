<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Status Pendaftar - Radar Kediri</title>

<!-- 🔹 CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- 🔹 CSS Rapi -->
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f6f9;
    color: #2c3e50;
    margin: 0;
    padding: 0;
}

.header {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: white;
    padding: 15px 25px;
    position: fixed;
    width: 100%;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* 🔸 Sidebar */
.sidebar {
    position: fixed;
    top: 60px;
    left: 0;
    width: 250px;
    height: calc(100vh - 60px);
    background: #2c3e50;
    color: white;
    overflow-y: auto;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
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

.sidebar-menu a:hover,
.sidebar-menu a.active {
    background: #34495e;
    padding-left: 30px;
}

/* 🔸 Konten Utama */
.main-content {
    margin-left: 250px;
    padding: 40px 30px;
}

.page-title {
    font-size: 26px;
    font-weight: 600;
    margin-bottom: 25px;
    color: #2c3e50;
}

/* 🔸 Kartu Status */
.status-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 25px;
}

.card-header-custom {
    padding: 18px 25px;
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-header-lowongan {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.card-header-indent {
    background: linear-gradient(135deg, #11998e, #38ef7d);
}

.card-body-custom {
    padding: 25px;
}

.pendaftaran-item {
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.pendaftaran-item:last-child {
    border-bottom: none;
}

.info-line {
    margin: 4px 0;
    color: #555;
    font-size: 14px;
}

.info-line i {
    width: 18px;
    color: #2575fc;
}

.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-transform: capitalize;
}

.badge.waiting {
    background-color: #f1c40f;
    color: #fff;
}

.badge.approved {
    background-color: #27ae60;
}

.badge.rejected {
    background-color: #e74c3c;
}

/* 🔹 Alasan Penolakan */
.alasan-box {
    background: #ffeaea;
    border-left: 4px solid #e74c3c;
    color: #a94442;
    padding: 12px 15px;
    border-radius: 8px;
    margin-top: 10px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.alasan-box i {
    color: #e74c3c;
}

/* 🔹 Tombol Surat */
.btn-surat {
    display: inline-block;
    margin-top: 10px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 14px;
    transition: 0.3s;
}

.btn-surat:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    color: #fff;
}

/* 🔹 Responsive */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
        padding: 20px;
    }
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }
}
.btn-cetak {
    display: inline-block;
    margin-top: 10px;
    margin-right: 6px;
    background: linear-gradient(135deg, #00b09b, #96c93d);
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 14px;
    transition: 0.3s;
}
.btn-cetak:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 176, 155, 0.4);
    color: #fff;
}
</style>
</head>
<body>

<div class="container-fluid">
    @include('sidebar.navbar')
    @include('sidebar.sidebarpendaftar')

    <div class="main-content">
        <h2 class="page-title"><i class="fas fa-clipboard-list"></i> Status Pendaftaran Anda</h2>

        <!-- 🔹 Status Lowongan -->
        <div class="status-card">
            <div class="card-header-custom card-header-lowongan">
                <i class="fas fa-briefcase"></i> Status Pendaftaran Lowongan
            </div>
            <div class="card-body-custom">
                @forelse($pendaftaran as $p)
                <div class="pendaftaran-item">
                    <strong><i class="fas fa-user"></i> {{ $p->nama }}</strong>
                    <div class="info-line"><i class="fas fa-building"></i> <b>Instansi:</b> {{ $p->asal_instansi }}</div>
                    <div class="info-line"><i class="fas fa-graduation-cap"></i> <b>Jurusan:</b> {{ $p->jurusan }}</div>
                    <div class="info-line"><i class="fas fa-id-card"></i> <b>NIM/NIS:</b> {{ $p->nim_nis }}</div>
                    <div class="info-line"><i class="fas fa-info-circle"></i> <b>Status:</b>
                        <span class="badge 
                            @if($p->status == 'diterima') approved 
                            @elseif($p->status == 'ditolak') rejected 
                            @else waiting @endif">
                            {{ ucfirst($p->status) }}
                        </span>
                    </div>

                    @if($p->status == 'ditolak' && $p->alasanPenolakan)
                    <div class="alasan-box">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span><b>Alasan Penolakan:</b> {{ $p->alasanPenolakan->alasan }}</span>
                    </div>  
                    @endif

                    @if($p->status != 'menunggu')
                        @php
                            $surat = \App\Models\SuratBalasan::where('pendaftar_id', $p->id)->first();
                        @endphp
                        @if($surat)
                            <a href="{{ asset('storage/' . $surat->file_path) }}" 
                            target="_blank"     
                            class="btn btn-outline-success mt-2">
                            <i class="bi bi-file-earmark-pdf"></i> Download Surat Balasan
                            </a>
                        @elseif($p  ->surat_balasan)
                            <a href="{{ asset('storage/' . $p->surat_balasan) }}" 
                            class="btn btn-outline-success mt-2" 
                            target="_blank">
                                <i class="fas fa-file-pdf"></i> Lihat Surat Balasan
                            </a>
                        @endif
                    @endif
                </div>
                @empty
                <p class="text-muted fst-italic">Belum ada pendaftaran lowongan.</p>
                @endforelse
            </div>
        </div>

        <!-- 🔹 Status Indent -->
        <div class="status-card">
            <div class="card-header-custom card-header-indent">
                <i class="fas fa-file-signature"></i> Status Pendaftaran Indent
            </div>
            <div class="card-body-custom">
                @forelse($indents as $i)
                <div class="pendaftaran-item">
                    <strong><i class="fas fa-user"></i> {{ $i->nama }}</strong>
                    <div class="info-line"><i class="fas fa-building"></i> <b>Instansi:</b> {{ $i->asal_instansi }}</div>
                    <div class="info-line"><i class="fas fa-graduation-cap"></i> <b>Jurusan:</b> {{ $i->jurusan }}</div>
                    <div class="info-line"><i class="fas fa-id-card"></i> <b>NIM/NIS:</b> {{ $i->nim_nis }}</div>
                    <div class="info-line"><i class="fas fa-calendar-alt"></i> <b>Periode:</b> 
                        {{ \Carbon\Carbon::parse($i->tanggal_mulai)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($i->tanggal_selesai)->format('d M Y') }}
                    </div>
                    <div class="info-line"><i class="fas fa-info-circle"></i> <b>Status:</b>
                        <span class="badge 
                            @if($i->status == 'diterima') approved 
                            @elseif($i->status == 'ditolak') rejected 
                            @else waiting @endif">
                            {{ ucfirst($i->status) }}
                        </span>
                    </div>

                    @if($i->status == 'ditolak' && $i->alasanPenolakan)
                    <div class="alasan-box">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span><b>Alasan Penolakan:</b> {{ $i->alasanPenolakan->alasan }}</span>
                    </div>
                    @endif

                    @if($i->status != 'menunggu')
                        @php
                            $surat = \App\Models\SuratBalasan::where('indent_id', $i->id)->first();
                        @endphp
                        @if($surat)
                            <a href="{{ asset('storage/' . $surat->file_path) }}" 
                            target="_blank" 
                            class="btn btn-outline-success mt-2">
                            <i class="bi bi-file-earmark-pdf"></i> Download Surat Balasan
                            </a>
                        @elseif($i->surat_balasan)
                            <a href="{{ asset('storage/' . $i->surat_balasan) }}" 
                            class="btn btn-outline-success mt-2" 
                            target="_blank">
                                <i class="fas fa-file-pdf"></i> Lihat Surat Balasan
                            </a>
                        @endif
                    @endif
                </div>
                @empty
                <p class="text-muted fst-italic">Belum ada pendaftaran indent.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

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
</html>
