<?php
include 'sessionManager.php';
checkUserSession();
include 'navbar.php';

$databaseFile = 'database.db'; // Veritabanı dosya adı
$db = new SQLite3($databaseFile);

if (isset($_SESSION['user']) && $_SESSION['userRole'] === 'teacher') {

    $isAdmin=$_SESSION['user']=="admin" ? "":" WHERE users.teacher = :teacherName";

    // Öğretmen kullanıcı ise
    $query = "SELECT users.id AS userId, users.username AS userUsername, scores.score, scores.zaman_damgasi, scores.pageName
    FROM users
    LEFT JOIN scores ON users.id = scores.userId "
    .$isAdmin.
    " ORDER BY users.id, scores.zaman_damgasi DESC";

 $resultStmt = $db->prepare($query);
$resultStmt->bindValue(':teacherName', $_SESSION['user'], SQLITE3_TEXT);
$result = $resultStmt->execute();


 



    $userScores = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $userScores[$row['userId']][] = array(
            'username' => $row['userUsername'],
            'score' => $row['score'],
            'zaman_damgasi' => $row['zaman_damgasi'],
            'pageName' => $row['pageName']
        );
    }

    // Championship query
    $championshipQuery = "SELECT zaman_damgasi, userId, MAX(sum_score) as max_score
                          FROM (
                              SELECT zaman_damgasi, userId, SUM(score) as sum_score
                              FROM scores
                              GROUP BY zaman_damgasi, userId
                          ) AS daily_scores
                          GROUP BY zaman_damgasi";
    $championshipResult = $db->query($championshipQuery);

    $championshipData = array();
    while ($championshipRow = $championshipResult->fetchArray(SQLITE3_ASSOC)) {
        $championshipData[$championshipRow['zaman_damgasi']][$championshipRow['userId']] = array(
            'max_score' => $championshipRow['max_score']
        );
    }
} else {
    // Öğretmen değilse, kullanıcıya özel sayfayı yükle
    $userId = $_SESSION['userId'];
    $username = $_SESSION['user'];

    // Kullanıcının skorlarını getir
    $query = "SELECT score, zaman_damgasi, pageName
              FROM scores
              WHERE userId = :userId
              ORDER BY zaman_damgasi DESC";
    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId, SQLITE3_INTEGER);
    $result = $statement->execute();

    $userScores = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $userScores[] = array(
            'username' => $username,
            'score' => $row['score'],
            'zaman_damgasi' => $row['zaman_damgasi'],
            'pageName' => $row['pageName']
        );
    }

    // Championship query for non-admin users
    $championshipQuery = "SELECT zaman_damgasi, userId, MAX(sum_score) as max_score
                          FROM (
                              SELECT zaman_damgasi, userId, SUM(score) as sum_score
                              FROM scores
                               
                              GROUP BY zaman_damgasi, userId
                          ) AS daily_scores
                          
                          GROUP BY zaman_damgasi
                          having userId = :userId";
    $statement = $db->prepare($championshipQuery);
    $statement->bindValue(':userId', $userId, SQLITE3_INTEGER);
    $championshipResult = $statement->execute();

    $championshipData = array();
    while ($championshipRow = $championshipResult->fetchArray(SQLITE3_ASSOC)) {
        $championshipData[$championshipRow['zaman_damgasi']][$championshipRow['userId']] = array(
            'max_score' => $championshipRow['max_score']
        );
    }
}

