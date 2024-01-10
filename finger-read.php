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
    body {
      font-family: 'Single Day', cursive;
      background: url('/img/light.jpg') no-repeat;
      background-size: cover;
    }



    #start {
      padding: 60px 55px;
      font-size: 24px;
      background: url('/img/sun.png') no-repeat;
      background-size: cover;
    }



    .tableText {

      font-size: 22px;



    }

   




  </style>

  <title>Parmak Abaküsü</title>
</head>

<body>


 

  <div class="container ">


    <div class="row max-auto questionMenu">

      <div class="col-sm-7 offset-1 mr-2">
        <h1 class="display-3" style="text-align: center;color:Darkorange "><b>PARMAK OKUMA </b></h1>

        <form>
          <div class="form-row justify-content-center">


            <div class="col-sm-6 my-1">
              <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>
              <h5 style="color:red;">Aralık Seçin</h5>
              <select class="custom-select mr-sm-2" id="aralik">
                <option selected>Etkinlik Seçin</option>
                <option value="Birlikler">Birlikler</option>
                <option value="Onluklar">Onluklar</option>
                <option value="1-99">1-99</option>
              </select>
            </div>

            <div class="col-sm-6 my-1">
              <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>
              <h5 style="color:red;">Bekleme Süresi Seçin</h5>
              <select class="custom-select mr-sm-2" id="bekleme">
                <option selected>Süre Seçin</option>
                <option value=1>0.1</option>
                <option value=2>0.2</option>
                <option value=3>0.3</option>
                <option value=4>0.4</option>
                <option value=5>0.5</option>
                <option value=6>0.6</option>
                <option value=7>0.7</option>
                <option value=8>0.8</option>
                <option value=9>0.9</option>
                <option value=10>1.0</option>
                <option value=11>1.1</option>
                <option value=12>1.2</option>
                <option value=13>1.3</option>
                <option value=14>1.4</option>
                <option value=15>1.5</option>
                <option value=16>1.6</option>
                <option value=17>1.7</option>
                <option value=18>1.8</option>
                <option value=19>1.9</option>
                <option value=20>2</option>
                <option value=21>3</option>
                <option value=22>4</option>
                <option value=23>5</option>
                <option value=24>6</option>
                <option value=25>7</option>
                <option value=26>8</option>
                <option value=27>9</option>
                <option value=28>10</option>

              </select>


            </div>


          </div>

          <div class="col-auto mt-4 text-center">

            <button type="submit" class="btn btn-warning" id="start">SOR</button>

            <div class="mx-auto mt-3" style="width: fit-content;">


              <table class="table-bordered">
                <tr class="bg-secondary">
                  <td class="tableText">Puanınız</td>
                  <td class="tableText">Süreniz</td>
                </tr>
                <tr class="bg-light" style="text-align: center;">
                  <td class="tableText" id="current-point">0</td>
                  <td class="tableText" id="current-time-seconds">0</td>
                </tr>
              </table>




            </div>





          </div>





        </form>



        <div class="div" id="popupPoint">

        </div>



      </div>


      <div class="col-sm-3 mt-3">
       
<?php
include 'right-side-bar.php';
?>
      </div>



    </div>




    <div class="row mt-4">

      <div style="font-size: 85px;" class="col-sm text-center" id="scene">
      </div>



    </div>




  </div>


  <script src="finger-read.js"></script>

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