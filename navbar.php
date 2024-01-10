<?php
if (session_status() == PHP_SESSION_NONE) {
    // Eğer bir oturum başlatılmamışsa başlat
    session_start();
    
   
}

?>



<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Parmak Abaküsü</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <?php
        if (isset($_SESSION['user'])) {
            // Giriş yapıldıysa
            $username = $_SESSION['user'];

            echo '<ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Ana Sayfa <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Çalışalım
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="finger-read.php">Parmak Okuma</a>
                            <a class="dropdown-item" href="level1.php">Seviye 1</a>
                            <a class="dropdown-item" href="level2.php">Seviye 2</a>
                            <a class="dropdown-item" href="level3.php">Seviye 3</a>
                        </div>
                    </li>
                  </ul>
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">' . $username . '</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                  </ul>';
        } else {
            // Giriş yapılmadıysa
            echo '<ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                  </ul>';
        }
        ?>
    </div>
</nav>

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

