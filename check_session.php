<?php
// pastikan session sudah aktif sebelum dicek
if (session_status() == PHP_SESSION_NONE) {
session_start();
}
if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
header('Location: login.php');
exit();
}
?>