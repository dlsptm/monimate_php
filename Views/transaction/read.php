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
<?php endif ?>


<?php if (!isset($transac)) : ?></p>
  <h1>Transactions</h1>


  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Titre</th>
        <th scope="col">Montant</th>
        <th scope="col">Lieu d'achat</th>
        <th scope="col">Date</th>
        <th scope="col">Catégorie</th>
        <th scope="col">Option</th>
        <th scope="col">Transaction courante</th>
        <th scope="col">Facture</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($transactions as $transaction) : ?>
        <tr>
          <th scope="row"><?= $transaction->id; ?>
          </th>
          <td><?= $transaction->title; ?></td>
          <td><?= $transaction->amount; ?>€</td>
          <td><?= $transaction->location; ?></td>
          <td><?= $transaction->created_at; ?></td>
          <td><?= $transaction->category_title; ?></td>
          <td>x<?= $transaction->payment_option; ?></td>
          <td><?= $transaction->is_monthly == 0 ? 'Oui' : 'Non'; ?></td>
          <td><?= $transaction->invoice_href !== null ? '<a href="./assets/upload/invoices/' . $transaction->invoice_href . '" target="_blank">Facture</a>' : '<a href="index?p=transaction/invoice/' . $transaction->id . '" target="_blank">Ajouter une facture</a>' ?></td>
          <td>
            <a href=<?= "index?p=transaction/index/$transaction->id"; ?> class='btn btn-info'>Modifier</a>
            <a href=<?= "index?p=transaction/delete/$transaction->id"; ?> class='btn btn-warning' onclick='confirm("Êtes vous sur de vouloir le supprimer ?")'>Supprimer</a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

<?php else :   ?>

  <h1>Transaction #<?= $transac->id; ?></h1>
  <p><?= $transac->title; ?></p>
  <p><?= $transac->amount; ?>€</p>
  <p><?= $transac->location; ?></p>
  <p><?= $transac->created_at; ?></p>
  <p><?= $transac->category_title; ?></p>
  <p>x<?= $transac->payment_option; ?></p>
  <p><?= $transac->is_monthly == 0 ? 'Oui' : 'Non'; ?></p>
  <p><?= $transac->invoice_href != null ? '<a href="./assets/upload/invoices/' . $transac->invoice_href . '" target="_blank">Facture</a>' : 'Pas de facture' ?></p>
  <p>
    <a href=<?= "index?p=transaction/index/$transac->id"; ?> class='btn btn-info'>Modifier</a>
    <a href=<?= "index?p=transaction/delete/$transac->id"; ?> class='btn btn-warning' onclick='confirm("Êtes vous sur de vouloir le supprimer ?")'>Supprimer</a>
  </p>

<?php endif ?>