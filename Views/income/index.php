<?php

use App\Utils\Utils;

 if (isset($_SESSION['error']) && !empty($_SESSION["error"])) : ?>
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
<div class="container">
  <h1>Income</h1>

  <?= $form ?>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Source</th>
        <th scope="col">Montant</th>
        <th scope="col">Date</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($incomes as $income) : 
        if ($income->user_id == $_SESSION['user']['id']) :?>
        <tr>
          <th scope="row"><?= $income->id; ?>
          </th>
          <td><?= $income->title; ?>
          </td>
          <td><?= Utils::numberFormat($income->amount); ?>€
          </td>
          <td><?= date("d-m-Y", strtotime($income->created_at)); ?></td>

          <td>
            <a href=<?= "index?p=income/index/$income->id"; ?> class='btn greenRadient'>Modifier</a>
            <a href=<?= "index?p=income/delete/$income->id"; ?> class='btn btn-light'               onclick='confirm("Êtes vous sur de vouloir le supprimer ?")'>Supprimer</a>
          </td>
        </tr>
      <?php endif; endforeach ?>
    </tbody>
  </table>

</div>