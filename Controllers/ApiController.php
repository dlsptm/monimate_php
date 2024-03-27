<?php
  

  namespace App\Controllers;

use App\Models\Income;
use App\Models\User;

  class ApiController extends Controller
  {

    static public function getIncomes ($date=null)
    {
  
        $id = $_SESSION['user']['id'];
        $income = new Income;
        $getIncome = $income->findAllById($id, $date);
  
        header('Content-Type: application/json');
        echo json_encode($getIncome) ;

    }

    static public function getMode ()
    {
      $id = $_SESSION['user']['id'];
      $user = new User;
      $getMode = $user->getMode($id);

      header('Content-Type: application/json');
      echo json_encode($getMode) ;
    }
    
  }

?>