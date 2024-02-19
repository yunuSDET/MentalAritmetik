<?php
if (session_status() == PHP_SESSION_NONE) {
    header("Location: index.php");
    exit;
}

$userId = $_SESSION['userId'];

try {
    $pdo = new PDO('sqlite:database.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Kullanıcının "task" bilgisini çek
    $query = $pdo->prepare("SELECT task FROM users WHERE id = :userId");
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->execute();

    $userTask = $query->fetchColumn();

    // JSON_ENCODE kontrolü
    if ($userTask === false || $userTask === null) {
        $userTask = ''; // veya başka bir değer atayabilirsiniz
    }

} catch (PDOException $e) {
    echo 'Hata: ' . $e->getMessage();
}

// userActualFingerPoint
$userActualFingerPoint = getUserActualPoint($pdo, $userId, 'finger-read.php');

// userActualIslemPoint
$userActualIslemPoint = getUserActualPoint($pdo, $userId, 'levels.php');

function getUserActualPoint($pdo, $userId, $pageName)
{
    $userActualPoint = 0;
    try {
        $query = $pdo->prepare("SELECT sum(score) FROM scores WHERE userId = :userId AND DATE(zaman_damgasi) = CURRENT_DATE AND pageName = :pageName");
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->bindParam(':pageName', $pageName, PDO::PARAM_STR);
        $query->execute();

        $userActualPoint = $query->fetchColumn();

        if ($userActualPoint === false || $userActualPoint === null) {
            $userActualPoint = 0;
        }
    } catch (PDOException $e) {
        echo 'Hata: ' . $e->getMessage();
    }

    return $userActualPoint;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <!-- Include your CSS styles here -->
    <style>
        #taskContainer {
            color: #778899;
            size: 8px;
        }

        /* Container Div */
        #container {
            display: flex;
        }

        #msgImg {
            color: red;
            font-size: 23px;
        }

        /* Sidebar Container */
        #sidebar-container {
            overflow: hidden;
            /* İçeriği sınırla */
            max-height: 80vh;
            /* Maksimum yükseklik belirlendi */
            background-color: #343a40;
            /* Koyu gri renk */
            color: #dee2e6;
            /* Daha koyu gri renk */
            position: fixed;
            width: 200px;
            padding-top: 20px;
        }

        #sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #sidebar ul li ul li {
            margin: 20;
            color: gray;
            background: #EDE4DF
        }

        #sidebar ul li.header {
            padding: 10px;
            font-size: 1.2em;
            font-weight: bold;
            color: #fff;
            /* Beyaz renk */
            background: #778899;
            /* Belirgin renk */
        }

        #sidebar ul li p {
            padding: 10px;
            font-size: 1em;
            color: #b8c2cc;
            /* Beyaz renk */
            text-decoration: none;
            display: block;
            transition: all 0.3s;
        }

        #sidebar ul li a {
            padding: 10px;
            font-size: 1em;
            color: #b8c2cc;
            /* Beyaz renk */
            text-decoration: none;
            display: block;
            transition: all 0.3s;
        }

        #sidebar ul li p:hover {
            color: #7386d5;
            background: #2e3338;
            /* Daha koyu gri renk */
        }

        #sidebar ul li a:hover {
            color: #7386d5;
            background: #2e3338;
            /* Daha koyu gri renk */
        }

        #content {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<nav id="sidebar" class="bg-light sidebar-content" style="margin-bottom: 500px;">
