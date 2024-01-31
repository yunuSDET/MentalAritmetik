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
    padding-top: 10px; /* Footer içeriği ile kenar boşluğu */
    text-align: center; /* Footer içeriğini ortala */
}
.before-footer {
   
    
 

 
    padding-top: 200px; /* Footer içeriği ile kenar boşluğu */
 
}


</style>

<div class="before-footer">


</div>


<div class="footer">


 
<div class="card-body">
   
    <footer class="footer">Developed by <a href="https://www.linkedin.com/in/yunus-kulcu/">Kulcu</a> - İstek ve önerileriniz için <a href="
    contact-us.php">tıklayın</a></footer>
 
 
</div>

</div>