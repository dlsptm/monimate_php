<?php

use App\Autoloader;
use App\Models\Category;
use App\Models\User;

  require_once './Autoloader.php';
Autoloader::register();


// Instancier CategoryModel
$user = new Category();

// Vous pouvez maintenant utiliser les méthodes de CategoryModel ainsi que celles héritées de Model

// $donnees = [
//   'title' => 'test3 modifié',
//   'icon' => 'test3 modifié'
// ];

// $cat = $category->hydrate($donnees);

// $category->delete(2);

echo '<pre>';
var_dump($user);
echo '</pre>';

?>