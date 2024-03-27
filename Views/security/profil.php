<?php if(isset($_SESSION['error']) && !empty($_SESSION["error"])): ?>
  <div class="alert alert-danger" role='alert'>
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
  <h1 class="my-4">Profil de <?= $_SESSION['user']['username'] ; ?></h1>

  <figure class='d-flex flex-column justify-content-center align-items-center gap-3'>
    <img src="<?= $_SESSION['user']['profile'] == 'default-profile.png' ? "assets/img/{$_SESSION['user']['profile']}" : "assets/upload/user_profil/{$_SESSION['user']['profil']}"; ?>" alt="" width='200'>
    <figcaption><a href="" class="btn btn-outline-dark btn-sm">Changer votre photo</a></figcaption>
</figure>


  <div class=" mt-3 d-flex justify-content-between">
  <p class='m-0'>Pseudo : <?= $_SESSION['user']['username'] ; ?></p>
  <small><a href="index?p=security/username/<?= $_SESSION['user']['id'] ; ?>" class="btn btn-outline-dark btn-sm">changer votre pseudo</a></small>
  </div>

  <div class="mt-3 d-flex justify-content-between">
  <p class='m-0'>Email : <?= $_SESSION['user']['email'] ; ?></p>
  <small><a href="index?p=security/email/<?= $_SESSION['user']['id'] ; ?>" class="btn btn-outline-dark btn-sm">changer votre email</a></small>
  </div>

  <a href="<?= $user->dark_light_mode == 0 ? 'index?p=security/darkmode/' . $_SESSION['user']['id'] : 'index?p=security/lightmode/' . $_SESSION['user']['id']; ?>" class="btn btn-outline-dark btn-sm mt-3" id="switchBtn"><?= $user->dark_light_mode == 0 ? 'Sombre' : 'Light'; ?></a>

  <a href="index?p=security/modifypassword/<?= null, $_SESSION['user']['id'] ; ?>" class="btn btn-outline-dark btn-sm mt-3">Modifier le mot de passe</a>


</div>