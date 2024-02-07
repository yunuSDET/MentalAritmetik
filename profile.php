<?php
include 'sessionManager.php';
checkUserSession();
include 'navbar.php';

// Admin kontrolü
if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin') {
    // Admin kullanıcı ise
    $databaseFile = 'database.db'; // Veritabanı dosya adı
    $db = new SQLite3($databaseFile);

    // SELECT sorgusu
    $query = "SELECT users.id AS userId, users.username AS userUsername, scores.score, scores.zaman_damgasi, scores.pageName
              FROM users
              LEFT JOIN scores ON users.id = scores.userId
              ORDER BY users.id, scores.zaman_damgasi DESC";
    $result = $db->query($query);

    // Veriyi bir diziye atan
    $userScores = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $userScores[$row['userId']][] = array(
            'username' => $row['userUsername'],
            'score' => $row['score'],
            'zaman_damgasi' => $row['zaman_damgasi'],
            'pageName' => $row['pageName']
        );
    }

    // Veritabanı bağlantısını kapat
    $db->close();
} else {
    // Admin değilse, kullanıcıya özel sayfayı yükle
    $userId = $_SESSION['userId'];
    $username = $_SESSION['user'];

    // Kullanıcının skorlarını getir
    $databaseFile = 'database.db'; // Veritabanı dosya adı
    $db = new SQLite3($databaseFile);

    // SELECT sorgusu
    $query = "SELECT score, zaman_damgasi, pageName
              FROM scores
              WHERE userId = :userId
              ORDER BY zaman_damgasi DESC";
    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId, SQLITE3_INTEGER);
    $result = $statement->execute();

    // Veriyi bir diziye atan
    $userScores = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $userScores[] = array(
            'username' => $username,
            'score' => $row['score'],
            'zaman_damgasi' => $row['zaman_damgasi'],
            'pageName' => $row['pageName']
        );
    }

    // Veritabanı bağlantısını kapat
    $db->close();
}
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
                if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin') {
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

                    echo "<div class='container mt-4'>";
                    echo "<h3>Görev Verilen Kullanıcının Skorları:</h3>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>Kullanıcı Adı</th><th>Puan</th><th>Tarih</th><th>Etkinlik Adı</th><th>Görev Tamamlama Durumu</th></tr></thead>";
                    echo "<tbody>";

                    foreach ($selectedUserScores as $scoreRow) {
                        echo "<tr>";
                        echo "<td>{$scoreRow['username']}</td>";
                        echo "<td>{$scoreRow['score']}</td>";
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

                        echo "<td>" . ($scoreRow['score'] >= 1000 ? '✔' : '✘') . "</td>";

                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                }
                ?>

                <?php
                if (isset($_SESSION['user']) && $_SESSION['user'] !== 'admin') {
                    // Admin değilse
                    echo "<div class='container mt-4'>";
                    echo "<h3>Skorlarınız:</h3>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>Puan</th><th>Tarih</th><th>Etkinlik Adı</th><th>Görev Tamamlama Durumu</th></tr></thead>";
                    echo "<tbody>";

                    foreach ($userScores as $scoreRow) {
                        echo "<tr>";
                        echo "<td>{$scoreRow['score']}</td>";
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

                        echo "<td>" . ($scoreRow['score'] >= 1000 ? '✔' : '✘') . "</td>";

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

    

    
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>
</html>
