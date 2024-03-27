<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= !isset($description) ? 'Votre plateforme de gestion de budget' : $description ?>">

  <!-- Bootstrap CSS--> 
  <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

    <!-- CSS --> 
  <link rel="stylesheet" href="./assets/css/style.css">

    <!-- FontAwesome--> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- Bootstrap JS--> 
  <script src="./assets/js/bootstrap.bundle.min.js"></script>

  <!-- CHART.JS--> 
  <script src="../node_modules/chart.js/dist/chart.umd.js"></script>
    <!--  JS --> 
  <script src="./assets/js/script.js" defer></script>


  <title><?= !isset($title) ? 'Bienvenue dans Monimate' : $title ?></title>

</head>
<body>
<?php if (!isset($_SESSION['user'])) : ?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index"><img src="./assets/img/logo_light.png" alt="logo" width="130px"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
      <ul class="navbar-nav w-100 justify-content-around">
        <li class="nav-item">
          <a class="nav-link text-dark" href="index#services">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="index#about">A propos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="index?p=home/contact">Contact</a>
        </li>
      </ul>
      <div class="d-flex">
        <a href="index?p=security/register" class="btn darkerbg px-4 py-2 text-dark me-2 border-radius-50">Inscription</a>
        <a href="index?p=security/login" class="btn greenRadient px-4 py-2 colorWhite border-radius-50">Connexion</a>
      </div>
    </div>
  </div>
</nav>
<?php else : ?>

  <nav class="navbar navbar-expand-lg bg-body-tertiary w-100">
  <div class="container-fluid">
            <!-- Logo -->
    <a class="navbar-brand" href="index"><img src="./assets/img/logo_light.png" alt="logo" width="130px"></a>
    <!-- Bouton de bascule pour le mode responsive -->
    <button class="navbar-toggler border-0 " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <img src="assets/img/<?= $_SESSION['user']['profile'] ; ?>" alt="photo de profile" class="rounded-circle navbar-toggler-icon">
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
      <ul class="navbar-nav w-100 justify-content-around">
        <li class="nav-item">
          <a class="btn darkerbg px-5 py-3 text-dark me-2 border-radius-50" href="index?p=security/profil">
            <i class="fa-regular fa-user mx-2"></i>
            Mon compte
          </a>							</li>
        <li class="nav-item">
          <a class="btn darkerbg px-5 py-3 text-dark me-2 border-radius-50" href="index?p=transaction/index">
            <i class="fa-solid fa-circle-plus mx-2"></i>
            Ajouter une transaction
          </a>
        </li>
      </ul>
        <li class="nav-item dropdown  d-flex display-none">
          <img src="assets/img/<?= $_SESSION['user']['profile']?>" alt="logo" class="rounded-circle nav-link dropdown-toggle mx-3" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" width="80">

          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li>
              <a class="dropdown-item" href="#">Préférences</a>
            </li>
            <li>
              <a class="dropdown-item" href="index?p=security/logout">Déconnexion</a>
            </li>
          </ul>
        </li>
    </div>
  </div>
</nav>
 <?php endif ?> 
  