// Veritabanı bağlantısını kapat
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Görev Tamamlama Listesi</title>
</head>
<body>
    <div class="container bg-light">
        <div class="row">
            <div class="col-sm-12 mt-4">
                <h2 style="text-align:center">Görev Tamamlama Listesi</h2>

                <?php
                if (isset($_SESSION['user']) && $_SESSION['userRole'] === 'teacher') {
                    // Admin ise
                    echo "<form method=\"POST\" action=\"\" class=\"col-4 offset-4\">";
                    echo "<label for=\"userList\">Kullanıcı Seç:</label>";
                    echo "<select id=\"userList\" name=\"userList\" class=\"form-control\">";
                    foreach ($userScores as $userId => $scores) {
                        $username = $scores[0]['username'];
                        echo "<option value=\"$userId\">$username</option>";
                    }
                    echo "</select>";
                    echo "<button type=\"submit\" class=\"btn btn-primary mt-2\">Listele</button>";
                    echo "</form>";
                }
                ?>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userList'])) {
                    // Admin ise ve form gönderildiyse
                    $selectedUserId = $_POST['userList'];
                    $selectedUserScores = $userScores[$selectedUserId];
                    $selectedUserName = $selectedUserScores[0]['username']; // Seçilen kullanıcının adını al

                    // Display selected user's scores
                    echo "<div class='container mt-4'>";
                    echo "<h3>Skorlar: ".$selectedUserName."</h3>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>Tarih</th><th>Etkinlik Adı</th><th>Puan</th><th>Görev Tamamlama Durumu</th></tr></thead>";
                    echo "<tbody>";

                    foreach ($selectedUserScores as $scoreRow) {
                        echo "<tr>";

                        echo "<td>{$scoreRow['zaman_damgasi']}</td>";

                        echo "<td>";

                        if ($scoreRow['pageName'] == 'finger-read.php') {
                            echo "Parmak Okuma";
                        } elseif ($scoreRow['pageName'] == 'levels.php') {
                            echo "İşlemler";
                        } else {
                            echo $scoreRow['pageName'];
                        }

                        echo "</td>";

                        echo "<td>{$scoreRow['score']}</td>";

                        echo "<td>" . ($scoreRow['score'] >= 1000 ? '✔️' : '❌') . "</td>";

                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";


                    echo "<tbody><table><div>";

                    // Display championship table for the selected user
                    echo "<div class='container mt-4'>";
                    echo "<h3>Şampiyonluklar:</h3>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>Tarih</th><th>Kupalar</th></tr></thead>";
                    echo "<tbody>";

                    foreach ($championshipData as $zaman_damgasi => $userData) {
                        if (isset($userData[$selectedUserId])) {
                            echo "<tr>";
                            echo "<td>{$zaman_damgasi}</td>";
                            echo "<td>{$userData[$selectedUserId]['max_score']} (puan) -  🏆</td>";
                            echo "</tr>";
                        }
                    }

                    echo "</tbody></table></div>";
                }
                ?>

                <?php
                if (isset($_SESSION['user']) && $_SESSION['userRole'] == 'student') {
                    // Admin değilse
                    echo "<div class='container mt-4'>";
                    echo "<h3>Skorlarınız:</h3>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>Tarih</th><th>Etkinlik Adı</th><th>Puan</th><th>Görev Tamamlama Durumu</th></tr></thead>";
                    echo "<tbody>";

                    foreach ($userScores as $scoreRow) {
                        echo "<tr>";

                        echo "<td>{$scoreRow['zaman_damgasi']}</td>";

                        echo "<td>";

                        if ($scoreRow['pageName'] == 'finger-read.php') {
                            echo "Parmak Okuma";
                        } elseif ($scoreRow['pageName'] == 'levels.php') {
                            echo "İşlemler";
                        } else {
                            echo $scoreRow['pageName'];
                        }

                        echo "</td>";

                        echo "<td>{$scoreRow['score']}</td>";

                        echo "<td>" . ($scoreRow['score'] >= 1000 ? '✔️' : '❌') . "</td>";

                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";

                    
    echo "<tbody><table><div>";

                    // Display championship table for the selected user
echo "<div class='container mt-4'>";
echo "<h3>Şampiyonluklar:</h3>";
echo "<table class='table'>";
echo "<thead><tr><th>Tarih</th><th>Kupalar</th></tr></thead>";
echo "<tbody>";

foreach ($championshipData as $zaman_damgasi => $userData) {
    echo "<tr>";
    echo "<td>{$zaman_damgasi}</td>";

    // Kontrol ekle
    if (isset($userData[$userId])) {
        echo "<td>{$userData[$userId]['max_score']} (puan) - 🏆</td>";
    } else {
        echo "<td>No Data</td>";
    }

    echo "</tr>";
}

echo "</tbody></table></div>";

                }

              

                ?>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
