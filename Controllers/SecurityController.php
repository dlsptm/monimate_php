<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\User;
use App\Service\Mail;

class SecurityController extends Controller
{

  public function register()
  {
    if (isset($_POST) && !empty($_POST)) {
      // vérification si tous les champs sont bien remplis 
      if (!Form::validate($_POST, ['username', 'email', 'password', 'confirm', 'RGPDConsent'])) {
        $_SESSION['error'] = 'Veuillez remplir tous les champs du formulaire.';
      }

      // on vérifie si tous les champs sont valides
      // si l'utilisateur a bien consenti à nos conditions d'utilisation
      if ($_POST['RGPDConsent'] !== 'on') {
        $_SESSION['error'] = 'Veuillez consentir à nos conditions d\'utilisation';
      }

      // vérification si email et username existe déjà
      if (User::emailExists($_POST['email']) || User::usernameExists($_POST['email'])) {
        $_SESSION['error'] = 'Un compte existe déjà avec cet email ou ce pseudo';
      }

      // Vérification de la longueur du nom d'utilisateur
      if (strlen($_POST['username']) < 4) {
        $_SESSION['error'] = 'Le nom d\'utilisateur doit contenir au moins 4 caractères';
      }

      // Vérification de la validité de l'email
      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'L\'adresse email est invalide';
      }

      // Vérification de la correspondance entre les mots de passe
      if (strlen($_POST['password']) < 3 && $_POST['password'] !== $_POST['confirm']) {
        $_SESSION['error'] = 'Le mot de passe doit contenir au moins 3 caractères et les mots de passe doivent correspondre';
      }

      // Si aucune erreur n'a été définie, procéder à l'inscription
      if (!isset($_SESSION['error'])) {
        $username = htmlspecialchars(strip_tags(trim($_POST['username'])));
        $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
        $password = htmlspecialchars(strip_tags(trim($_POST['password'])));
        $password = password_hash($password, PASSWORD_DEFAULT);

        // générer un identifiant unique et Calculer le hachage SHA-256 de l'identifiant unique
        // Le choix de l'algorithme de hachage SHA-256
        // SHA-256 est une fonction de hachage cryptographique réputée pour sa robustesse et sa sécurité.
        // Elle produit un hachage de 256 bits, ce qui rend les collisions (lorsque deux entrées différentes produisent le même hachage) extrêmement improbables.
        // Cela en fait un choix sûr pour générer des tokens sécurisés dans divers scénarios, tels que l'authentification, la vérification de l'intégrité des données, etc.
        $token = hash('sha256', uniqid());


        $user = new User;
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setToken($token);

        // Stocker l'utilisateur dans la base de données
        $user->insert();

        $_SESSION['success'] = 'Vous vous êtes inscrits avec succès. Un mail vous a été envoyé afin d\'activer votre compte.';


        // ici envoi d'un mail
        $mailer = new Mail;
        $mailer->sendEmail(
          $user->getEmail(),
          "Bienvenue chez Monimate ! : Activez votre compte !",
          $user->getUsername(),
          'Bienvenue chez Monimate. Afin d\'activer votre compte,veuillez cliquer sur le bouton ci-dessous.<br>Si ce message ne vous concerne pas. Veuillez l\'ignorer.<br> L\'Equipe de Monimate',
          'index?p=security/activate/' . $user->getToken(),
          'Activez votre compte'
        );
      }
    }

    $form = new Form();

    // Commencer le formulaire
    $form
      ->startForm('post', '', ['class' => 'form'])
      ->addLabel('Pseudo', 'username')
      ->addInput('text', 'username', ['required' => true])
      ->addLabel('Adresse Email', 'email')
      ->addInput('email', 'email', ['required' => true])
      ->addLabel('Mot de passe', 'password')
      ->addInput('password', 'password', ['required' => true])
      ->addLabel('Confirmer votre mot de passe', 'confirm')
      ->addInput('password', 'confirm', ['required' => true])
      ->addInput('checkbox', 'RGPDConsent', ['required' => true])
      ->addLabel('Accepter les conditions d\'utilisation', 'RGPDConsent')
      ->addSubmit('Valider')
      ->endForm();

    if (isset($_SESSION['user'])) {
      header('Location: index');
    }

