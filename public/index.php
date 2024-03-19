<?php
use App\Autoloader;
use App\Core\Router;

// on gén!re une constante qui contiendra le chemin vers index.php
  define('ROOT', dirname(__DIR__));
  require_once ROOT.'/Autoloader.php';
  Autoloader::register();

  $main = new Router();
  $main->start();

  // on importe home/index par défaut lorsque l'utilisateur n'est pas connecté
  if (!isset($_SESSION['user']) && $_SERVER["REQUEST_URI"] == '/monimate_php/public/index') {
    require_once ROOT.'/Views/home/index.php';
  }

?>