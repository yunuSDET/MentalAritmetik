<?php
include 'sessionManager.php';
checkUserSession();
include 'navbar.php';

$databaseFile = 'database.db'; // Veritabanı dosya adı
$db = new SQLite3($databaseFile);

if (isset($_SESSION['user'])) {
    $activeUserRole = $_SESSION['userRole'];
    $activeUserName = $_SESSION['user'];

    if ($activeUserName === 'admin') {
        // Admin ise
        $query = "SELECT id AS userId, username AS userUsername
                  FROM users
                  WHERE role = 'student'
                  ORDER BY id";
    } elseif ($activeUserRole === 'teacher') {
        // Öğretmen ise
        $query = "SELECT id AS userId, username AS userUsername
                  FROM users
                  WHERE teacher = :teacherName
                  ORDER BY id";
    }

    $resultStmt = $db->prepare($query);

    if ($activeUserRole === 'teacher') {
        $resultStmt->bindValue(':teacherName', $_SESSION['user'], SQLITE3_TEXT);
    }

    $result = $resultStmt->execute();

    $userTables = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $userId = $row['userId'];
        $username = $row['userUsername'];

        // Önceki görevleri çek
        $getTasksQuery = "SELECT task FROM users WHERE users.id = :userId";
        $getTasksStmt = $db->prepare($getTasksQuery);
        $getTasksStmt->bindValue(':userId', $userId, SQLITE3_INTEGER);
        $tasksResult = $getTasksStmt->execute();

        $tasks = array();
        while ($taskRow = $tasksResult->fetchArray(SQLITE3_ASSOC)) {
            $tasks[] = $taskRow['task'];
        }

        $userTables[$userId] = array(
            'id' => $userId,
            'username' => $username,
            'tasks' => $tasks
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
    <style>
        textarea {
            width: 100%;
            resize: none;
        }
    </style>
    
    <title>Kullanıcı Listesi</title>
</head>
<body>
    <div class="container bg-light">
        <div class="row">
            <div class="col-sm-12 mt-4">
                <?php
                if (isset($_SESSION['user'])) {
                    if ($activeUserRole === 'admin' || $activeUserRole === 'teacher') {
                         // Kaydet düğmesi
                         echo "<button type='button' class='btn btn-primary' onclick='kaydet()'>Kaydet</button>";
                         
                        echo "<table class='table'>";
                        echo "<thead><tr><th>Öğrenci Adı</th><th>Görev</th></tr></thead>";
                        echo "<tbody>";

                        // Hızlı Giriş kutusu
                        echo "<tr>";
                        echo "<td>Hızlı Giriş</td>";
                        echo "<td><textarea id='hizliGiris' name='hizliGiris' oninput='hizliGirisChanged()'></textarea></td>";
                        echo "</tr>";

                        foreach ($userTables as $user) {
                            $userId = $user['id'];
                            $username = $user['username'];

                            echo "<tr>";

                            echo "<td><h3>{$username}</h3>
                            
                           

 
                            
                            </td>";


                            echo "<td><textarea id='{$userId}' name='{$userId}' style='width: 100%; height: 250px;'>" . implode("\n", $user['tasks']) . "</textarea></td>";

                            echo "<td></td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";

                       
                    } else {
                        // Diğer durumlar için gerekli içeriği ekleyebilirsiniz.
                    }
                }
                ?>
            </div>
        </div>
    </div>

 

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script>
        function kaydet() {
            var taskValues = {};

            <?php
            foreach ($userTables as $userId => $tables) {
                $username = $tables['username'];
                echo "var taskValue = document.getElementById('{$userId}').value;";
                echo "taskValues['{$userId}'] = taskValue;";
            }
            ?>

            var hizliGirisValue = document.getElementById('hizliGiris').value;
            taskValues['hizliGiris'] = hizliGirisValue;

            var tasksJson = JSON.stringify(taskValues);

            ajaxRequest('saveTask.php', 'tasks=' + tasksJson, function(response) {
                console.log(response);
                alert("Görev tablosu güncellendi.")
            });
        }

        function hizliGirisChanged() {
            var inputValue = document.getElementById('hizliGiris').value;

            <?php
            foreach ($userTables as $user) {
                $userId = $user['id'];
                echo "document.getElementById('{$userId}').value = inputValue;";
            }
            ?>
        }

        function ajaxRequest(url, params, callback) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        callback(xhr.responseText);
                    } else {
                        console.error("AJAX Hatası: " + xhr.status);
                    }
                }
            };
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send(params);
        }
    </script>
</body>
</html>
