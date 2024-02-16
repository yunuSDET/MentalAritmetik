<?php
session_start();

$userId = $_SESSION['userId'];
$earnedPoints = isset($_POST['earnedPoints']) ? intval($_POST['earnedPoints']) : 0;
$earnedTime = isset($_POST['earnedTime']) ? intval($_POST['earnedTime']) : 0;
$pageName = isset($_POST['pageName']) ? $_POST['pageName'] : '';

if ($userId !== null && $pageName !== '') {
    if ($earnedPoints !== 0) {
        saveUserPoints($userId, $earnedPoints, $pageName);
    }

    if ($earnedTime !== 0) {
        saveUserTime($userId, $earnedTime, $pageName);
    }
}

function saveUserPoints($userId, $points, $pageName) {
    $db = new SQLite3("database.db");
    
    // SQL Injection önleme
    $userId = $db->escapeString($userId);
    $pageName = $db->escapeString($pageName);

    $checkQuery = "SELECT * FROM scores WHERE userId = '$userId' AND zaman_damgasi = DATE('now') AND pageName = '$pageName'";
    $checkResult = $db->querySingle($checkQuery, true);

    if ($checkResult) {
        $newScore = $checkResult['score'] + $points;
        $updateQuery = "UPDATE scores SET score = $newScore WHERE userId = '$userId' AND zaman_damgasi = DATE('now') AND pageName = '$pageName'";
        $db->exec($updateQuery);
    } else {
        $insertQuery = "INSERT INTO scores (userId, score, zaman_damgasi, pageName) VALUES ('$userId', $points, DATE('now'), '$pageName')";
        $db->exec($insertQuery);
    }

    $db->close();
}

function saveUserTime($userId, $time, $pageName) {
    $db = new SQLite3("database.db");

    // SQL Injection önleme
    $userId = $db->escapeString($userId);
    $pageName = $db->escapeString($pageName);

    $checkQuery = "SELECT * FROM times WHERE userId = '$userId' AND zaman_damgasi = DATE('now') AND pageName = '$pageName'";
    $checkResult = $db->querySingle($checkQuery, true);

    if ($checkResult) {
        $newTime = $checkResult['time_seconds'] + $time;
        $updateQuery = "UPDATE times SET time_seconds = $newTime WHERE userId = '$userId' AND zaman_damgasi = DATE('now') AND pageName = '$pageName'";
        $db->exec($updateQuery);
    } else {
        $insertQuery = "INSERT INTO times (userId, time_seconds, zaman_damgasi, pageName) VALUES ('$userId', $time, DATE('now'), '$pageName')";
        $db->exec($insertQuery);
    }

    $db->close();
}
?>
