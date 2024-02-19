<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tasks'])) {
    $userId = $_POST['userId'];
    $taskDataJson = $_POST['tasks'];
    $taskData = json_decode($taskDataJson, true);

    if ($taskData !== null) {
        // Veritabanı işlemleri
        $databaseFile = 'database.db'; // Veritabanı dosya adı
        $db = new SQLite3($databaseFile);

        // Güncelleme sorgusu
        $updateQuery = "UPDATE users SET task = :taskData WHERE id = :userId";
        $stmt = $db->prepare($updateQuery);

        // Parametreleri bağla
        $stmt->bindValue(':userId', $userId, SQLITE3_TEXT);
        $stmt->bindValue(':taskData', $taskDataJson, SQLITE3_TEXT);

        // Sorguyu çalıştır
        $result = $stmt->execute();

        if ($result !== false) {
            echo "Başarıyla kaydedildi";
        } else {
            echo "Veri kaydetme hatası: " . $db->lastErrorMsg();
        }

        // Veritabanı bağlantısını kapat
        $db->close();
    } else {
        echo "Görev verisi geçersiz JSON formatında";
    }
} else {
    echo "Geçersiz istek";
}
?>
