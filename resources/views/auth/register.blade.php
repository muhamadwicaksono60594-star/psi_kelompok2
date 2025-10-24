<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun - PKL Radar Kediri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 400px;
        }
        .card h3 {
            text-align: center;
            color: #667eea;
            margin-bottom: 25px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
        .text-center a {
            color: #667eea;
            text-decoration: none;
        }
        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <h3>Buat Akun</h3>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" 
                       class="form-control @error('nama_lengkap') is-invalid @enderror" 
                       value="{{ old('nama_lengkap') }}" required autofocus>
                @error('nama_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="jenjang">Role</label>
                <select name="jenjang" id="jenjang" 
                        class="form-control @error('role') is-invalid @enderror" required>
                    <option value="">-- Pilih Jenjang --</option>
                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>

        <div class="text-center mt-3">
            <span>Sudah punya akun?</span>
            <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>
</body>
</html>
