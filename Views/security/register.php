<?php if(isset($_SESSION['error']) && !empty($_SESSION["error"])): ?>
  <div class="alart alert-danger" role='alert'>
    <?php echo $_SESSION["error"] ; unset($_SESSION['error']);?>
  </div>
  <?php
    elseif(isset($_SESSION['success']) && !empty($_SESSION["success"])):?>
      <div class="alert alert-success" role='alert'>
    <?php echo $_SESSION["success"] ; unset($_SESSION['success']);?>
  </div>
  <?php endif;

require_once ROOT.'/Views/inc/header.php';
?>

<div class="container">
<h1>S'inscrire</h1>
<?= $form ; ?>
<div>
  <a href="index?p=security/login" class="btn">Déjà un compte ?</a>
  </div>
  </div>