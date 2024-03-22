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

<header class="d-flex flex-column justify-content-center align-items-center">
      <div class="container mt-5 text-center">
        <h1 class="fw-bold">Votre plateforme de gestion de budget</h1>
        <h2 class="my-3 fs-4">Faites de chaque dépense une étape vers une maîtrise financière simplifiée et lucrative !</h2>
        <a href="index?p=security/login" class="btn orangeRadiant px-4 py-2 colorWhite fs-5 m-5 border-radius-50">Commencer</a>
      </div>
      <img src="./assets/img/dashboard.png" alt="" class=" img-round img-fluid w-75">
    </header>

    <main>
      <section class="container p-5" id="services">
        <h3 class="m-5 mt-5 fs-1">Services</h3>
        <div class="row gap-5">
          <div class="col-md gap-2">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate expedita, quo quas unde pariatur magnam aliquid maiores natus obcaecati et incidunt iure, provident odio totam perspiciatis accusantium? Necessitatibus minima officia quae sit quaerat molestiae velit eum tempora, dolor magni debitis corrupti. Accusamus consectetur natus inventore, officia ut eos iure sunt!</p>
          </div>
          <div class="col-md">
            <img src="{{ asset('img/logo_light.png') }}" alt="" class="img-round img-fluid w-100">
          </div>
        </div>
        <div class="row my-3">
          <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed asperiores odio tempore error, tempora recusandae aliquam quidem, hic, cupiditate molestias libero quisquam iusto ex in atque rem consequatur nulla reprehenderit.</p>
        </div>
        <div class="row gap-5">
          <div class="col-md">
            <img src="{{ asset('img/logo_light.png') }}" alt="" class="img-round img-fluid w-100">
          </div>
          <div class="col-md gap-2">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate expedita, quo quas unde pariatur magnam aliquid maiores natus obcaecati et incidunt iure, provident odio totam perspiciatis accusantium? Necessitatibus minima officia quae sit quaerat molestiae velit eum tempora, dolor magni debitis corrupti. Accusamus consectetur natus inventore, officia ut eos iure sunt!</p>
          </div>
        </div>
      </section>
    </main>

<?php
  require_once ROOT.'/Views/inc/footer.php';
?>