<?php
// Veritabanı bağlantısı
try {
    $db = new PDO('sqlite:database.db');
} catch (PDOException $e) {
    die('Veritabanı bağlantısı başarısız: ' . $e->getMessage());
}

// POST verilerini al
$userId = isset($_POST['userId']) ? $_POST['userId'] : null;
$score = isset($_POST['score']) ? $_POST['score'] : null;
$time = isset($_POST['time']) ? $_POST['time'] : null;

if ($userId !== null && $score !== null && $time !== null) {
    // Veritabanına veriyi ekleme işlemleri
    $stmt = $db->prepare('INSERT INTO scores (userId, score) VALUES (:userId, :score)');
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':score', $score);
    $stmt->execute();

    $stmt = $db->prepare('INSERT INTO times (userId, time_seconds) VALUES (:userId, :time)');
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':time', $time);
    $stmt->execute();
}

?>