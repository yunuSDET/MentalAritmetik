<?php
session_start();
 
// Veritabanı bağlantısı
try {
    $db = new PDO('sqlite:database.db');
} catch (PDOException $e) {
    die('Veritabanı bağlantısı başarısız: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kullanıcı girişi kontrolü
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcıyı veritabanından sorgula
    $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kullanıcı bulundu mu?
    if ($user) {
        // Şifre doğru mu?
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username; // Oturumu başlat
            $_SESSION['userId'] =  $user['id']; // Oturumu başlat
            $_SESSION['userRole'] =  $user['role']; // Oturumu başlat
            $_SESSION['userTeacher'] =  $user['teacher']; // Oturumu başlat

            header('Location: index.php'); // Ana sayfaya yönlendir
            exit();
        } else {
            $error = 'Hatalı kullanıcı adı veya şifre';
        }
    } else {
        $error = 'Hatalı kullanıcı adı veya şifre';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Gerekli meta etiketleri -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Giriş Sayfası</title>
</head>

<body>






    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <form method="post">
                                    <h2 class="fw-bold mb-2 " style="font-size:45px">GİRİŞ</h2>
                                    <p class="text-white-50 mb-5">Kullanıcı adı ve şifreyi girin!</p>

                                    <div class="form-outline form-white mb-4">
                                    <label class="form-label" for="username" style="font-size:24px">Kullanıcı Adı</label>
                                        <input type="text" id="username" name="username" class="form-control form-control-lg" />
                                        
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                    <label class="form-label" for="password" style="font-size:24px">Şifre</label>
                                        <input type="password" id="password" name="password" class="form-control form-control-lg" />
                                       
                                    </div>





                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" style="font-size:24px">Giriş</button>

                                    <?php if (isset($error)) : ?>
                                        <div class="alert alert-danger mt-3" role="alert">
                                            <?php echo $error; ?>
                                        </div>
                                    <?php endif; ?>

                                </form>



                            </div>

                            <div>
                                <p class="mb-0">Hesap açmak mı istiyorsunuz? <a href="/contact-us.php" class="text-white-50 fw-bold">İletişime Geçin</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</body>
<?php include "footer.php"; ?>
</html>