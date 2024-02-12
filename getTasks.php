<?php
// getTasks.php

include 'sessionManager.php';
checkUserSession();

$databaseFile = 'database.db'; // Veritabanı dosya adı
$db = new SQLite3($databaseFile);

if (isset($_SESSION['user'])) {
    $activeUserRole = $_SESSION['userRole'];
    $activeUserName = $_SESSION['user'];

    if ($activeUserName === 'admin') {
        // Admin ise
        $query = "SELECT id AS userId, task
                  FROM users
                  WHERE role = 'student'
                  ORDER BY id";
    } elseif ($activeUserRole === 'teacher') {
        // Öğretmen ise
        $query = "SELECT id AS userId, task
                  FROM users
                  WHERE teacher = :teacherName
                  ORDER BY id";
    }

    $resultStmt = $db->prepare($query);

    if ($activeUserRole === 'teacher') {
        $resultStmt->bindValue(':teacherName', $_SESSION['user'], SQLITE3_TEXT);
    }

    $result = $resultStmt->execute();

    $tasks = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $tasks[$row['userId']] = $row['task'];
    }

    // Veritabanı bağlantısını kapat
    $db->close();

    // JSON formatında çıktı ver
    header('Content-Type: application/json');
    echo json_encode($tasks);
} else {
    // Kullanıcı oturumu yoksa hata döndür
    header("HTTP/1.1 401 Unauthorized");
    echo "Unauthorized";
}
?>
