<?php
  

  namespace App\Controllers;

use App\Models\Income;

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
  }

?>