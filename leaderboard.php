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
     $query = $pdo->prepare("SELECT userId FROM scores WHERE userId = :userId AND DATE(zaman_damgasi) = CURRENT_DATE");
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
      if ($userActualTime  === false || $userActualTime === null) {
       $userActualTime  = 0; // veya başka bir değer atayabilirsiniz
      }
     
 
 
      //Toplam süre
  
  
       $query = $pdo->prepare("SELECT sum(time_seconds) FROM times WHERE userId = :userId");
       $query->bindParam(':userId', $userId, PDO::PARAM_INT);
       $query->execute();
   
       $userTotalTime = $query->fetchColumn();
    
       // JSON_ENCODE kontrolü
       if ($userActualTime  === false || $userTotalTime === null) {
         $userTotalTime  = 0; // veya başka bir değer atayabilirsiniz
       }
 
 
       echo '<script type="module" src="util.js"></script>';
       echo '<script>';
       
       echo 'document.addEventListener("DOMContentLoaded", async function() {';
       echo '  var userActualPoint = ' . $userActualPoint . ';'; 
       echo '  var userActualTime = ' . $userActualTime . ';'; 
       echo '  document.getElementById("current-point").innerHTML = ' . $userActualPoint . ';';
       echo '  document.getElementById("current-time-seconds").innerHTML = ' . $userActualTime. ';';
       echo '  await update_right_side_bar(' . $userActualPoint . ');';
    
       echo '});';
       
       echo '</script>';
 
 
 
 } catch (PDOException $e) {
     echo 'Hata: ' . $e->getMessage();
 }
 ?>   



 
    <h2></h2>
    <table>

         <tr>
           <th class="text-center" colspan="3">Lider Tablosu</th>
        </tr>

        <tr>
            <th>Sıra</th>
            <th>Günlük</th>
            <th>Haftalık</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
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