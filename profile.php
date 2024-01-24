<?php
include 'sessionManager.php';
checkUserSession();
?>

<?php
include 'navbar.php';
?>


<?php


// Kullanıcı girişi kontrolü

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];

    $pdo = new PDO('sqlite:database.db');

    // Kullanıcının adını çek
    $getUserInfo = $pdo->prepare("SELECT username FROM users WHERE id = :userId");

    if (!$getUserInfo->execute()) {
      die('Kullanıcı bilgilerini çekerken hata oluştu.');
  }

    $getUserInfo->bindParam(':userId', $userId);
    $getUserInfo->execute();
    $userData = $getUserInfo->fetch(PDO::FETCH_ASSOC);

    // Kullanıcının puan bilgilerini çek
    $getUserScores = $pdo->prepare("SELECT score FROM scores WHERE userId = :userId");
    $getUserScores->bindParam(':userId', $userId);
    $getUserScores->execute();
    $scores = $getUserScores->fetchAll(PDO::FETCH_COLUMN);

    // Kullanıcının toplam süre bilgisini çek
    $getUserTotalTime = $pdo->prepare("SELECT SUM(time_seconds) AS total_time FROM times WHERE userId = :userId");
    $getUserTotalTime->bindParam(':userId', $userId);
    $getUserTotalTime->execute();
    $totalTime = $getUserTotalTime->fetch(PDO::FETCH_ASSOC)['total_time'];

    $username = $userData['username'];
} else {
    // Kullanıcı girişi yapılmamışsa, giriş sayfasına yönlendir
    header("Location: login.php");
    exit();
}
?>





<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

     
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
    </style>



    <title>Profile Sayfası</title>
  </head>
  <body>
    




  <?php
// Kullanıcının puan ve süre bilgilerini çekmek için giriş yapmış olması gerekiyor
// $userId değişkeni, giriş yapmış kullanıcının userId değerini içermelidir

$pdo = new PDO('sqlite:database.db');

// Kullanıcının puan bilgilerini çek
$getUserScores = $pdo->prepare("SELECT score,zaman_damgasi,pageName FROM scores WHERE userId = :userId");
$getUserScores->bindParam(':userId', $userId);
$getUserScores->execute();

$scores = $getUserScores->fetchAll(PDO::FETCH_ASSOC);

$outputString = "";  // Her bir satırı biriktirmek için boş bir string
$pageName = "";

foreach ($scores as $scoreData) {
    $score = $scoreData['score'];  // Puan
    $zaman_damgasi = $scoreData['zaman_damgasi'];  // Zaman damgası
    $pageName = $scoreData['pageName'];  // Sayfa Adı

    // Her bir satırı stringe ekle
    $outputString .= "Puan: $score, ==> Tarih : $zaman_damgasi ==> ($pageName)<br>";
}

// Kullanıcının toplam süre bilgisini çek
$getUserTotalTime = $pdo->prepare("SELECT time_seconds AS total_time,pageName,zaman_damgasi FROM times WHERE userId = :userId");
$getUserTotalTime->bindParam(':userId', $userId);
$getUserTotalTime->execute();

$totalTimeRows = $getUserTotalTime->fetchAll(PDO::FETCH_ASSOC);
$outputStringTime="";
foreach ($totalTimeRows as $totalTimeRow) {
    $totalTime = $totalTimeRow['total_time'];
    $zaman_damgasi = $totalTimeRow['zaman_damgasi'];  // Zaman damgası
    $pageName = $totalTimeRow['pageName'];  // Sayfa Adı
    // Her bir satırı stringe ekle
    $outputStringTime .= "Süre: $totalTime saniye ==> Tarih : $zaman_damgasi ==> ($pageName) <br>";
}
?>



 
    <h2></h2>
    <table>
        <tr>
           <th class="text-center" colspan="2"><?= $username ?></th>
        </tr>

        <tr>
            <th>Puan</th>
            <td><?=  $outputString?></td>
        </tr>
        <tr>
            <th>Süre (saniye)</th>
            <td><?= $outputStringTime?></td>
        </tr>
    </table>
 






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