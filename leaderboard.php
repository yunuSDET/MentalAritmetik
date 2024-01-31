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
 



 $userId = $_SESSION['userId'];
 $userOrder=1;
 $userName="";
 $theNumberOfUsers=0;

 try {
     $pdo = new PDO('sqlite:database.db');
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
     // Kullanıcının adını çek
     $query = $pdo->prepare("select username, Total FROM users join (SELECT userId, sum(score) as Total FROM scores WHERE  DATE(zaman_damgasi) = CURRENT_DATE GROUP by userId order by Total desc) on users.id=userId;");
     $query->execute();
     $theNumberOfUsers= $query->rowCount();
     
     echo "<table border='1' style='margin-top:30px'>
     
     <tr>
     <th colspan='3' class='text-center'>Günlük Tablo</th>
     </tr>

     <tr>
     
       <th>Sıra Numarası</th>
         <th>Kullanıcı Adı</th>
         <th>Toplam</th>
     </tr>";

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
   echo "<tr>
            <td>{$userOrder}</td>
             <td>{$row['username']}</td>
             <td>{$row['Total']}</td>
         </tr>";
         $userOrder+=1;
}

echo "</table>";

// PDO bağlantısını kapat
 
 


$endDate = date('Y-m-d');  // Bugünün tarihi

// Bugünden geriye doğru 7 günü kapsayan bir tarih hesapla
$startDate = date('Y-m-d', strtotime('-7 days', strtotime($endDate)));


// SQL sorgusu
$query = $pdo->prepare("
    SELECT username, Total
    FROM users
    JOIN (
        SELECT userId, SUM(score) AS Total
        FROM scores
        WHERE DATE(zaman_damgasi) BETWEEN :startDate AND :endDate
        GROUP BY userId
        ORDER BY Total DESC
    ) ON users.id = userId
");

// Parametreleri bind et
$query->bindParam(':startDate', $startDate, PDO::PARAM_STR);
$query->bindParam(':endDate', $endDate, PDO::PARAM_STR);

// Sorguyu çalıştır
$query->execute();

// Tabloyu HTML olarak yazdır
echo "<table border='1' style='margin-top:50px'>
      <tr>
          <th colspan='3' class='text-center'>Son Hafta Tablosu</th>
      </tr>
      <tr>
          <th>Sıra Numarası</th>
          <th>Kullanıcı Adı</th>
          <th>Toplam</th>
      </tr>";

$counter = 1;
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
              <td>{$counter}</td>
              <td>{$row['username']}</td>
              <td>{$row['Total']}</td>
          </tr>";
    $counter++;
}

echo "</table>";

// PDO bağlantısını kapat
$pdo = null;
 
  
 } catch (PDOException $e) {
     echo 'Hata: ' . $e->getMessage();
 }
 ?>   


 






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
  <?php include "footer.php"; ?>
</html>