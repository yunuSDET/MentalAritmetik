<?php
include 'sessionManager.php';
checkUserSession();


// Admin kontrolü
 
if (
    isset($_SESSION['user']) &&
    $_SESSION['user'] !== 'admin'
) {
    echo "Yetkisiz alandasınız. Ana sayfaya yönlendiriliyorsunuz...";
    header("Refresh: 3; URL=index.php"); // 3 saniye sonra ana sayfaya yönlendir
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Ekle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
   

<div class="container bg-primary-subtle">
    <div class="row">
        <div class="col-sm-12 mt-4">
            <h2 style="text-align:center">Kullanıcı Ekle</h2>


 

            <form method="POST" action="" class="col-4 offset-4">

                <div class="mt-3">
                <label for="username" class="form-label">Kullanıcı Adı:</label>
                   
                </div>


                <div class="mb-1">

                    <input class="form-control" type="text" id="username" name="username" required>
                </div>


                <div class="mt-3">

                <label for="password" class="form-label ">Şifre:</label>
                

                </div>
                
                <div class="mb-1">

                <input class="form-control"  type="password" id="password" name="password" required>
                

                </div>
 
                <input class="btn btn-primary col-12 mt-2" type="submit" value="Kullanıcı Ekle">
            </form>



        </div>
    </div>
</div>



<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $pdo = new PDO('sqlite:database.db');

    // Kullanıcıyı kontrol eden sorgu
    $checkUser = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $checkUser->bindParam(':username', $username);
    $checkUser->execute();
    $userCount = $checkUser->fetchColumn();

    if ($userCount > 0) {
        echo '
<div class="container mt-3">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h1 class="bg-danger">Bu kullanıcı adı zaten mevcut. Lütfen başka bir kullanıcı adı seçin.</h1>
        </div>
    </div>
</div>';
 
    } else {
        // Kullanıcıyı ekleyen sorgu
        $insertUser = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $insertUser->bindParam(':username', $username);
        $insertUser->bindParam(':password', $password);

        if ($insertUser->execute()) {
            echo '
<div class="container mt-3">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h1 class="bg-success">Kullanıcı başarıyla eklendi</h1>
        </div>
    </div>
</div>';
        } else {
            echo "Kullanıcı eklenirken bir hata oluştu.";
        }
    }
}
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
