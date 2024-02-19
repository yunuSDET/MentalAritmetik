<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $databaseFile = 'database.db'; // Veritabanı dosya adı
    $db = new SQLite3($databaseFile);

    // Veritabanından kullanıcı verilerini al
    $query = "SELECT * FROM users WHERE id = :userId";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':userId', $userId, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result !== false) {
        $userData = $result->fetchArray(SQLITE3_ASSOC);
        echo json_encode($userData);
    } else {
        echo "Veri çekme hatası: " . $db->lastErrorMsg();
    }

    // Veritabanı bağlantısını kapat
    $db->close();
} else {
    echo "Geçersiz istek";
}
?>
