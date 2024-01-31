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

    <title>Parmak Abaküsü</title>
  </head>
  <body>
  



<div class="container">

   

  <div class="jumbotron">
    <h1 class="display-4">Parmak Abaküsü Hakkında</h1>
    <p class="lead">Parmak abaküsü parmakları kullanarak 100'e kadarki bütün sayıları gösterme ve bu sayılar üzerinde toplama ve çıkarma işlemi yapmayı sağlayan etkili bir sistemdir.</p>

  
  </div>

  

    <div class="row">

      <div class="col-sm-12">

        <h2>Nasıl Çalışır?</h2>
    <p>Öncelikle parmaklar ile sayı gösterimi öğrenilir ve bu temel seviyedir. Detaylı bilgi için aşağıdaki videoları izleyebilirsiniz.</p>

      </div>

      <div class="col-sm">
        <iframe width="460" height="315" src="https://www.youtube.com/embed/btJRz9K7D38?si=1ZoOBPdkKpqIRHPX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
      </div>

      <div class="col-sm">
        <iframe width="460" height="315" src="https://www.youtube.com/embed/YJ3Oyiivgf0?si=wYXTMr7FNvql2tRd" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
      </div>


    </div>


    <hr class="my-4">
    
<div class="row justify-content-center mb-4">
  <div class="col-sm-6">

      <div class="card" style="width: 26rem;">
        <div class="card-body">
          
          <h5 class="card-title">Alıştırmalara Başlayalım</h5>
          <p class="card-text">Çalışma Seçiniz</p>

          <a href="finger-read.php" class="card-link">Parmak Okuma</a>
          <a href="levels.php" class="card-link">Seviyeler</a>
         
        </div>
      </div>
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

  <?php include "footer.php"; ?>
</html>