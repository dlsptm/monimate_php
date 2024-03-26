<?php

use App\Utils\Utils;

 if (isset($_SESSION['error']) && !empty($_SESSION["error"])) : ?>
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
  <div class="container my-5">
  <h1 class='mb-3'>Transaction de la categorie <?= $transactions[0]->category_title; ?> 
  </h1>

  <a href="index?p=transaction/index" class='btn orangeRadiant mb-4 text-white'>Ajouter une transaction</a>

  <div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Titre</th>
        <th scope="col">Montant</th>
        <th scope="col">Lieu d'achat</th>
        <th scope="col">Date</th>
        <th scope="col">Option</th>
        <th scope="col">Transaction courante</th>
        <th scope="col">Facture</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($transactions as $transaction) : 
        if ($transaction->user_id == $_SESSION['user']['id']) :
        ?>
        
        <tr>
          <th scope="row"><?= $transaction->id; ?>
          </th>
          <td><?= $transaction->title; ?></td>
          <td><?= Utils::numberFormat($transaction->amount); ?>€</td>
          <td><?= $transaction->location; ?></td>
          <td><?= $transaction->created_at; ?></td>
          <td>x<?= $transaction->payment_option; ?></td>
          <td><?= $transaction->is_monthly == 1 ? 'Oui' : 'Non'; ?></td>
          <td><?= $transaction->invoice_href !== null ? '<a href="./assets/upload/invoices/' . $transaction->invoice_href . '" target="_blank" class="btn btn-light">Facture</a>' : '<a href="index?p=transaction/invoice/' . $transaction->id . '" target="_blank" class="btn btn-light">Ajouter une facture</a>' ?></td>
          <td>
            <a href=<?= "index?p=transaction/index/$transaction->id"; ?> class='btn greenRadient text-white'>Modifier</a>
            <a href=<?= "index?p=transaction/delete/$transaction->id"; ?> class='btn orangeRadiant text-white' onclick='confirm("Êtes vous sur de vouloir le supprimer ?")'>Supprimer</a>
          </td>
        </tr>
      <?php 
      endif;
      endforeach ?>
    </tbody>
  </table>
  </div>
</div>