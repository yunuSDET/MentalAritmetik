<?php
$databaseFile = 'database.db';

// SQLite veritabanına bağlan
$pdo = new PDO('sqlite:' . $databaseFile);

// DATABASE var mı diye kontrol et, yoksa oluştur
if (!$pdo->query("SELECT * FROM sqlite_master WHERE type='table' AND name='users'")->fetch()) {
    $createTable = 'CREATE TABLE users (
       id INTEGER PRIMARY KEY AUTOINCREMENT,
       username TEXT NOT NULL,
       password TEXT,
       sure INT DEFAULT 0,
       puan INT DEFAULT 0,
       zaman_damgasi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )';
    $pdo->exec($createTable);
    echo "Database ve 'users' tablosu oluşturuldu.";
} else {
    echo "Database ve 'users' tablosu zaten var.";

  
}
?>
