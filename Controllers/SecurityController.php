<?php
  namespace App\Controllers;

use App\Core\Form;
use App\Models\User;

  class SecurityController extends Controller
  {

    public function register()
{

  // on vérifie si le formulaire est valide 
  if (isset($_POST) && !empty($_POST)) {
  if (Form::validate($_POST, ['username','email', 'password', 'confirm'])) {
    echo 'valide';
  } else {
    echo 'une erreure s\'est produite';
  }
}

    $form = new Form();

    // Commencer le formulaire
    $form
      ->startForm('post', '#', ['class' => 'form'])
      ->addLabel('Pseudo', 'username')
      ->addInput('text', 'username', ['required' => true])
      ->addLabel('Adresse Email', 'email')
      ->addInput('email', 'email', ['required' => true])
      ->addLabel('Mot de passe', 'password')
      ->addInput('password', 'password', ['required' => true])
      ->addLabel('Confirmer votre mot de passe', 'confirm')
      ->addInput('password', 'confirm', ['required' => true])
      ->addSubmit('Valider')
      ->endForm();
    

    // Afficher le formulaire
    $this->render('security/register', [
      'form' => $form->create()
    ]);
    
}


    public function login ()
    {
    return ;
    }

    public function profil ()
    {
    return ;
    }
    

  }

?>