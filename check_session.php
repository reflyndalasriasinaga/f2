<?php
session_start();

// Periksa apakah session 'username' atau indicator login sudah ada
if (!isset($_SESSION['username'])) {
    // Jika belum login, alihkan ke halaman login
    header("Location: login.php");
    exit();
}
?>
<?php
session_start();

// 2. Cek apakah role-nya BUKAN admin
if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    // Jika bukan admin, alihkan ke halaman akses ditolak
    header("Location: akses  ditolak.php");
    exit();
}
?>

<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Menambahkan parameter URL ?pesan=belum_login
    header("Location: inde?pesan=belum_login");
    exit();
}
?>