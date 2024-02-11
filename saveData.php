<?php
session_start();
$userId = $_SESSION['userId'];
$earnedPoints = isset($_POST['earnedPoints']) ? $_POST['earnedPoints'] : null;
$earnedTime = isset($_POST['earnedTime']) ? $_POST['earnedTime'] : null;
$pageName =isset($_POST['pageName']) ? $_POST['pageName'] : null;



if ($userId !== null && $earnedPoints !== null && $pageName !== null) {
    saveUserPoints($userId, $earnedPoints, $pageName);
}

if ($userId !== null && $earnedTime !== null && $pageName !== null) {
    saveUserTime($userId, $earnedTime, $pageName);
}


function saveUserPoints($userId, $points, $pageName) {
    $db = new SQLite3("database.db");

    $checkQuery = "SELECT * FROM scores WHERE userId = :userId AND zaman_damgasi = DATE('now') AND pageName = :pageName";
    $checkStatement = $db->prepare($checkQuery);
    $checkStatement->bindValue(':userId', $userId, SQLITE3_INTEGER);
    $checkStatement->bindValue(':pageName', $pageName, SQLITE3_TEXT);
    $checkResult = $checkStatement->execute();

    if ($existingScore = $checkResult->fetchArray()) {
        $newScore = $existingScore['score'] + $points;
        $updateQuery = "UPDATE scores SET score = :newScore WHERE userId = :userId AND zaman_damgasi = DATE('now') AND pageName = :pageName";
        $updateStatement = $db->prepare($updateQuery);
        $updateStatement->bindValue(':userId', $userId, SQLITE3_INTEGER);
        $updateStatement->bindValue(':newScore', $newScore, SQLITE3_INTEGER);
        $updateStatement->bindValue(':pageName', $pageName, SQLITE3_TEXT);
        $updateStatement->execute();
    } else {
        $insertQuery = "INSERT INTO scores (userId, score, zaman_damgasi, pageName) VALUES (:userId, :score, DATE('now'), :pageName)";
        $insertStatement = $db->prepare($insertQuery);
        $insertStatement->bindValue(':userId', $userId, SQLITE3_INTEGER);
        $insertStatement->bindValue(':score', $points, SQLITE3_INTEGER);
        $insertStatement->bindValue(':pageName', $pageName, SQLITE3_TEXT);
        $insertStatement->execute();
    }

    $db->close();
}



function saveUserTime($userId, $time, $pageName) {
    $db = new SQLite3("database.db");

    $checkQuery = "SELECT * FROM times WHERE userId = :userId AND zaman_damgasi = DATE('now') AND pageName = :pageName";
    $checkStatement = $db->prepare($checkQuery);
    $checkStatement->bindValue(':userId', $userId, SQLITE3_INTEGER);
    $checkStatement->bindValue(':pageName', $pageName, SQLITE3_TEXT);
    $checkResult = $checkStatement->execute();

    if ($existingScore = $checkResult->fetchArray()) {
        $newTime = $existingScore['time_seconds'] + $time;
        $updateQuery = "UPDATE times SET time_seconds = :newTime WHERE userId = :userId AND zaman_damgasi = DATE('now') AND pageName = :pageName";
        $updateStatement = $db->prepare($updateQuery);
        $updateStatement->bindValue(':userId', $userId, SQLITE3_INTEGER);
        $updateStatement->bindValue(':newTime', $newTime, SQLITE3_INTEGER); // :time yerine :newTime kullanıldı
        $updateStatement->bindValue(':pageName', $pageName, SQLITE3_TEXT);
        $updateStatement->execute();
    } else {
        $insertQuery = "INSERT INTO times (userId, time_seconds, zaman_damgasi, pageName) VALUES (:userId, :time_seconds, DATE('now'), :pageName)";
        $insertStatement = $db->prepare($insertQuery);
        $insertStatement->bindValue(':userId', $userId, SQLITE3_INTEGER);
        $insertStatement->bindValue(':time_seconds', $time, SQLITE3_INTEGER); // :time yerine :time_seconds kullanıldı
        $insertStatement->bindValue(':pageName', $pageName, SQLITE3_TEXT);
        $insertStatement->execute();
    }

    $db->close();
}

?>
