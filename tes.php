<?php
session_start();
if (!isset($_SESSION['username'])) {
  echo "Akses ditolak. Silakan login.";
  exit;
}
?>

<h2>Selamat datang, <?= $_SESSION['username'] ?>!</h2>
<p>Ini adalah halaman dashboard.</p>