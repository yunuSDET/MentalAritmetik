<?php
if (session_status() == PHP_SESSION_NONE) {
   
  header("Location: index.php");
   exit;
}
?>


<style>

/* Footer stilini tanımla */
.footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: #f8f9fa; /* Footer arkaplan rengi */
    padding: 10px; /* Footer içeriği ile kenar boşluğu */
    text-align: center; /* Footer içeriğini ortala */
}

</style>

<div class="footer">


<div class="card text-center">
<div class="card-header">
  Developed by <a href="https://www.linkedin.com/in/yunus-kulcu/">Kulcu</a>
</div>
<div class="card-body">
   
    <footer class="footer">İstek ve önerileriniz için <a href="
    contact-us.php">tıklayın</a></footer>
 
</div>
</div>

</div>