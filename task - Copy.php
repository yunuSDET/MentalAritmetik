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

        $userTables[$userId] = array(
            'id' => $userId,
            'username' => $username
        );
    }
}

// Veritabanı bağlantısını kapat
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">


    <title>Kullanıcı Listesi</title>
</head>
<body>
    <div class="container bg-light">
        <div class="row">
            <div class="col-sm-12 mt-4">
                <?php
                if (isset($_SESSION['user'])) {
                    if ($activeUserRole === 'admin' || $activeUserRole === 'teacher') {
                        // Display user select for admin and teacher
                        echo "<label for='userSelect'>Kullanıcı Seçin:</label>";
                        echo "<select class='custom-select' id='userSelect' onchange='updateForm()'>";
                        echo "<option value=''>Seçin</option>";

                        foreach ($userTables as $user) {
                            $userId = $user['id'];
                            $username = $user['username'];

                            echo "<option value='{$userId}'>{$username}</option>";
                        }

                        echo "</select>";

                       

                        // Display the form for each user
                        foreach ($userTables as $user) {
                            $userId = $user['id'];

                            echo "<div id='{$userId}Form' style='display:none;'>";
                            echo "<h5>{$user['username']} Formu</h5>";
 
echo '<h2 style="color:blue;">Parmak Okuma Görevi</h2>';                          
echo '<form>';
echo '  <div class="form-row justify-content-center">';
echo '    <div class="col-sm-6 my-1">';
echo '      <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>';
echo '      <h5 style="color:red;">Aralık Seçin</h5>';
echo '      <select class="custom-select mr-sm-2" id="aralik">';
echo '        <option value="Secim">Etkinlik Seçin</option>';
echo '        <option value="Birlikler">Birlikler</option>';
echo '        <option value="Onluklar">Onluklar</option>';
echo '        <option selected value="1-99">1-99</option>';
echo '      </select>';
echo '    </div>';
echo '    <div class="col-sm-6 my-1">';
echo '      <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>';
echo '      <h5 style="color:red;">Bekleme Süresi Seçin</h5>';
echo '      <select class="custom-select mr-sm-2" id="bekleme">';
echo '        <option value=0>Süre Seçin</option>';
echo '        <option value=1>0.1</option>';
echo '        <option value=2>0.2</option>';
echo '        <option value=3>0.3</option>';
echo '        <option value=4>0.4</option>';
echo '        <option value=5>0.5</option>';
echo '        <option value=6>0.6</option>';
echo '        <option value=7>0.7</option>';
echo '        <option value=8>0.8</option>';
echo '        <option value=9>0.9</option>';
echo '        <option selected value=10>1.0</option>';
echo '        <option value=11>1.1</option>';
echo '        <option value=12>1.2</option>';
echo '        <option value=13>1.3</option>';
echo '        <option value=14>1.4</option>';
echo '        <option value=15>1.5</option>';
echo '        <option value=16>1.6</option>';
echo '        <option value=17>1.7</option>';
echo '        <option value=18>1.8</option>';
echo '        <option value=19>1.9</option>';
echo '        <option value=20>2</option>';
echo '        <option value=21>3</option>';
echo '        <option value=22>4</option>';
echo '        <option value=23>5</option>';
echo '        <option value=24>6</option>';
echo '        <option value=25>7</option>';
echo '        <option value=26>8</option>';
echo '        <option value=27>9</option>';
echo '        <option value=28>10</option>';
echo '      </select>';
echo '    </div>';
echo '  </div>';
echo '  <div class="col-auto mt-4 text-center">';
 
echo '    <div class="mx-auto mt-3" style="width: fit-content;">';
 
echo '    </div>';
echo '  </div>';
echo '</form>';




echo '<br><br><h2 style="color:blue;">İşlem Görevi</h2>';
 

echo '<form>';
echo '  <div class="form-row align-items-center">';
echo '    <div class="col-sm-4 text-center position-relative mb-3 mt-2">';
echo '      <h5 class="text-center">Seviye Seçin</h5>';
echo '      <select class="col-sm-12 custom-select mr-sm-2" id="selected_level">';
echo '        <option value=0>Seviye Seçin</option>';
echo '        <option selected value=1>1</option>';
echo '        <option value=2>2</option>';
echo '        <option value=3>3</option>';
echo '      </select>';
echo '    </div>';
echo '    <div class="col-sm-4 my-1 position-relative">';
echo '      <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>';
echo '      <h5>İşlem Seçin</h5>';
echo '      <select class="custom-select mr-sm-2 col-sm-12" id="islem">';
echo '        <option value=0>İşlem Seçin</option>';
echo '        <option selected value=1>-+</option>';
echo '      </select>';
echo '    </div>';
echo '    <div class="col-sm-4 my-1 position-relative">';
echo '      <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>';
echo '      <h5>Aralık Seçin</h5>';
echo '      <select class="col-sm-12 custom-select mr-sm-2" id="aralik">';
echo '        <option value=0>Aralık Seçin</option>';
echo '        <option value=1>1-9</option>';
echo '        <option value=2>1-20</option>';
echo '        <option value=3>1-50</option>';
echo '        <option selected value=4>1-99</option>';
echo '        <option value=5>10-99</option>';
echo '        <option value=6>1-999</option>';
echo '      </select>';
echo '    </div>';
echo '    <div class="col-6 my-1">';
echo '      <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>';
echo '      <h5>Bekleme Süresi Seçin</h5>';
echo '      <select class="custom-select mr-sm-2 col-sm-12" id="bekleme">';
echo '        <option value=0>Sure Seçin</option>';
echo '        <option value=0.1>0.1</option>';
echo '        <option value=0.2>0.2</option>';
echo '        <option value=0.3>0.3</option>';
echo '        <option value=0.4>0.4</option>';
echo '        <option value=0.5>0.5</option>';
echo '        <option value=0.6>0.6</option>';
echo '        <option value=0.7>0.7</option>';
echo '        <option value=0.8>0.8</option>';
echo '        <option value=0.9>0.9</option>';
echo '        <option value=1.0>1.0</option>';
echo '        <option value=1.1>1.1</option>';
echo '        <option value=1.2>1.2</option>';
echo '        <option value=1.3>1.3</option>';
echo '        <option value=1.4>1.4</option>';
echo '        <option value=1.5>1.5</option>';
echo '        <option value=1.6>1.6</option>';
echo '        <option value=1.7>1.7</option>';
echo '        <option value=1.8>1.8</option>';
echo '        <option value=1.9>1.9</option>';
echo '        <option selected value=2.0>2</option>';
echo '        <option value=2.2>2.2</option>';
echo '        <option value=2.4>2.4</option>';
echo '        <option value=2.6>2.6</option>';
echo '        <option value=2.8>2.8</option>';
echo '        <option value=3.0>3</option>';
echo '        <option value=3.2>3.2</option>';
echo '        <option value=3.4>3.4</option>';
echo '        <option value=3.6>3.6</option>';
echo '        <option value=3.8>3.8</option>';
echo '        <option value=4.0>4</option>';
echo '        <option value=5.0>5</option>';
echo '        <option value=6.0>6</option>';
echo '        <option value=7.0>7</option>';
echo '        <option value=8.0>8</option>';
echo '        <option value=9.0>9</option>';
echo '        <option value=10.0>10</option>';
echo '      </select>';
echo '    </div>';
echo '    <div class="col-6 my-1">';
echo '      <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>';
echo '      <h5>İşlem Sayısı</h5>';
echo '      <select class="col-sm-12 custom-select mr-sm-2" id="islem-sayisi">';
echo '        <option value=0>İşlem Sayısı</option>';
echo '        <option value=2>2</option>';
echo '        <option value=3>3</option>';
echo '        <option value=4>4</option>';
echo '        <option value=5>5</option>';
echo '        <option value=6>6</option>';
echo '        <option value=7>7</option>';
echo '        <option value=8>8</option>';
echo '        <option value=9>9</option>';
echo '        <option selected value=10>10</option>';
echo '        <option value=12>12</option>';
echo '        <option value=14>14</option>';
echo '        <option value=16>16</option>';
echo '        <option value=18>18</option>';
echo '        <option value=20>20</option>';
echo '        <option value=22>22</option>';
echo '        <option value=24>24</option>';
echo '        <option value=26>26</option>';
echo '        <option value=28>28</option>';
echo '        <option value=30>30</option>';
echo '        <option value=40>40</option>';
echo '        <option value=50>50</option>';
echo '        <option value=75>75</option>';
echo '        <option value=100>100</option>';
echo '        <option value=200>200</option>';
echo '        <option value=500>500</option>';
echo '        <option value=1000>1000</option>';
echo '      </select>';
echo '    </div>';
echo '  </div>';
echo '  <div class="mx-auto mt-3" style="width: fit-content;">';
echo '  </div>';
echo '  <div class="col-sm-12 my- mt-4 position-relative text-center">';
echo '    <button type="submit" class="btn btn-primary mt-2" id="save">Kaydet</button>';
echo '  </div>';
echo '</form>';





                            echo "</div>";
                        }

                        echo "<script>
                            function updateForm() {
                                var selectedUserId = document.getElementById('userSelect').value;

                                // Hide all user forms
                                for (var userId in " . json_encode($userTables) . ") {
                                    document.getElementById(userId + 'Form').style.display = 'none';
                                }

                                if (selectedUserId) {
                                    // Show the selected user's form
                                    document.getElementById(selectedUserId + 'Form').style.display = 'block';
                                } else {
                                    // Show the default form
                                    document.getElementById('defaultForm').style.display = 'block';
                                }
                            }
                        </script>";
                    } else {
                        // Diğer durumlar için gerekli içeriği ekleyebilirsiniz.
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <script type="module" src="util.js"></script>
 
 

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
    <!-- Optional JavaScript remains unchanged -->
</body>
</html>
