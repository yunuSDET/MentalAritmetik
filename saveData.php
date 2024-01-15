<?php
// Kullanıcının oturum (session) bilgilerini al
session_start();
$userId = $_SESSION['userId'];

// Puan bilgisini al
$earnedPoints = isset($_POST['earnedPoints']) ? $_POST['earnedPoints'] : null;

if ($userId !== null && $earnedPoints !== null) {
    // Veritabanına puanı ekleyin
    saveUserPoints($userId, $earnedPoints);
}

// Kullanıcının mevcut puanını güncelle
function saveUserPoints($userId, $points) {
    // Veritabanına kullanıcının yeni puanını ekleyin
    // Bu sorguyu veritabanı şemanıza uygun şekilde düzenleyin
    $db = new SQLite3("database.db");
    $query = "INSERT OR REPLACE INTO scores (userId, score) VALUES (:userId, :score)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId, SQLITE3_INTEGER);
    $statement->bindValue(':score', $points, SQLITE3_INTEGER);
    $statement->execute();
    $db->close();
}
?>