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

<div class="container">
  <h1>Catégories</h1>

  <?= $form ?>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Icon</th>
        <th scope="col">Titre</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($categories as $category) : ?>
        <tr>
          <th scope="row"><?= $category->id; ?>
          </th>
          <td><img src="<?= "./assets/upload/categories_icon/$category->icon"; ?>" alt="<?= $category->title;; ?>" width='50'>
          </td>
          <td><?= $category->title; ?>
          </td>
          <td>
            <a href=<?= "index?p=category/index/$category->id"; ?> class='btn greenRadient'>Modifier</a>
            <a href=<?= "index?p=category/delete/$category->id"; ?> class='btn btn-light' onclick='confirm("Êtes vous sur de vouloir le supprimer ?")'>Supprimer</a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

</div>