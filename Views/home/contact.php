<?php if (isset($_SESSION['error']) && !empty($_SESSION["error"])) : ?>
  <div class="alert alert-danger" role='alert'>
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
      <section class="container p-5 contact-section" id="contact">
        <h3 class="m-5 mt-5 fs-1">Contact</h3>
      
        <form method="POST" action="">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="lastname" class="form-label">Nom</label>
              <input type="text" class="form-control" name="firstname">
            </div>
            <div class="col-md-6 mb-3">
              <label for="firstname" class="form-label">Prénom</label>
              <input type="text" class="form-control" name="lastname">
            </div>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" class="form-control" name="email">
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Objet</label>
            <input type="text" class="form-control" name="subject">
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" name="message" style="resize: none;" rows="3"></textarea>
          </div>
          <button type="submit" class="btn form-submit-btn colorWhite">Envoyer</button>
        </form>
      </section>
    </main>

<?php
  require_once ROOT.'/Views/inc/footer.php';
?>