<?php if(isset($_SESSION['error']) && !empty($_SESSION["error"])): ?>
  <div class="alart alert-danger" role='alert'>
    <?php echo $_SESSION["error"] ; unset($_SESSION['error']);?>
  </div>
  <?php
    elseif(isset($_SESSION['success']) && !empty($_SESSION["success"])):?>
      <div class="alert alert-success" role='alert'>
    <?php echo $_SESSION["success"] ; unset($_SESSION['success']);?>
  </div>
<?php endif?>

<h1>Connexion</h1>
<?= $form ; ?>
<a href="index?p=security/register">Pas de compte ?</a>
<a href="index?p=security/reset">Oublié votre mot de passe ?</a>
