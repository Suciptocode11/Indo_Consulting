<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Indo Consulting</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Outfit', sans-serif;
            background: #020220;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        .bg-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .bg-glow-1 { top: 20%; left: -10%; width: 400px; height: 400px; background: rgba(187, 0, 39, 0.15); }
        .bg-glow-2 { bottom: 10%; right: -5%; width: 350px; height: 350px; background: rgba(30, 41, 59, 0.5); }
        .content { text-align: center; position: relative; z-index: 10; padding: 2rem; }
        .error-code {
            font-size: clamp(120px, 20vw, 200px);
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #bb0027, #ff4060);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
        }
        h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        p {
            font-size: 16px;
            color: rgba(255,255,255,0.6);
            max-width: 420px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }
        .btn-group { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 980px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.32, 0.72, 0, 1);
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: #bb0027;
            color: white;
        }
        .btn-primary:hover { background: #9a001f; transform: scale(1.05); }
        .btn-ghost {
            background: transparent;
            color: white;
            border: 1.5px solid rgba(255,255,255,0.35);
        }
        .btn-ghost:hover { background: rgba(255,255,255,0.1); }
        .material-symbols-outlined { font-size: 20px; }
    </style>
</head>
<body>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>
    <div class="content">
        <div class="error-code">404</div>
        <h1>Halaman Tidak Ditemukan</h1>
        <p>Halaman yang Anda cari sudah dipindahkan, dihapus, atau tidak pernah ada. Mari kita kembali ke halaman utama.</p>
        <div class="btn-group">
            <a href="/" class="btn btn-primary">
                <span class="material-symbols-outlined">home</span>
                Kembali ke Beranda
            </a>
            <a href="javascript:history.back()" class="btn btn-ghost">
                <span class="material-symbols-outlined">arrow_back</span>
                Halaman Sebelumnya
            </a>
        </div>
    </div>
</body>
</html>
