<?php 
  session_start();
  define('ROOT', dirname(__DIR__));
require_once ROOT.'/Views/inc/header.php';
?>

<main class='d-flex flex-column justify-content-center align-items-center w-100'>

<h1 class='mt-5'>LA PAGE N'EXISTE PAS</h1>
<img src="assets/img/Union.png" alt="" width=150 class='mt-4'>
<a href="index" class='btn form-submit-btn text-white border-radius-50 my-5'>Revenir à la page principale</a>

</main>


<?php
  require_once ROOT.'/Views/inc/footer.php';
?>
