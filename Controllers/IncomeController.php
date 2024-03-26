<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\Category;
use App\Models\Income;

class IncomeController extends Controller
{

  public function index(string $id = null)
  {
    if (!isset($_SESSION['user'])) {
      header('Location: index?p=security/login');
      exit;
    }

    $income = new Income();
    
    if ($id) {
      $inc = $income->find($id);
    }


    if (isset($_POST) && !empty($_POST)) {
      // vérification si tous les champs sont bien remplis 
      if (!Form::validate($_POST, ['title', 'amount'])) {
        $_SESSION['error'] = 'Veuillez remplir tous les champs du formulaire.';
      }

      // on vérfie que l'input amount a bien une valeur numérique
      if (!is_numeric($_POST['amount'])) {
        $_SESSION['error'] = 'Le montant doit être un nombre.';
      }
      // on vérifie que l'utilisateur a mis une valeur de plus de 2 caractères
      if (strlen($_POST['title']) < 3) {
        $_SESSION['error'] = 'Le titre est trop court.';
      }
      
      if (!isset($_SESSION['error'])) {
        $title = htmlspecialchars(strip_tags(trim($_POST['title'])));
        $amount = htmlspecialchars(strip_tags(trim($_POST['amount'])));


        $data = [
          'title' => $title, 
          'amount' => $amount, 
          'userId' => $_SESSION['user']['id']
        ];

        $income->setter($data);
  
        if (isset($id)) {  
          $income->update($id);
        } else {
          $income->insert($income);
        }
      }

    }



    $form = new Form();

    // Commencer le formulaire
    $form
      ->startForm('post', '#', ['class' => 'form'])
      ->addLabel('Source', 'title', ['class' => 'form-label'], 'my-3')
      ->addInput('text', 'title', ['required' => true, 'value' => $inc->title ?? '', 'class' => 'form-control'])
      ->addLabel('Montant', 'amount', ['class' => 'form-label'], 'my-3')
      ->addInput('text', 'amount', ['required' => true, 'value' => $inc->amount ?? '', 'class' => 'form-control'])
      ->addSubmit('Valider', ['class' => 'btn form-submit-btn my-3 text-white'])
      ->endForm();


    // Afficher le formulaire
    $this->render('income/index', [
      'title' => $id ? 'Modifier une source d\'entrée' : 'Ajouter une une source d\'entrée',
      'description' => 'ceci est la description',
      'form' => $form->create(),
      'incomes' => $income->findAll()
    ]);
  }


  public function delete(string $id)
  {
    // protection des routes 
    if (!isset($_SESSION['user'])) {
      header('Location: index?p=security/login');
      exit;
    }
    $income = new Income();
    // Vérifiez si un identifiant est spécifié
    if ($id !== null) {
      // Récupérez les détails de la catégorie à l'index spécifié
      $inc = $income->find($id);

      // Vérifiez si la catégorie existe
      if (!$inc) {
        $_SESSION["error"] = 'Erreur, non trouvée';
        header('Location: index?p=category/index');
        exit;
      }

      $income->delete($id);

      $_SESSION['success'] = 'Vous avez bien suprimer l\'income';
      header('Location: index?p=income/index');
      exit;
    }
  }


}
