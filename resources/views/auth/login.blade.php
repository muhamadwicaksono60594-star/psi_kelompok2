<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pendaftaran PKL Radar Kediri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: flex;
            max-width: 800px;
            width: 100%;
            transition: transform 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
        }
        
        .login-left {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
            padding: 50px 30px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .login-left h2 {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.3;
            z-index: 2;
            position: relative;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 30px;
        }
        
        .logo-container {
            position: relative;
            z-index: 2;
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 50%;
            backdrop-filter: blur(5px);
            border: 2px solid rgba(255,255,255,0.2);
            transition: transform 0.3s ease;
        }
        
        .logo-container:hover {
            transform: scale(1.05);
        }
        
        .login-left img {
            max-width: 100px;
            height: 100px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }
        
        .subtitle {
            margin-top: 20px;
            font-size: 16px;
            opacity: 0.9;
            z-index: 2;
            position: relative;
        }
        
        .login-right {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-right h4 {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            padding: 15px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #51cf66, #40c057);
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #ff6b6b, #fa5252);
            color: white;
        }
        
        .form-control {
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-label,
        label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .mb-3 {
            margin-bottom: 20px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn-outline-primary {
            color: #667eea;
            border: 2px solid #667eea;
            background: transparent;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-outline-primary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .text-center {
            text-align: center;
        }
        
        .mt-2 {
            margin-top: 8px;
        }
        
        .mt-3 {
            margin-top: 20px;
        }
        
        .w-100 {
            width: 100%;
        }
        
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                max-width: 400px;
            }
            
            .login-left {
                padding: 30px 20px;
            }
            
            .login-left h2 {
                font-size: 24px;
            }
            
            .login-right {
                padding: 30px 20px;
            }
            
            .login-right h4 {
                font-size: 28px;
            }
        }
        
        /* Additional styling for better visual hierarchy */
        .login-right form {
            margin-bottom: 20px;
        }
        
        .login-right span {
            color: #666;
            font-size: 14px;
        }
        
        /* Input focus animations */
        .form-control::placeholder {
            color: #999;
        }
        
        /* Button loading state support */
        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <!-- Left Section -->
        <div class="login-left">
            <h2>Pendaftaran Praktik Kerja Lapangan dan Magang</h2>
            <div class="logo-container">
                <img src="{{ asset('images/rk2.png') }}" alt="Radar Kediri Logo">
            </div>
            <p class="subtitle">Sistem Informasi Pendaftaran Praktik Kerja Lapangan dan Magang<br>Radar Kediri</p>
        </div>

        <!-- Right Section -->
        <div class="login-right">
            <h4 class="mb-4 text-center">Login</h4>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan Email" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>

            <div class="text-center mt-3">
                <span>Belum punya akun?</span>
                <a href="{{ route('register') }}" class="btn btn-outline-primary mt-2">Buat</a>
            </div>
        </div>
    </div>

    <script>
        // Simple focus effects for better UX
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>