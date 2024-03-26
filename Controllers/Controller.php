<?php

namespace App\Controllers;

use App\Models\Income;

abstract class Controller
{

  public function render (string $file, array $data = [])
  {
    // L'utilisation de extract($data) permet de rendre les données accessibles dans la vue sans avoir à les passer une par une. 
    extract($data);
    
    require_once ROOT.'/Views/'.$file.'.php';
    
    
  }
  
}
