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

<h1>Transactions</h1>
<?= $form ; ?>


<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Titre</th>
        <th scope="col">Montant</th>
        <th scope="col">Lieu d'achat</th>
        <th scope="col">Catégorie</th>
        <th scope="col">Facilité de paiement</th>
        <th scope="col">Transaction courante</th>
        <th scope="col">Date</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($transactions as $transaction) : ?>
        <tr>
          <th scope="row"><?= $transaction->id; ?>
          </th>
          <td><?= $transaction->title; ?></td>
          <td><?= $transaction->amount; ?></td>
          <td><?= $transaction->location; ?></td>
          <td><?= $transaction->category_title; ?></td>
          <td><?= $transaction->payment_option; ?></td>
          <td><?= $transaction->is_monthly == 0 ? 'Oui' : 'Non'; ?></td>
          <td><?= $transaction->created_at; ?></td>
          <td>
            <a href=<?= "index?p=transaction/index/$transaction->id"; ?> class='btn btn-info'>Modifier</a>
            <a href=<?= "index?p=transaction/delete/$transaction->id"; ?> class='btn btn-warning' onclick='confirm("Êtes vous sur de vouloir le supprimer ?")'>Supprimer</a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>