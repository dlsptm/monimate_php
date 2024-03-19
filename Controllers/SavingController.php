<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\Saving;

class SavingController extends Controller
{

  public function index(string $id = null)
  {
    if (!isset($_SESSION['user'])) {
      header('Location: index?p=security/login');
      exit;
    }

    $saving = new Saving();
    
    if ($id) {
      $sav = $saving->find($id);
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

        $saving->setter($data);
  
        if (isset($id)) {  
          $saving->update($id);
        } else {
          $saving->insert($saving);
        }
      }

    }



    $form = new Form();

    // Commencer le formulaire
    $form
      ->startForm('post', '#', ['class' => 'form'])
      ->addLabel('Source', 'title', ['class' => 'form-label'], 'my-3')
      ->addInput('text', 'title', ['required' => true, 'value' => $sav->title ?? '', 'class' => 'form-control'])
      ->addLabel('Montant', 'amount', ['class' => 'form-label'], 'my-3')
      ->addInput('text', 'amount', ['required' => true, 'value' => $sav->amount ?? '', 'class' => 'form-control'])
      ->addSubmit('Valider', ['class' => 'btn form-submit-btn my-3 text-white'])
      ->endForm();


    // Afficher le formulaire
    $this->render('saving/index', [
      'title' => $id ? 'Modifier une économie' : 'Ajouter une une économie',
      'description' => 'ceci est la description',
      'form' => $form->create(),
      'savings' => $saving->findAll()
    ]);
  }


  public function delete(string $id)
  {
    // protection des routes 
    if (!isset($_SESSION['user'])) {
      header('Location: index?p=security/login');
      exit;
    }
    
    $saving = new saving();
    // Vérifiez si un identifiant est spécifié
    if ($id !== null) {
      // Récupérez les détails de la catégorie à l'index spécifié
      $sav = $saving->find($id);

      // Vérifiez si la catégorie existe
      if (!$sav) {
        $_SESSION["error"] = 'Erreur, non trouvée';
        header('Location: index?p=saving/index');
        exit;
      }

      $saving->delete($id);

      $_SESSION['success'] = 'Vous avez bien suprimer l\'saving';
      header('Location: index?p=saving/index');
      exit;
    }
  }

  


}