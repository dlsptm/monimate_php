<h1>Salut</h1>

<?php
  foreach ($categories as $category) :
?>
  <h2><?= $category->title ; ?></h2>
  <p><?= $category->icon ; ?></p>
  <a href="index?p=category/update/<?= $category->id ; ?>">Modifier</a>
  <!-- <a href="/category/delete/<?= $category->id ; ?>">Supprimer</a> -->

<?php
  endforeach
?>