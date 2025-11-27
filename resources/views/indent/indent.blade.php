<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Indent - Radar Kediri</title>
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

        .form-container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-header h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .form-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #2575fc;
            box-shadow: 0 0 0 0.2rem rgba(37, 117, 252, 0.25);
        }

        .btn-submit {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
            padding: 12px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 117, 252, 0.4);
        }

        .btn-group-custom {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-group-custom .btn {
            flex: 1;
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
                padding: 100px 15px 30px 15px;
            }
            .form-container {
                padding: 25px;
            }
            .btn-group-custom {
                flex-direction: column;
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

        <!-- Main Content -->
        <div class="main-content">
            <div class="form-container">
                <div class="form-header">
                    <h3><i class="fas fa-file-signature"></i> Form Indent</h3>
                    <p>Silakan lengkapi data indent Anda dengan benar</p>
                </div>

                <form action="{{ route('pendaftar.indent.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="mb-3">
                        <label for="asal_instansi" class="form-label">Asal Instansi <span class="text-danger">*</span></label>
                        <input type="text" name="asal_instansi" id="asal_instansi" class="form-control" placeholder="Contoh: Universitas Brawijaya" required>
                    </div>

                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan <span class="text-danger">*</span></label>
                        <input type="text" name="jurusan" id="jurusan" class="form-control" placeholder="Contoh: Teknik Informatika" required>
                    </div>

                    <div class="mb-3">
                        <label for="nim_nis" class="form-label">NIM / NIS <span class="text-danger">*</span></label>
                        <input type="text" name="nim_nis" id="nim_nis" class="form-control" placeholder="Masukkan NIM atau NIS" required>
                    </div>

                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="no_telepon" id="no_telepon" class="form-control" placeholder="Contoh: 08123456789" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" rows="3" class="form-control" placeholder="Masukkan alamat lengkap" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="berkas" class="form-label">Upload Berkas <span class="text-danger">*</span></label>
                        <input type="file" name="berkas[]" id="berkas" class="form-control" multiple required>
                        <small class="text-muted">Bisa upload lebih dari 1 file. Format yang diizinkan: PDF, DOC, DOCX. Maks 5MB per file.</small>
                    </div>

                    <div class="btn-group-custom">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-paper-plane"></i> Kirim Indent
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="logout-form" style="display: none;"></form>
</body>
</html>