<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\Goal;

class GoalController extends Controller
{

  public function index(string $id = null)
  {
    if (!isset($_SESSION['user'])) {
      header('Location: index?p=security/login');
      exit;
    }

    $goal = new Goal();
    
    if ($id) {
      $gol = $goal->find($id);
    }


    if (isset($_POST) && !empty($_POST)) {
      // vérification si tous les champs sont bien remplis 
      if (!Form::validate($_POST, ['title', 'amount', 'deadline'])) {
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

        $goal->setter($data);
  
        if (isset($id)) {  
          $goal->update($id);
        } else {
          $goal->insert($goal);
        }
      }

    }



    $form = new Form();

    // Commencer le formulaire
    $form
      ->startForm('post', '#', ['class' => 'form'])
      ->addLabel('Source', 'title', ['class' => 'form-label'], 'my-3')
      ->addInput('text', 'title', ['required' => true, 'value' => $gol->title ?? '', 'class' => 'form-control'])
      ->addLabel('Montant', 'amount', ['class' => 'form-label'], 'my-3')
      ->addInput('text', 'amount', ['required' => true, 'value' => $gol->amount ?? '', 'class' => 'form-control'])
      ->addLabel('Deadline', 'deadline', ['class' => 'form-label'], 'my-3')
      ->addInput('date', 'deadline', ['required' => true, 'value' => $gol->deadline ?? '', 'class' => 'form-control'])
      ->addSubmit('Valider', ['class' => 'btn form-submit-btn my-3 text-white'])
      ->endForm();


    // Afficher le formulaire
    $this->render('goal/index', [
      'title' => $id ? 'Modifier un objectif' : 'Ajouter un objectif',
      'description' => 'gestionnaire de vos objectifs',
      'form' => $form->create(),
      'goals' => $goal->findAll()
    ]);
  }


  public function delete(string $id)
  {
    // protection des routes 
    if (!isset($_SESSION['user'])) {
      header('Location: index?p=security/login');
      exit;
    }
    
    $goal = new Goal();
    // Vérifiez si un identifiant est spécifié
    if ($id !== null) {
      // Récupérez les détails de la catégorie à l'index spécifié
      $gol = $goal->find($id);

      // Vérifiez si la catégorie existe
      if (!$gol) {
        $_SESSION["error"] = 'Erreur, non trouvée';
        header('Location: index?p=goal/index');
        exit;
      }

      $goal->delete($id);

      $_SESSION['success'] = 'Vous avez bien suprimer l\'goal';
      header('Location: index?p=goal/index');
      exit;
    }
  }

  


}