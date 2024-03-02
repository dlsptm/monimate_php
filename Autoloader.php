<?php

namespace App;

/**
 * cette fonction sera automatiquement appelée lors d'instanciation d'objet lorsque l'on n'a pas précisé les require_once. Elle permet de récupérer le nom de la classe en argument de sa fonction callback

 */
class Autoloader
{
  static function register()
  {
    spl_autoload_register(function ($class) {

      // __DIR__ permet de nous donner l'emplacement du dossier dans lequel on se trouve à partir de la racine du serveur
      // DIRECTORY_SEPARATOR affiche / ou \ en fonction de l'os utilisé

      $class = str_replace(__NAMESPACE__.'\\','', $class);


      $require = __DIR__ . DIRECTORY_SEPARATOR . $class . ".php";


      $final_require = str_replace("\\", DIRECTORY_SEPARATOR, $require);

      if (file_exists($final_require)) {
      require_once $final_require;
      }
    });
  }
}