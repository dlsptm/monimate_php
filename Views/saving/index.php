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

<div class="container">
  <h1>Savings</h1>

  <?= $form ?>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Source</th>
        <th scope="col">Montant</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($savings as $saving) : ?>
        <tr>
          <th scope="row"><?= $saving->id; ?>
          </th>
          <td><?= $saving->title; ?>
          </td>
          <td><?= $saving->amount; ?>€
          </td>
          <td>
            <a href=<?= "index?p=saving/index/$saving->id"; ?> class='btn btn-info'>Modifier</a>
            <a href=<?= "index?p=saving/delete/$saving->id"; ?> class='btn btn-warning'>Supprimer</a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

</div>