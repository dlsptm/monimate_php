<?php

namespace App\Controllers;

use App\Core\Form;

class HomeController extends Controller
{
  
  public function index ()
  {
    if (isset($_SESSION['user'])) {
      header('Location: index?p=category/index');
      exit;
    }


    $this->render('home/index', [
      'title' =>'Modifier une transaction',
      'description' => 'ceci est la description',
    ]);  }


  public function legal ()
  {
    if (isset($_SESSION['user'])) {
      header('Location: index?p=category/index');
      exit;
    }


    $this->render('home/legal', [
      'title' =>'Modifier une transaction',
      'description' => 'ceci est la description',
    ]);  }

  public function conditions ()
  {
    if (isset($_SESSION['user'])) {
      header('Location: index?p=category/index');
      exit;
    }

    $this->render('home/conditions', [
      'title' =>'Modifier une transaction',
      'description' => 'ceci est la description',
    ]);  }
}