<?php
include 'sessionManager.php';
checkUserSession();
?>

<?php
include 'navbar.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <title>Profile Sayfası</title>
</head>

<body>

    <?php
    try {
        $pdo = new PDO('sqlite:database.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $medals = ['🥇', '🥈', '🥉'];

        // Günlük Tablo
        $dailyQuery = $pdo->prepare("SELECT username,role, Total FROM users JOIN (SELECT userId, sum(score) as Total FROM scores WHERE  DATE(zaman_damgasi) = CURRENT_DATE GROUP BY userId ORDER BY Total DESC) ON users.id=userId;");
        $dailyQuery->execute();
        $theNumberOfUsers = $dailyQuery->rowCount();

        echo "<div class='container mt-4'>
                <div class='row'>
                    <div class='col-md-12'>
                        <table class='table table-bordered table-striped'>
                            <thead class='thead-dark'>
                                <tr>
                                    <th colspan='3' class='text-center'>Günlük Tablo</th>
                                </tr>
                                <tr>
                                    <th>Sıra Numarası</th>
                                    <th>Kullanıcı Adı</th>
                                    <th>Toplam Puan</th>
                                </tr>
                            </thead>
                            <tbody>";

        $userOrder = 1;
        while ($row = $dailyQuery->fetch(PDO::FETCH_ASSOC)) {
            if ($row['role'] != "teacher") {
                echo "<tr>
                        <td>{$userOrder}</td>
                        <td>{$row['username']}</td>";

                // Madalya ekleme kontrolü
                if ($userOrder <= 3) {
                    echo "<td>{$medals[$userOrder - 1]} {$row['Total']}</td>";
                } else {
                    echo "<td>" . str_repeat('&nbsp;', 6) . "{$row['Total']}</td>";
                }

                echo "</tr>";
                $userOrder += 1;
            }
        }

        echo "</tbody></table>
                    </div>
                </div>";

  

 
                $currentDayOfWeek = date('N'); // Haftanın gününü 1'den 7'ye döndüren fonksiyon (1: Pazartesi, 7: Pazar)
                $today = date('Y-m-d');
                
                $startDate = ($currentDayOfWeek == 1) ? $today : date('Y-m-d', strtotime('last monday'));
                $endDate = ($currentDayOfWeek == 7) ? $today : date('Y-m-d', strtotime('next sunday'));

        $weeklyQuery = $pdo->prepare("
            SELECT username,role, Total
            FROM users
            JOIN (
                SELECT userId, SUM(score) AS Total
                FROM scores
                WHERE DATE(zaman_damgasi) BETWEEN :startDate AND :endDate
                GROUP BY userId
                ORDER BY Total DESC
            ) ON users.id = userId
        ");

        $weeklyQuery->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $weeklyQuery->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $weeklyQuery->execute();

        $weeklyResults = $weeklyQuery->fetchAll(PDO::FETCH_ASSOC);

        $weeklyRowCount = count($weeklyResults);
 

        if ($weeklyRowCount > 0 && !empty($weeklyResults)) {
            echo "<div class='row mt-4'>
                        <div class='col-md-12'>
                            <table class='table table-bordered table-striped'>
                                <thead class='thead-dark'>
                                    <tr>
                                        <th colspan='3' class='text-center'>Son Hafta Tablosu (".$startDate." - ".$endDate.")</th>
                                    </tr>
                                    <tr>
                                        <th>Sıra Numarası</th>
                                        <th>Kullanıcı Adı</th>
                                        <th>Toplam Puan</th>
                                    </tr>
                                </thead>
                                <tbody>";

            $counter = 1;
            foreach ($weeklyResults as $row) {
                if ($row['role'] != "teacher") {
                    echo "<tr>
                            <td>{$counter}</td>
                            <td>{$row['username']}</td>";

                    if ($counter <= 3) {
                        echo "<td>{$medals[$counter - 1]} {$row['Total']}</td>";
                    } else {
                        echo "<td>" . str_repeat('&nbsp;', 6) . "{$row['Total']}</td>";
                    }

                    echo "</tr>";
                    $counter++;
                }
            }

            echo "</tbody></table>
                        </div>
                    </div>
                </div>";
        } else {
            echo "<p class='text-center'>Son hafta için kayıt bulunamadı.</p>";
        }

        // PDO bağlantısını kapat
        $pdo = null;
    } catch (PDOException $e) {
        echo 'Hata: ' . $e->getMessage();
    }



    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>

    <?php include "footer.php"; ?>
</body>

</html>
