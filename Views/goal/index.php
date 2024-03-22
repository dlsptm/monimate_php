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
  <h1>goal</h1>

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
      <?php foreach ($goals as $goal) : ?>
        <tr>
          <th scope="row"><?= $goal->id; ?>
          </th>
          <td><?= $goal->title; ?>
          </td>
          <td><?= $goal->amount; ?>€
          </td>
          <td>
            <a href=<?= "index?p=goal/index/$goal->id"; ?> class='btn greenRadient'>Modifier</a>
            <a href=<?= "index?p=goal/delete/$goal->id"; ?> class='btn btn-light'>Supprimer</a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

</div>