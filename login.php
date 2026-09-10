<?php
session_start();

// ==========================================
// 1. CEK SESSION & ROLE (Nomor 1 & Nomor 2)
// ==========================================
function cek_session($role_required = null) {
    // Nomor 1: Jika belum login, lempar ke halaman login dengan pesan
    if (!isset($_SESSION['username'])) {
        header("Location: index.php?page=login&pesan=belum_login");
        exit();
    }

    // Nomor 2: Pengecekan role (jika bukan 'admin', lempar ke akses_ditolak)
    if ($role_required && isset($_SESSION['role']) && $_SESSION['role'] !== $role_required) {
        header("Location: index.php?page=akses_ditolak");
        exit();
    }
}

// ==========================================
// PROSES LOGIN & LOGOUT (Simulasi)
// ==========================================
$action = $_GET['action'] ?? '';

if ($action === 'do_login') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Akun Pengujian:
    // Username: admin  | Pass: 123 | Role: admin
    // Username: user   | Pass: 123 | Role: member
    if ($username === 'admin' && $password === '123') {
        $_SESSION['username'] = 'admin';
        $_SESSION['role'] = 'admin';
        header("Location: index.php?page=dashboard");
        exit();
    } elseif ($username === 'user' && $password === '123') {
        $_SESSION['username'] = 'user';
        $_SESSION['role'] = 'member';
        header("Location: index.php?page=profil");
        exit();
    } else {
        header("Location: index.php?page=login&pesan=gagal");
        exit();
    }
}

if ($action === 'logout') {
    session_destroy();
    header("Location: index.php?page=login");
    exit();
}

$page = $_GET['page'] ?? 'login';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Proteksi Session</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f9f9f9; }
        .card { background: white; padding: 20px; border-radius: 8px; max-width: 400px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .alert { background-color: #ffe6e6; color: #d9534f; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #f5c6cb; }
        input { width: 100%; padding: 8px; margin: 8px 0; box-sizing: border-box; }
        button { background-color: #e91e63; color: white; border: none; padding: 10px; width: 100%; border-radius: 5px; cursor: pointer; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #333; font-weight: bold; }
    </style>
</head>
<body>

<nav>
    <a href="index.php?page=login">Login</a>
    <a href="index.php?page=dashboard">Dashboard (Khusus Admin)</a>
    <a href="index.php?page=profil">Profil Saya</a>
</nav>

<div class="card">
    <?php
    // ==========================================
    // NOMOR 3: HALAMAN LOGIN & PESAN PERINGATAN
    // ==========================================
    if ($page === 'login'): 
    ?>
        <h2>Form Login</h2>

        <?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'belum_login'): ?>
            <div class="alert">⚠️ Silakan login terlebih dahulu.</div>
        <?php elseif (isset($_GET['pesan']) && $_GET['pesan'] === 'gagal'): ?>
            <div class="alert">❌ Username atau password salah!</div>
        <?php endif; ?>

        <form action="index.php?action=do_login" method="POST">
            <label>Username:</label>
            <input type="text" name="username" required placeholder="admin / user">
            <label>Password:</label>
            <input type="password" name="password" required placeholder="123">
            <button type="submit">Masuk</button>
        </form>
        <p><small>Hint: Admin (admin/123) | User biasa (user/123)</small></p>

    <?php 
    // ==========================================
    // NOMOR 1 & 2: DASHBOARD (PROTEKSI ADMIN)
    // ==========================================
    elseif ($page === 'dashboard'): 
        cek_session('admin'); // Memastikan login & role = admin
    ?>
        <h2>Halaman Dashboard</h2>
        <p>Selamat datang, <strong><?php echo $_SESSION['username']; ?></strong>!</p>
        <p>Role Anda: <strong><?php echo $_SESSION['role']; ?></strong></p>
        <a href="index.php?action=logout">Logout</a>

    <?php 
    // ==========================================
    // NOMOR 4: HALAMAN PROFIL (PROTEKSI USER/MEMBER)
    // ==========================================
    elseif ($page === 'profil'): 
        cek_session(); // Memastikan pengguna sudah login
    ?>
        <h2>Halaman Profil</h2>
        <p><strong>Username:</strong> <?php echo $_SESSION['username']; ?></p>
        <p><strong>Role:</strong> <?php echo $_SESSION['role']; ?></p>
        <a href="index.php?action=logout">Logout</a>

    <?php 
    // HALAMAN AKSES DITOLAK (PENGALIHAN NOMOR 2)
    elseif ($page === 'akses_ditolak'): 
    ?>
        <h2 style="color: red;">Akses Ditolak!</h2>
        <p>Maaf, halaman ini hanya bisa diakses oleh <strong>Admin</strong>.</p>
        <a href="index.php?page=profil">Kembali ke Profil</a> | 
        <a href="index.php?action=logout">Logout</a>
    <?php endif; ?>
</div>

<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>