<?php
use App\Autoloader;
use App\Core\Router;

// on gén!re une constante qui contiendra le chemin vers index.php
  define('ROOT', dirname(__DIR__));

  require_once ROOT.'/Autoloader.php';
  Autoloader::register();


// on sépare les paramètres afin de configurer l'url

  $main = new Router();
  $main->start();
?>