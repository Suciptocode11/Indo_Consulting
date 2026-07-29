<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Indo Consulting</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 36px;
        }
        .login-header img {
            height: 48px;
            margin-bottom: 16px;
        }
        .login-header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #020220;
        }
        .login-header p {
            font-size: 14px;
            color: #64748b;
            margin-top: 4px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            color: #020220;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .form-group input:focus {
            border-color: #020220;
            box-shadow: 0 0 0 3px rgba(2,2,32,0.08);
        }
        .form-group .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        .form-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #020220;
        }
        .form-check label {
            font-size: 13px;
            color: #64748b;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #020220;
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-login:hover { opacity: 0.9; }
        .btn-login:active { transform: scale(0.98); }
        .back-link {
            text-align: center;
            margin-top: 24px;
        }
        .back-link a {
            font-size: 13px;
            color: #64748b;
            text-decoration: none;
        }
        .back-link a:hover { color: #020220; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1>Admin Panel</h1>
            <p>Indo Consulting</p>
        </div>

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan username"
                >
                @error('username')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                >
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="back-link">
            <a href="{{ route('home') }}">&larr; Kembali ke website</a>
        </div>
    </div>
</body>
</html>