    // Afficher le formulaire
    $this->render('security/register', [
      'form' => $form->create()
    ]);
  }


  public function login()
  {
    // on vérifie que le formulaire est complet
    if (isset($_POST) && !empty($_POST)) {
      if (Form::validate($_POST, ['email', 'password'])) {
        $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
        $password = htmlspecialchars(strip_tags(trim($_POST['password'])));

        $user = new User;
        $userArray = $user->findOnebyEmail($email);

        if (!$userArray) {
          $_SESSION["error"] = 'L\'adresse email ou le mot de passe est incorrect';
          header('Location : index?p=security/login');
          exit;
        }

        // ici l'utilisateur existe
        // on hydrate l'objet
        $user->setter($userArray);

        //on verifie si le mot de passe est correct
        if (password_verify($password, $user->getPassword())) {
          // on vérifie si l'utilisateur est bien actif
          if ($user->getActive() === 1) {
            $user->getSession();
            header('Location: index');
          } else {
            $_SESSION["error"] = 'Votre compte n\'est pas activé. Veuillez vérifier vos e-mails.';
            header('Location : index?p=security/login');
          }
        } else {
          $_SESSION["error"] = 'L\'adresse email ou le mot de passe est incorrect';
          header('Location : index?p=security/login');
          exit;
        }
      }
    }


    $form = new Form();

    // Commencer le formulaire
    $form
      ->startForm('post', '', ['class' => 'form'])
      ->addLabel('Adresse Email', 'email')
      ->addInput('email', 'email', ['required' => true])
      ->addLabel('Mot de passe', 'password')
      ->addInput('password', 'password', ['required' => true])
      ->addSubmit('Valider')
      ->endForm();

    if (isset($_SESSION['user'])) {
      header('Location: index');
    }
    // Afficher le formulaire
    return $this->render('security/login', [
      'form' => $form->create()
    ]);
  }

  public function logout()
  {
    // redirection si pas d'utilisateur connecté
    if (!isset($_SESSION['user'])) {
      header('Location: index');
      exit;
    }

    // on désactive la session
    unset($_SESSION['user']);

    // redirection 
    header('Location: index');
  }

  public function activate(string $token)
  {
    // Redirection si un utilisateur est déjà connecté
    if (isset($_SESSION['user'])) {
      header('Location: index');
      exit;
    }

    $user = new User;

    $userArray = $user->findOnebyToken($token);

    // Si aucun utilisateur n'est trouvé avec le token spécifié
    if (!$userArray) {
      $_SESSION["error"] = 'Utilisateur non trouvé';
      header('Location: index?p=security/login');
      exit;
    }

    // Hydratation de l'objet User avec les données de l'utilisateur trouvé
    $user->setter($userArray);

    // Si le compte est déjà activé
    if ($user->getActive() == 1) {
      $_SESSION["error"] = 'Votre compte est déjà activé';
      header('Location: index?p=security/login');
      exit;
    }

    // Activation du compte
    $user->setActive(1);
    $user->setToken('');
    $user->update($user->getId());

    // Message de succès et redirection vers la page de connexion
    $_SESSION["success"] = 'Votre compte a bien été activé';
    header('Location: index?p=security/login');
    exit;
  }

  public function reset()
  {

    if (isset($_POST) && !empty($_POST)) {
      if (Form::validate($_POST, ['email'])) {
        $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
        $token = hash('sha256', uniqid());

        $user = new User;

        $userArray = $user->findOnebyEmail($email);

        // Si aucun utilisateur n'est trouvé avec le token spécifié
        if (!$userArray) {
          $_SESSION["error"] = 'Utilisateur non trouvé';
          header('Location: index?p=security/login');
          exit;
        }
        $user->setter($userArray);

        // désactivation du compte
        $user->setActive(0);
        $user->setToken($token);
        $user->update($user->getId());


        // ici envoi d'un mail
        $mailer = new Mail;
        $mailer->sendEmail(
          $user->getEmail(),
          "Modification de votre mot de passe !",
          $user->getUsername(),
          'Votre demande de modification de mot de passe a bien été pris en compte. Veuillez cliquer sur le bouton afin de le modifier.<br>Si ce message ne vous concerne pas. Veuillez l\'ignorer.<br> L\'Equipe de Monimate',
          'index?p=security/newPassword/' . $user->getToken(),
          'Modifier mon mot de passe'
        );
      }
    }

    $form = new Form();

    // Commencer le formulaire
    $form
      ->startForm('post', '', ['class' => 'form'])
      ->addLabel('Adresse Email', 'email')
      ->addInput('email', 'email', ['required' => true])
      ->addSubmit('Valider')
      ->endForm();
      $this->render('security/reset', [
        'form' => $form->create()
      ]);  
  }


  public function newPassword(string $token)
  {

    if (isset($_POST) && !empty($_POST)) {
      // vérification si tous les champs sont bien remplis 
      if (!Form::validate($_POST, ['password', 'confirm'])) {
        $_SESSION['error'] = 'Veuillez remplir tous les champs du formulaire.';
      }

      // Vérification de la correspondance entre les mots de passe
      if (strlen($_POST['password']) < 3 && $_POST['password'] !== $_POST['confirm']) {
        $_SESSION['error'] = 'Le mot de passe doit contenir au moins 3 caractères et les mots de passe doivent correspondre';
      }

      // Si aucune erreur n'a été définie, procéder à l'inscription
      if (!isset($_SESSION['error'])) {
        $password = htmlspecialchars(strip_tags(trim($_POST['password'])));
        $password = password_hash($password, PASSWORD_DEFAULT);

        $user = new User;
        $userArray = $user->findOnebyToken($token);

        // Si aucun utilisateur n'est trouvé avec le token spécifié
        if (!$userArray) {
          $_SESSION["error"] = 'Utilisateur non trouvé';
          header('Location: index?p=security/login');
          exit;
        }

        // Hydratation de l'objet User avec les données de l'utilisateur trouvé
        $user->setter($userArray);

        $user->setPassword($password);
        $user->setActive(1);
        $user->setToken('');
        $user->update($user->getId());
        $_SESSION['success'] = 'Votre mot de passe a bien été modifié.';
        header('Location: index?p=security/login');
        exit;
      }
    }

    $form = new Form();

    // Commencer le formulaire
    $form
      ->startForm('post', '', ['class' => 'form'])
      ->addLabel('Mot de passe', 'password')
      ->addInput('password', 'password', ['required' => true])
      ->addLabel('Confirmer le mot de passe', 'confirm')
      ->addInput('password', 'confirm', ['required' => true])
      ->addSubmit('Valider')
      ->endForm();

    if (isset($_SESSION['user'])) {
      header('Location: index');
    }
    // Afficher le formulaire
    return $this->render('security/new_password', [
      'form' => $form->create()
    ]);

  }

  public function profil()
  {
    return $this->render('security/profil');
  }
}