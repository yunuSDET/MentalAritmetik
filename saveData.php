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
    $db = new SQLite3("database.db");

// Kullanıcının var olan skorunu kontrol et
$checkQuery = "SELECT * FROM scores WHERE userId = :userId AND zaman_damgasi = DATE('now')";
$checkStatement = $db->prepare($checkQuery);
$checkStatement->bindValue(':userId', $userId, SQLITE3_INTEGER);
$checkResult = $checkStatement->execute();

if ($existingScore = $checkResult->fetchArray()) {
    // Kullanıcı ve tarih varsa, skoru güncelle
    $newScore = $existingScore['score'] + $points; // Mevcut skora yeni skoru ekle
    $updateQuery = "UPDATE scores SET score = :newScore WHERE userId = :userId AND zaman_damgasi = DATE('now')";
    $updateStatement = $db->prepare($updateQuery);
    $updateStatement->bindValue(':userId', $userId, SQLITE3_INTEGER);
    $updateStatement->bindValue(':newScore', $newScore, SQLITE3_INTEGER);
    $updateStatement->execute();
} else {
    // Kullanıcı ve tarih yoksa, yeni kayıt ekle
    $insertQuery = "INSERT INTO scores (userId, score, zaman_damgasi) VALUES (:userId, :score, DATE('now'))";
    $insertStatement = $db->prepare($insertQuery);
    $insertStatement->bindValue(':userId', $userId, SQLITE3_INTEGER);
    $insertStatement->bindValue(':score', $points, SQLITE3_INTEGER);
    $insertStatement->execute();
}
    
    $db->close();
}
?>