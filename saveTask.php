<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tasks'])) {
    $tasksJson = $_POST['tasks'];
    $tasks = json_decode($tasksJson, true);

    if ($tasks !== null) {
        $databaseFile = 'database.db'; // Veritabanı dosya adı
        $db = new SQLite3($databaseFile);

        foreach ($tasks as $userId => $task) {
            // Her bir kullanıcı için görevi güncelle
            $userId = $db->escapeString($userId);
            $task = $db->escapeString($task);

            $updateQuery = "UPDATE users SET task = '{$task}' WHERE id = '{$userId}'";
            $db->exec($updateQuery);
        }

        $db->close();
        echo "Başarıyla kaydedildi";
    } else {
        echo "Görevler boş veya geçersiz JSON formatında";
    }
} else {
    echo "Geçersiz istek";
}
?>
