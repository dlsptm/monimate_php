<?php

namespace App\Core;

use App\Controllers\CategoryController;


/**
 * Routeur principal
 */
class Router
{
  public function start()
  {

    // on start la session
    session_start();

    // on retire le trailing slash éventuel de l'url
    // on récupère l'url
    $uri = $_SERVER['REQUEST_URI'];
    // on vérifie que uri n'est pas vide et se termine par un /

    if (!empty($uri) && $uri[-1] === '/') {
      // on enlève le /
      $uri = substr($uri, 0, -1);

      // on envoie un code de redirection permanente
      http_response_code(301);

      // on redirige vers l'url /
      header('Location:' . $uri);
    }

    // on gère les paramètres d'URL
    //p=controlleur/methode/paramètres
    // on sépare les paramètres dans un tableau
    if (isset($_GET['p'])) {
      $params = explode('/', $_GET['p']);

      if ($params[0] !== '') {
        // on a au moins 1 paramètre
        // on reccupère le nom du controller afin de l'instancier
        // array_shift($params) = enlève la prmeière valeur du tableau
        $controller = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';

        if (class_exists($controller)) {
          $controller = new $controller();
        } else {
          http_response_code(404);
          header('Location: _404');
        }


        // on réccupère le 2ème paramètre d'Url
        $method = isset($params[0]) ? array_shift($params) : 'index';

        if (method_exists($controller, $method)) {
          // si il reste des paramètres on les passe à la méthode
          //call_user_func_array() envoi à une fonction un tableau de paramètres, la fonction qui est devant est un tableau de $controller et $metgod, il va chercher la method dans la focntion controller + passer les paramètres
          isset($params[0]) ? call_user_func_array([$controller, $method], $params) : $controller->$method();
        } else {
          http_response_code(404);
          header('Location: _404');
        }
      }
    } else {
      $controller = new CategoryController;
    }
  }
}