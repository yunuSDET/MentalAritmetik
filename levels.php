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



 



    .tableText {

      font-size: 22px;



    }

    h5{
      color:red;
    }




  </style>



    <title>Parmak Abaküsü</title>
  </head>
  <body>

    <audio id="beep">
      <source src="audio/beep.mp3" type="audio/mp3">
      Your browser does not support the audio element.
  </audio>
  <audio id="claps">
    <source src="audio/claps.mp3" type="audio/mp3">
    Your browser does not support the audio element.
</audio>
<audio id="error1">
  <source src="audio/error1.mp3" type="audio/mp3">
  Your browser does not support the audio element.
</audio>



     

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
   


    <div class="container mt-3">

      <div class="row max-auto">

        <div class="col-sm-9 ">
        <h1 class="display-3" style="text-align: center;color:Darkorange "><b>PARMAK ABAKÜSÜ </b></h1>
          <form>
            <div class="form-row align-items-center">
            
              <div class="col-sm-4 text-center position-relative mb-3 mt-2">
                <h5 class="text-center">Seviye Seçin</h5>
                <select class="col-sm-12 custom-select mr-sm-2" id="selected_level">
                  <option  value=0>Seviye Seçin</option>
                  <option selected value=1>1</option>
                  <option value=2>2</option>
                  <option value=3>3</option>
                  <option value=4>4</option>
                  <option value=5>5</option>
                 
                  
                </select>
              </div>
               

              <div class="col-sm-4 my-1 position-relative">
                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>
                <h5>İşlem Seçin</h5>
                <select class="custom-select mr-sm-2 col-sm-12" id="islem">
                  <option value=0>İşlem Seçin</option>

                  <option selected value=1>-+</option>
                </select>

                
              </div>



              <div class="col-sm-4 my-1 position-relative">
                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>
                <h5>Maksimum ve Minimum Sayılar</h5>
                <select class="col-sm-12 custom-select mr-sm-2" id="aralik">
                  <option value=0>Aralık Seçin</option>
                  <option value=1>1-9</option>
                  <option value=2>1-20</option>
                  <option value=3>1-50</option>
                  <option selected value=4>1-99</option>
                  <option value=5>10-99</option>
                  <option value=6>1-999</option>
                  
                  
                </select>

                
              </div>





              <div class="col-6 my-1">
                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>
                <h5>Bekleme Süresi Seçin</h5>
                <select class="custom-select mr-sm-2 col-sm-12" id="bekleme">
                  <option value=0>Sure Seçin</option>
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
                  <option selected value=20>2</option>
                  <option value=21>2.2</option>
                  <option value=21>2.4</option>
                  <option value=21>2.6</option>
                  <option value=21>2.8</option>
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

             
              <div class="col-6 my-1">
                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>
                <h5>İşlem Sayısı</h5>
                <select class="col-sm-12 custom-select mr-sm-2" id="islem-sayisi">
                  <option value=0>İşlem Sayısı</option>
                  <option value=1>1</option>
                  <option value=2>2</option>
                  <option value=3>3</option>
                  <option value=4>4</option>
                  <option value=5>5</option>
                  <option value=6>6</option>
                  <option value=7>7</option>
                  <option value=8>8</option>
                  <option value=9>9</option>
                  <option selected value=10>10</option>
                  <option value=12>12</option>
                  <option value=14>14</option>
                  <option value=16>16</option>
                  <option value=18>18</option>
                  <option value=20>20</option>
                  <option value=22>22</option>
                  <option value=24>24</option>
                  <option value=26>26</option>
                  <option value=28>28</option>
                  <option value=30>30</option>
                  <option value=40>40</option>
                  <option value=50>50</option>
                  <option value=75>75</option>
                  <option value=100>100</option>
                  <option value=200>200</option>
                  <option value=500>500</option>
                  <option value=1000>1000</option>
                </select>

                
              </div>

               
             



            </div>


            <div class="col-sm-12 my- mt-4 position-relative text-center">
                 
                 <button type="submit" class="btn btn-primary" id="start">Başla</button>


            </div>


          </form>
        </div>
          
        <div class="col-sm-3">
          <?php
          include 'right-side-bar.php';
          ?>
        </div>


      </div>

     

      <div class="row mt-4">

        <div style="font-size: 100px;" class="col-sm text-center" id="scene">
     
        </div>
           


      </div>

      </div>


    </div>


 <script src="levels.js"></script>
 

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>