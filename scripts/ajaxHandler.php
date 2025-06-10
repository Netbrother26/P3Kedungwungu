<?php
$page = $_POST['page'];

$viewPath = __DIR__ . '/../' . $page . '.php';

if (file_exists($viewPath)) {
    include($viewPath);
} else {
    echo "<p>Halaman tidak ditemukan.</p>";
}
?>
