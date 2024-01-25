<?php
if (session_status() == PHP_SESSION_NONE) {
  // Eğer bir oturum başlatılmamışsa başlat
  header("Location: index.php");
   exit;
}



$userId = $_SESSION['userId'];

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
     
 
    echo '<script>';
    echo 'var userActualPoint = ' . json_encode($userActualPoint) . ';';
    echo 'document.getElementById("current-point").innerHTML = '. json_encode($userActualPoint) .';';
    echo 'update_right_side_bar('. json_encode($userActualPoint) .')';
    echo '</script>';
} catch (PDOException $e) {
    echo 'Hata: ' . $e->getMessage();
}
?>

 

<style>
  /* Container Div */
  #container {
    display: flex;
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
    color: #F5DBCB;
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



<nav id="sidebar" class="bg-light sidebar-content">


  <ul class="list-unstyled components">

    <li class="header">
      <a href="#"><?php echo 'Merhaba ' . $_SESSION['user'] ?></a>
    </li>

    <li>

    <p>Günlük Görev İlerleme: % <span id="daily-progress"></span></p>

    <div class="progress">
  <div class="progress-bar bg-success" id="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<hr>


      
    </li>



    <li>
      <a href="#pageSubmenuPuan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Puan Tablosu</a>
      <ul class="collapse list-unstyled" id="pageSubmenuPuan">
      <li>
          <p>Bugün - 678</p>
        </li>
        <li>
          <p>Hafta - 5623</p>
        </li>
        <li>
          <p>Ay - 8988</p>
        </li>
      </ul>
    </li>
    <li>
    <li>
      <a href="#pageSubmenuSure" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Süre Tablosu</a>
      <ul class="collapse list-unstyled" id="pageSubmenuSure">
        <li>
          <p>Bugün - 678</p>
        </li>
        <li>
          <p>Hafta - 5623</p>
        </li>
        <li>
          <p>Ay - 8988</p>
        </li>
      </ul>
    </li>

    <li>
      <p>İletişim</p>
    </li>
  </ul>


</nav>

