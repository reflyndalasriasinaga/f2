<?php
session_start();
require 'cek_session.php';
?




<?php
session_start();

// Cek apakah user sudah login atau belum. Jika belum, lempar balik ke index.php
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: index.php");
    exit;
}

// Proses Logout
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Reflynda Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Newsreader:ital,opsz,wght@0,6..72,500;1,6..72,400&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #fff0f3;
            --card-bg: rgba(255, 255, 255, 0.85);
            --card-border: rgba(255, 182, 193, 0.4);
            --text-main: #4a3b4c;
            --text-muted: #8c758f;
            --accent-gradient: linear-gradient(135deg, #ff758c 0%, #ff7eb3 50%, #fda4af 100%);
            --accent-color: #e11d48;
            --accent-hover: #be123c;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
        }

        header {
            width: 100%; padding: 20px 50px;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid var(--card-border);
            background: rgba(255, 240, 243, 0.85); backdrop-filter: blur(12px);
        }

        .nav-brand { display: flex; align-items: center; gap: 12px; }
        .nav-avatar {
            width: 38px; height: 38px; background: var(--accent-gradient);
            color: #fff; font-weight: 700; display: flex; align-items: center; justify-content: center; border-radius: 10px;
        }
        .nav-title { font-size: 14px; font-weight: 600; }
        .nav-subtitle { font-size: 11px; color: var(--text-muted); }

        .btn-logout {
            background-color: var(--accent-color); color: #fff;
            padding: 8px 16px; border-radius: 8px; text-decoration: none;
            font-size: 13px; font-weight: 600; transition: background 0.2s;
        }
        .btn-logout:hover { background-color: var(--accent-hover); }

        main {
            max-width: 1000px; margin: 40px auto; padding: 0 24px;
        }

        .welcome-banner {
            background: var(--card-bg); border: 1px solid var(--card-border);
            border-radius: 20px; padding: 30px; margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(255, 117, 140, 0.1);
        }
        .welcome-banner h1 { font-family: 'Newsreader', serif; font-size: 32px; font-weight: 500; margin-bottom: 8px; }
        .welcome-banner p { color: var(--text-muted); font-size: 14px; }

        .dashboard-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;
        }
        .dash-card {
            background: var(--card-bg); border: 1px solid var(--card-border);
            border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(255, 117, 140, 0.05);
        }
        .dash-card h3 { font-size: 14px; color: var(--text-muted); margin-bottom: 8px; }
        .dash-card .number { font-size: 24px; font-weight: 700; color: var(--accent-color); }

        .content-box {
            background: var(--card-bg); border: 1px solid var(--card-border);
            border-radius: 16px; padding: 24px;
        }
        .content-box h2 { font-size: 16px; font-weight: 600; margin-bottom: 14px; }
        .content-box p { font-size: 13px; color: var(--text-muted); line-height: 1.5; }

        .back-link {
            display: inline-block; margin-top: 20px; color: var(--accent-color); text-decoration: none; font-size: 13px; font-weight: 600;
        }
        .back-link:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            .dashboard-grid { grid-template-columns: 1fr; }
            header { padding: 16px 20px; }
        }
    </style>
</head>
<body>

    <header>
        <div class="nav-brand">
            <div class="nav-avatar">R</div>
            <div>
                <div class="nav-title">Reflynda Admin</div>
                <div class="nav-subtitle">Dashboard Panel</div>
            </div>
        </div>
        <a href="?logout=true" class="btn-logout">Logout</a>
    </header>

    <main>
        <div class="welcome-banner">
            <h1>Halo, <?php echo htmlspecialchars($_SESSION["username"]); ?>! 👋</h1>
            <p>Selamat datang di panel dashboard privat portofolio Anda. Sesi PHP Anda aktif dan aman.</p>
        </div>

        <div class="dashboard-grid">
            <div class="dash-card">
                <h3>Total Karya / Project</h3>
                <div class="number">1 Karya</div>
            </div>
            <div class="dash-card">
                <h3>Pengalaman Terdaftar</h3>
                <div class="number">1 Posisi</div>
            </div>
            <div class="dash-card">
                <h3>Status Sesi</h3>
                <div class="number" style="color: #059669; font-size: 18px; margin-top: 4px;">Aktif (Secure)</div>
            </div>
        </div>

        <div class="content-box">
            <h2>Pengaturan Konten Portfolio</h2>
            <p>Di masa mendatang, panel ini dapat dikembangkan lebih lanjut untuk menambah, mengedit, atau menghapus data riwayat edukasi, keterampilan, dan daftar project cerita kreatif Anda langsung dari database.</p>
            <a href="index.php" class="back-link">← Kembali ke Halaman Utama Portfolio</a>
        </div>
    </main>

</body>
</html>