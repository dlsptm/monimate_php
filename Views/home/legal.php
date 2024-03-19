<?php if (isset($_SESSION['error']) && !empty($_SESSION["error"])) : ?>
  <div class="alart alert-danger" role='alert'>
    <?php echo $_SESSION["error"];
    unset($_SESSION['error']); ?>
  </div>
<?php
elseif (isset($_SESSION['success']) && !empty($_SESSION["success"])) : ?>
  <div class="alert alert-success" role='alert'>
    <?php echo $_SESSION["success"];
    unset($_SESSION['success']); ?>
  </div>
  <?php endif;

require_once ROOT.'/Views/inc/header.php';
?>

<main>

<h1 class="text-center fw-bolder">MENTIONS LÉGALES</h1>
<p class="text-center fw-bolder">En vigueur au 18/02/2024</p>
<div class="container">
 <p>Conformément aux dispositions des Articles 6-III et 19 de la Loi n°2004-575 du 21 juin 2004 pour la Confiance dans l’économie numérique, dite L.C.E.N., il est porté à la connaissance des utilisateurs et visiteurs, ci-après l""Utilisateur", du site https://monimate.com , ci-après le "Site", les présentes mentions légales.</p>

<p>La connexion et la navigation sur le Site par l’Utilisateur implique acceptation intégrale et sans réserve des présentes mentions légales.</p>

<p>Ces dernières sont accessibles sur le Site à la rubrique « Mentions légales ».</p>

<h4>ARTICLE 1 - L'EDITEUR</h4>

<p>L’édition et la direction de la publication du Site est assurée par Inès Berber, domiciliée Marseille, dont le numéro de téléphone est NUM, et l'adresse e-mail ADRESSEMAIL.</p>
 
<p>ci-après l'"Editeur".</p>

<h4>ARTICLE 2 - L'HEBERGEUR</h4>

<p>L'hébergeur du Site est la société HEBERGEUR, dont le siège social est situé au ADRESS_HEBERGEUR , avec le numéro de téléphone : 0600000000 + adresse mail de contact</p>

<h4>ARTICLE 3 - ACCES AU SITE</h4>

<p>Le Site est accessible en tout endroit, 7j/7, 24h/24 sauf cas de force majeure, interruption programmée ou non et pouvant découlant d’une nécessité de maintenance.</p>

<p>En cas de modification, interruption ou suspension du Site, l'Editeur ne saurait être tenu responsable.</p>

<h4>ARTICLE 4 - COLLECTE DES DONNEES</h4>

<p>Le Site assure à l'Utilisateur une collecte et un traitement d'informations personnelles dans le respect de la vie privée conformément à la loi n°78-17 du 6 janvier 1978 relative à l'informatique, aux fichiers et aux libertés. </p>

<p>En vertu de la loi Informatique et Libertés, en date du 6 janvier 1978, l'Utilisateur dispose d'un droit d'accès, de rectification, de suppression et d'opposition de ses données personnelles. L'Utilisateur exerce ce droit <a href="{{ path('app_home') }}#contact" class="text-dark">via un formulaire de contact</a></p>
 
 
<p>Toute utilisation, reproduction, diffusion, commercialisation, modification de toute ou partie du Site, sans autorisation de l’Editeur est prohibée et pourra entraînée des actions et poursuites judiciaires telles que notamment prévues par le Code de la propriété intellectuelle et le Code civil.</p>

</div>

</main>

<?php
  require_once ROOT.'/Views/inc/footer.php';
?>