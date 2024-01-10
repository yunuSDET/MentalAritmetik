<?php
// Session başlat
session_start();
define('BASE_PATH', '/');

// Kullanıcı oturumunu kontrol et
function checkUserSession() {
    
    if (!isset($_SESSION['user'])) {
        header('Location: login.php'); // Kullanıcı oturumu yoksa giriş sayfasına yönlendir
        exit();
    }
}

// Çıkış yap
function logout() {
    session_destroy();
    header('Location: login.php'); // Çıkış yapıldıktan sonra giriş sayfasına yönlendir
    exit();
}
?>
