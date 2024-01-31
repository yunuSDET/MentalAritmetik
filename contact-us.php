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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
   

    <title>İletişim</title>
</head>

    

<body>


<div class="container mt-3">


    <div class="row">
        <div class="col-sm-12">
        <form>
  <div class="form-group">
    <label for="name">Adınız</label> 
    <input id="name" name="name" placeholder="Adınızı Girin" type="text" required="required" class="form-control">
  </div>
  <div class="form-group">
    <label for="email">Email</label> 
    <input id="email" name="email" placeholder="Email Girin" type="text" required="required" class="form-control">
  </div>
  <div class="form-group">
    <label for="message">Mesajınız</label> 
    <textarea id="message" name="message" cols="40" rows="5" class="form-control"></textarea>
  </div> 
  <div class="form-group">
    <button id="submit" name="submit" type="submit" class="btn btn-primary">Gönder</button>
  </div>
</form>

        </div>
    </div>
</div>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</body>
</html>


