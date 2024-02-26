<?php
if (session_status() == PHP_SESSION_NONE) {
    // Eğer bir oturum başlatılmamışsa başlat
    session_start();
    
   
}
function isPageActive($pageName) {
    return basename($_SERVER['PHP_SELF']) === $pageName;
}

?>



<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/index.php">Mental Aritmetik</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <?php
        if (isset($_SESSION['user'])) {
            // Giriş yapıldıysa
            $username = $_SESSION['user'];
            $userTypeMenu=$_SESSION["userRole"]=="teacher" ? '<li class="nav-item active">
            <a class="nav-link" href="task.php">Görev Ver <span class="sr-only">(current)</span></a>
            </li>':"";

            echo '<ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Ana Sayfa <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                    <a class="nav-link" href="leaderboard.php">Puan Tablosu <span class="sr-only">(current)</span></a>
                    </li>

                    '.$userTypeMenu.'

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Çalışmalar
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="finger-read.php">Parmak Okuma</a>
                            <a class="dropdown-item" href="levels.php">İşlemler</a>
                            <a class="dropdown-item" href="soroban.php">Abaküs Çalışma</a>
                            
                        </div>
                    </li>
                  </ul>

                
                  <ul class="navbar-nav ml-auto">
                  </li>
                  <li class="nav-item">
                  <button href="#" class="mt-1 mr-2"><span id="sound" onclick="changeSound()" >🔇</span></button>

                  </li>

                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">' . $username . '</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Çıkış</a>
                    </li>
                  </ul>';
        } else {
            // Giriş yapılmadıysa
            echo '<ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Giriş</a>
                    </li>
                  </ul>';
        }
        ?>
    </div>
</nav>

<script>

    function changeSound(){
     
     let sound=document.getElementById("sound");
     if(sound.innerHTML==="🔉"){
         sound.innerHTML="🔇" ;
         
     }else{
         sound.innerHTML="🔉" ;
     }
 }

</script>


   <audio id="beep">
        <source src="audio/beep.mp3" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>
    <audio id="claps">
      <source src="audio/claps.mp3" type="audio/mp3">
      Your browser does not support the audio element.
  </audio>

  <audio id="yes">
      <source src="audio/yes.mp3" type="audio/mp3">
      Your browser does not support the audio element.
  </audio>

  <audio id="ohno">
      <source src="audio/ohno.mp3" type="audio/mp3">
      Your browser does not support the audio element.
  </audio>

  <audio id="error1">
    <source src="audio/error1.mp3" type="audio/mp3">
    Your browser does not support the audio element.
  </audio>

  <audio id="no">
    <source src="audio/no.mp3" type="audio/mp3">
    Your browser does not support the audio element.
  </audio>