<script>
    document.addEventListener("DOMContentLoaded", function() {
        getTasks();
    });

    function getTasks() {
    fetch('getTasks.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            if (data.status === 200) {
                displayTasks(data.data);
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}



    function displayTasks(tasks) {
        var tasksContainer = document.getElementById('taskContainer');

        for (var userId in tasks) {
            var task = tasks[userId];

            var listItem = document.createElement('li');
            listItem.textContent = 'Öğrenci Adı: ' + userId + ', Görev: ' + task;

            tasksContainer.appendChild(listItem);
        }
    }
</script>
    <!-- Your navigation content here -->
    <ul class="list-unstyled components">
        <li class="header">
            <a href="#"><?php echo 'Merhaba ' . $_SESSION['user'] ?></a>
        </li>

        <li>
            <a href="#pageSubmenuGorev" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Görev Mesajı
                <span id="msgImg">💬</span></a>
            <ul class="collapse list-unstyled" id="pageSubmenuGorev">
                <li>
                    <p id="taskContainer"><?php echo $userTask ?> </p>
                </li>

            </ul>
        </li>

        <li>
            <a href="#pageSubmenuilerlemeler" data-toggle="collapse" aria-expanded="true"
               class="dropdown-toggle">Günlük İlerlemeler</a>
            <ul class="list-unstyled collapse show" id="pageSubmenuilerlemeler">
                <li>
                    <p>Okuma: <span id="daily-point-finger"><?php echo $userActualFingerPoint; ?></span> puan, (%
                        <span id="daily-progress"></span>)</p>
                    <div class="progress">
                        <div class="progress-bar bg-warning" id="progress-bar" role="progressbar"
                             style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <hr>
                </li>
                <li>
                    <p>İşlem: <span id="daily-point-islemler"><?php echo $userActualIslemPoint; ?></span> puan, (%
                        <span id="daily-progress-islemler"></span>)</p>
                    <div class="progress">
                        <div class="progress-bar bg-warning" id="progress-bar-islemler" role="progressbar"
                             style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <hr>
                </li>
            </ul>
        </li>

        <?php
        $userId = $_SESSION['userId'];
        $userActualPoint = "";
        $userTotalPoint = "";
        $userActualTime = "";
        $userTotalTime = "";
        try {
            $pdo = new PDO('sqlite:database.db');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Kullanıcının adını çek
            $query = $pdo->prepare("SELECT sum(score) FROM scores WHERE userId = :userId AND DATE(zaman_damgasi) = CURRENT_DATE");
            $query->bindParam(':userId', $userId, PDO::PARAM_INT);
            $query->execute();

            $userActualPoint = $query->fetchColumn();

            // JSON_ENCODE kontrolü
            if ($userActualPoint === false || $userActualPoint === null) {
                $userActualPoint = 0; // veya başka bir değer atayabilirsiniz
            }

            //total point
            $query = $pdo->prepare("SELECT sum(score) FROM scores WHERE userId = :userId");
            $query->bindParam(':userId', $userId, PDO::PARAM_INT);
            $query->execute();

            $userTotalPoint = $query->fetchColumn();

            // JSON_ENCODE kontrolü
            if ($userTotalPoint === false || $userTotalPoint === null) {
                $userTotalPoint = 0; // veya başka bir değer atayabilirsiniz
            }

            //Günlük zaman
            $query = $pdo->prepare("SELECT sum(time_seconds) FROM times WHERE userId = :userId AND DATE(zaman_damgasi) = CURRENT_DATE");
            $query->bindParam(':userId', $userId, PDO::PARAM_INT);
            $query->execute();

            $userActualTime = $query->fetchColumn();

            // JSON_ENCODE kontrolü
            if ($userActualTime === false || $userActualTime === null) {
                $userActualTime = 0; // veya başka bir değer atayabilirsiniz
            }

            //Toplam süre
            $query = $pdo->prepare("SELECT sum(time_seconds) FROM times WHERE userId = :userId");
            $query->bindParam(':userId', $userId, PDO::PARAM_INT);
            $query->execute();

            $userTotalTime = $query->fetchColumn();

            // JSON_ENCODE kontrolü
            if ($userActualTime === false || $userTotalTime === null) {
                $userTotalTime = 0; // veya başka bir değer atayabilirsiniz
            }

            echo '<script type="module" src="util.js"></script>';
            echo '<script>';
            echo 'document.addEventListener("DOMContentLoaded", async function() {';
            echo '  var userActualPoint = ' . $userActualPoint . ';';
            echo '  var userActualTime = ' . $userActualTime . ';';
            echo '  document.getElementById("current-point").innerHTML = ' . $userActualPoint . ';';
            echo '  document.getElementById("current-time-seconds").innerHTML = ' . $userActualTime . ';';
            echo '  await update_right_side_bar(' . $userActualFingerPoint . ',"finger");';
            echo '  await update_right_side_bar(' . $userActualIslemPoint . ',"levels");';
            echo '});';
            echo '</script>';
        } catch (PDOException $e) {
            echo 'Hata: ' . $e->getMessage();
        }
        ?>

        <li>
            <a href="#pageSubmenuPuan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Puan
                Tablosu</a>
            <ul class="collapse list-unstyled" id="pageSubmenuPuan">
                <li>
                    <p>Bugün - <?php echo $userActualPoint . " puan" ?></p>
                </li>
                <li>
                    <p>Toplam- <?php echo $userTotalPoint . " puan" ?></p>
                </li>
            </ul>
        </li>

        <li>
            <a href="#pageSubmenuSure" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Süre
                Tablosu</a>
            <ul class="collapse list-unstyled" id="pageSubmenuSure">
                <li>
                    <p>Bugün - <?php echo $userActualTime . " saniye" ?></p>
                </li>
                <li>
                    <p>Toplam - <?php echo $userTotalTime . " saniye" ?></p>
                </li>
            </ul>
        </li>

        <li>
            <a href="contact-us.php">İletişim</a>
        </li>
    </ul>
</nav>

<!-- The rest of your HTML content here -->
</body>
</html>
