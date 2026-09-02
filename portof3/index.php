<?php
// Inisialisasi sesi untuk autentikasi login
session_start();
// Simulasi data user untuk login sederhana
$valid_username = "reflynda";
$valid_password = "password123";
$login_error = "";

// Proses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $login_error = "Username atau password salah!";
    }
}
// Proses logout
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reflynda - Portfolio Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Newsreader:ital,opsz,wght@0,6..72,500;1,6..72,400&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #fff0f3;
            --card-bg: rgba(255, 255, 255, 0.75);
            --card-border: rgba(255, 182, 193, 0.4);
            --text-main: #4a3b4c;
            --text-muted: #8c758f;
            --accent-gradient: linear-gradient(135deg, #ff758c 0%, #ff7eb3 50%, #fda4af 100%);
            --accent-color: #e11d48;
            --accent-hover: #be123c;
            --tag-bg: rgba(255, 182, 193, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* --- ORNAMEN BACKGROUND PASTEL (Glowing Orbs & Grid) --- */
        .bg-glow-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 182, 193, 0.5) 0%, transparent 70%);
            z-index: -1;
            border-radius: 50%;
            filter: blur(40px);
        }

        .bg-glow-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(253, 164, 175, 0.4) 0%, transparent 70%);
            z-index: -1;
            border-radius: 50%;
            filter: blur(50px);
        }

        .bg-grid {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: linear-gradient(to right, rgba(225, 29, 72, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(225, 29, 72, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -1;
        }

        /* Navbar Header */
        header {
            width: 100%;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--card-border);
            background: rgba(255, 240, 243, 0.85);
            backdrop-filter: blur(12px);
            position: fixed;
            top: 0;
            z-index: 100;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-avatar {
            width: 38px;
            height: 38px;
            background: var(--accent-gradient);
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(255, 117, 140, 0.3);
        }

        .nav-title {
            font-size: 14px;
            font-weight: 600;
        }

        .nav-subtitle {
            font-size: 11px;
            color: var(--text-muted);
        }

        .nav-menu {
            display: flex;
            gap: 28px;
            list-style: none;
            align-items: center;
        }

        .nav-menu a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-menu a:hover, .nav-menu a.active {
            color: var(--accent-color);
        }

        .btn-login-nav {
            background-color: var(--accent-color);
            color: #fff !important;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px !important;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-login-nav:hover {
            background-color: var(--accent-hover);
        }

        /* Hero Section Container Utama */
        main {
            max-width: 1150px;
            margin: 130px auto 60px auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 50px;
            align-items: center;
        }

        /* Bagian Kiri: Teks & Elemen Rame */
        .hero-left {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .badge-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge-welcome, .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid rgba(255, 117, 140, 0.2);
        }

        .badge-welcome {
            background: rgba(255, 117, 140, 0.12);
            color: var(--accent-color);
        }

        .badge-status {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border-color: rgba(16, 185, 129, 0.2);
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            background-color: #059669;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.6);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(5, 150, 105, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(5, 150, 105, 0); }
        }

        .hero-title {
            font-family: 'Newsreader', serif;
            font-size: 48px;
            font-weight: 500;
            line-height: 1.15;
        }

        .gradient-text {
            background: var(--accent-gradient);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
        }

        .hero-desc {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
            max-width: 420px;
            font-weight: 300;
        }

        /* Statistik Box Rame (3 Kolom) */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 5px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid var(--card-border);
            padding: 14px;
            border-radius: 14px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: var(--accent-color);
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.9);
        }

        .stat-card h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--accent-color);
        }

        .stat-card p {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Floating Mini Badges / Keahlian Berderet */
        .floating-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 5px;
        }

        .ftag {
            background: var(--tag-bg);
            border: 1px solid var(--card-border);
            color: var(--text-main);
            font-size: 11px;
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        /* Tombol Aksi */
        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(225, 29, 72, 0.2);
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.6);
            color: var(--text-main);
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid var(--card-border);
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.9);
        }

        /* Bagian Kanan: Kartu Profil Rame dengan Tab Menu */
        .hero-right {
            display: flex;
            justify-content: center;
        }

        .profile-card {
            width: 100%;
            max-width: 440px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 20px 40px rgba(255, 117, 140, 0.15);
        }

        .card-header-profile {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
            border-bottom: 1px solid var(--card-border);
            padding-bottom: 16px;
        }

        .card-avatar-lg {
            width: 64px;
            height: 64px;
            background: var(--accent-gradient);
            color: #ffffff;
            font-family: 'Newsreader', serif;
            font-size: 26px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: 0 8px 20px rgba(255, 117, 140, 0.3);
        }

        .card-name {
            font-size: 18px;
            font-weight: 700;
        }

        .card-role {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Tombol Navigasi Tab di dalam Card */
        .card-tabs {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 4px;
            background: rgba(255, 182, 193, 0.25);
            padding: 4px;
            border-radius: 12px;
            margin-bottom: 16px;
        }

        .tab-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 600;
            padding: 8px 4px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .tab-btn.active {
            background: var(--accent-color);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(225, 29, 72, 0.25);
        }

        /* Konten Panel Tab */
        .tab-content-container {
            min-height: 250px;
            max-height: 280px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .tab-content-container::-webkit-scrollbar {
            width: 4px;
        }
        .tab-content-container::-webkit-scrollbar-thumb {
            background: rgba(255, 117, 140, 0.4);
            border-radius: 4px;
        }

        .tab-pane {
            display: none;
            flex-direction: column;
            gap: 8px;
        }

        .tab-pane.active {
            display: flex;
        }

        .card-item-box {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid var(--card-border);
            padding: 12px;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .card-item-box:hover {
            border-color: var(--accent-color);
            transform: translateX(2px);
            background: rgba(255, 255, 255, 0.95);
        }

        .item-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-main);
        }

        .item-subtitle {
            font-size: 11px;
            color: var(--accent-color);
            margin: 2px 0;
        }

        .item-desc {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 300;
        }

        /* Grid Skills dalam Card */
        .card-skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 8px;
        }

        .card-tag {
            background: var(--tag-bg);
            color: var(--accent-color);
            font-size: 11px;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 500;
            border: 1px solid var(--card-border);
        }

        /* Form Login Styling */
        .login-form-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .form-group label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-main);
        }

        .form-group input {
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid var(--card-border);
            background: rgba(255, 255, 255, 0.8);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            color: var(--text-main);
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: var(--accent-color);
        }

        .error-msg {
            background: rgba(225, 29, 72, 0.1);
            color: var(--accent-color);
            font-size: 11px;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid rgba(225, 29, 72, 0.2);
            text-align: center;
        }

        .success-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 12px;
            padding: 20px 0;
        }

        .success-box h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
        }

        .success-box p {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Modal Overlay untuk Halaman Login */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(74, 59, 76, 0.4);
            backdrop-filter: blur(5px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .login-modal-card {
            background: var(--bg-color);
            border: 1px solid var(--card-border);
            padding: 30px;
            border-radius: 24px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 20px 40px rgba(255, 117, 140, 0.25);
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 18px;
            color: var(--text-muted);
            cursor: pointer;
        }

        /* Responsif Mobile */
        @media (max-width: 768px) {
            header {
                padding: 16px 20px;
            }
            .nav-menu {
                display: none;
            }
            main {
                grid-template-columns: 1fr;
                margin-top: 100px;
                gap: 30px;
                text-align: center;
            }
            .hero-left {
                text-align: center;
                align-items: center;
            }
            .badge-container {
                justify-content: center;
            }
            .action-buttons {
                width: 100%;
                flex-direction: column;
            }
            .floating-tags {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>
    <div class="bg-grid"></div>

    <header>
        <div class="nav-brand">
            <div class="nav-avatar" id="navInitials">R</div>
            <div>
                <div class="nav-title">Reflynda</div>
                <div class="nav-subtitle">Portfolio</div>
            </div>
        </div>
        <ul class="nav-menu">
            <li><a href="#" class="active">Home</a></li>
            <li><a href="#portfolio">Portfolio</a></li>
            <li>
                <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true): ?>
                    <a href="?logout=true" class="btn-login-nav">Logout (<?php echo htmlspecialchars($_SESSION["username"]); ?>)</a>
                <?php else: ?>
                    <a href="#" onclick="toggleLoginModal(true); return false;" class="btn-login-nav">Login</a>
                <?php endif; ?>
            </li>
        </ul>
    </header>

    <div class="modal-overlay" id="loginModal">
        <div class="login-modal-card">
            <button class="modal-close" onclick="toggleLoginModal(false)">&times;</button>
            <div class="card-header-profile" style="margin-bottom: 12px; border:none; padding:0;">
                <div class="card-avatar-lg" style="width: 48px; height: 48px; font-size: 20px;">R</div>
                <div>
                    <div class="card-name" style="font-size: 16px;">Admin Login</div>
                    <div class="card-role">Akses Portfolio Dashboard</div>
                </div>
            </div>

            <?php if (!empty($login_error)): ?>
                <div class="error-msg" style="margin-bottom: 12px;"><?php echo $login_error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" class="login-form-container">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username..." required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password..." required>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%; margin-top: 6px;">Masuk Sekarang</button>
            </form>
        </div>
    </div>

    <main>
        <section class="hero-left">
            <div class="badge-container">
                <div class="badge-welcome">✨ Selamat Datang</div>
                <div class="badge-status">
                    <div class="pulse-dot"></div> Open for Project
                </div>
            </div>

            <h1 class="hero-title">Halo, Saya <br><span class="gradient-text" id="heroName">Reflynda</span></h1>
            <p class="hero-desc" id="heroBio">Membuat cerita yang menginspirasi dan menghibur melalui tulisan kreatif serta pengembangan web interaktif.</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3 id="statProjects">1+</h3>
                    <p>Projects</p>
                </div>
                <div class="stat-card">
                    <h3 id="statExp">1</h3>
                    <p>Pengalaman</p>
                </div>
                <div class="stat-card">
                    <h3 id="statSkills">3</h3>
                    <p>Skills</p>
                </div>
            </div>

            <div class="floating-tags">
                <span class="ftag">✍️ Storytelling</span>
                <span class="ftag">🎨 UI/UX Design</span>
                <span class="ftag">⚡ Creative Writer</span>
            </div>

            <div class="action-buttons">
                <a href="#portfolio" class="btn-primary" style="display:inline-flex; align-items:center; justify-content:center;">Lihat Project ↗</a>
                <a href="#" class="btn-secondary" id="hallButton">Hall of Creations</a>
            </div>
        </section>

        <section class="hero-right">
            <div class="profile-card">
                
                <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true): ?>
                    <div class="card-header-profile">
                        <div class="card-avatar-lg">R</div>
                        <div>
                            <div class="card-name">Dashboard Admin</div>
                            <div class="card-role">Selamat datang kembali, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</div>
                        </div>
                    </div>
                    <div class="success-box">
                        <h3>Autentikasi Berhasil 🎉</h3>
                        <p>Anda memiliki akses penuh untuk melakukan pengelolaan data portofolio melalui sesi PHP aktif ini.</p>
                        <a href="?logout=true" class="btn-primary" style="margin-top: 10px; width: 100%; text-align:center; text-decoration:none;">Keluar Sesi (Logout)</a>
                    </div>
                <?php else: ?>
                    <div class="card-header-profile">
                        <div class="card-avatar-lg" id="cardAvatar">R</div>
                        <div>
                            <div class="card-name" id="cardName">Reflynda</div>
                            <div class="card-role" id="cardRole">Creative Writer & Programmer</div>
                        </div>
                    </div>

                    <div class="card-tabs">
                        <button class="tab-btn active" onclick="switchTab('projects', event)">Karya</button>
                        <button class="tab-btn" onclick="switchTab('experience', event)">Kerja</button>
                        <button class="tab-btn" onclick="switchTab('education', event)">Edu</button>
                        <button class="tab-btn" onclick="switchTab('skills', event)">Skills</button>
                    </div>

                    <div class="tab-content-container">
                        
                        <div id="tab-projects" class="tab-pane active">
                            <div id="projectsContainer"></div>
                        </div>

                        <div id="tab-experience" class="tab-pane">
                            <div id="experienceContainer"></div>
                        </div>

                        <div id="tab-education" class="tab-pane">
                            <div id="educationContainer"></div>
                        </div>

                        <div id="tab-skills" class="tab-pane">
                            <div class="card-skills-grid" id="skillsContainer"></div>
                        </div>

                    </div>
                <?php endif; ?>

            </div>
        </section>
    </main>

    <script>
        const profileData = {
            name: "Reflynda",
            role: "Creative Writer & Programmer",
            bio: "Membuat cerita yang menginspirasi dan menghibur melalui tulisan kreatif serta pengembangan web interaktif.",
            projects: [
                { title: "The Lost Melody", desc: "Seorang komposer muda yang ingatannya terhapus setiap hari perlahan jatuh cinta pada gadis yang diam-diam menjadi penjaga seluruh sisa lagunya." }
            ],
            experiences: [
                { role: "Narrative Writer", place: "Wattpad AU Community", period: "2020 - Sekarang", desc: "Mengikuti pembelajaran dan pengembangan keterampilan menulis cerita interaktif." }
            ],
            educations: [
                { degree: "TK Santo Fransiskus", institution: "TK Santo Fransiskus", period: "2010 - 2016", desc: "Pendidikan Anak Usia Dini." },
                { degree: "SD NEGERI 005", institution: "SD NEGERI 005", period: "2016 - 2022", desc: "Pendidikan Dasar." },
                { degree: "SMP NEGERI 27", institution: "SMP NEGERI 27", period: "2022 - 2025", desc: "Pendidikan Menengah Pertama." },
                { degree: "SMK TI AIRLANGGA", institution: "SMK TI AIRLANGGA", period: "2025 - Sekarang", desc: "Pendidikan Kejuruan Teknologi Informasi." }
            ],
            skills: ["Creative Writing", "Plot Development", "Editing"],
            hallLink: "#"
        };

        // Fungsi Modal Login Toggle
        function toggleLoginModal(show) {
            const modal = document.getElementById('loginModal');
            if (show) {
                modal.classList.add('active');
            } else {
                modal.classList.remove('active');
            }
        }

        // Fungsi Tab Switcher
        function switchTab(tabName, event) {
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('active');
            });
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            const targetPane = document.getElementById('tab-' + tabName);
            if (targetPane) targetPane.classList.add('active');
            if (event && event.currentTarget) event.currentTarget.classList.add('active');
        }

        // Render DOM
        document.addEventListener("DOMContentLoaded", () => {
            // Header & Hero Section Text
            const heroNameEl = document.getElementById("heroName");
            if (heroNameEl) heroNameEl.textContent = profileData.name;
            
            const heroBioEl = document.getElementById("heroBio");
            if (heroBioEl) heroBioEl.textContent = profileData.bio;
            
            const cardNameEl = document.getElementById("cardName");
            if (cardNameEl) cardNameEl.textContent = profileData.name;
            
            const cardRoleEl = document.getElementById("cardRole");
            if (cardRoleEl) cardRoleEl.textContent = profileData.role;

            const statProjEl = document.getElementById("statProjects");
            if (statProjEl) statProjEl.textContent = profileData.projects.length + "+";
            
            const statExpEl = document.getElementById("statExp");
            if (statExpEl) statExpEl.textContent = profileData.experiences.length;
            
            const statSkillsEl = document.getElementById("statSkills");
            if (statSkillsEl) statSkillsEl.textContent = profileData.skills.length;

            // Render Projects
            const projContainer = document.getElementById("projectsContainer");
            if (projContainer) {
                profileData.projects.forEach(p => {
                    const box = document.createElement("div");
                    box.className = "card-item-box";
                    box.innerHTML = `<div class="item-title">${p.title}</div><div class="item-desc">${p.desc}</div>`;
                    projContainer.appendChild(box);
                });
            }

            // Render Experiences
            const expContainer = document.getElementById("experienceContainer");
            if (expContainer) {
                profileData.experiences.forEach(e => {
                    const box = document.createElement("div");
                    box.className = "card-item-box";
                    box.innerHTML = `<div class="item-title">${e.role}</div><div class="item-subtitle">${e.place} • ${e.period}</div><div class="item-desc">${e.desc}</div>`;
                    expContainer.appendChild(box);
                });
            }

            // Render Educations
            const eduContainer = document.getElementById("educationContainer");
            if (eduContainer) {
                profileData.educations.forEach(ed => {
                    const box = document.createElement("div");
                    box.className = "card-item-box";
                    box.innerHTML = `<div class="item-title">${ed.degree}</div><div class="item-subtitle">${ed.institution} • ${ed.period}</div><div class="item-desc">${ed.desc}</div>`;
                    eduContainer.appendChild(box);
                });
            }

            // Render Skills
            const skillContainer = document.getElementById("skillsContainer");
            if (skillContainer) {
                profileData.skills.forEach(s => {
                    const tag = document.createElement("span");
                    tag.className = "card-tag";
                    tag.textContent = s;
                    skillContainer.appendChild(tag);
                });
            }

            // Link Tombol
            const hallBtn = document.getElementById("hallButton");
            if (hallBtn) hallBtn.href = profileData.hallLink;
        });
    </script>
</body>
</html>