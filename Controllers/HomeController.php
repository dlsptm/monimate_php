<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\Category;
use App\Models\Goal;
use App\Models\Income;
use App\Models\Saving;
use App\Models\Transaction;
use App\Service\Mail;

class HomeController extends Controller
{

  public function index()
  {

    return $this->render('home/index', [
      'title' => 'Modifier une transaction',
      'description' => 'ceci est la description',
    ]);
  }

  public function contact ()
  {
    if (isset($_POST) && !empty($_POST)) {
      // vérification si tous les champs sont bien remplis 
      if (!Form::validate($_POST, ['lastname', 'firstname', 'subject', 'email', 'message'])) {
        $_SESSION['error'] = 'Veuillez remplir tous les champs du formulaire.';
      }

      // Vérification de la validité de l'email
      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'L\'adresse email est invalide';
      }

      if (!isset($_SESSION['error'])) {
        $lastname = htmlspecialchars(strip_tags(trim($_POST['lastname'])));
        $firstname = htmlspecialchars(strip_tags(trim($_POST['firstname'])));
        $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
        $message = htmlspecialchars(strip_tags(trim($_POST['message'])));
        $subject = htmlspecialchars(strip_tags(trim($_POST['subject'])));

        $mailer = new Mail();
        $mailer->contactEmail(
          $email, 
          "$subject",
          "$lastname $firstname",
          $message
        );
      }
    }

    return $this->render('home/contact', [
      'title' => 'Modifier une transaction',
      'description' => 'ceci est la description',
    ]);  }


  public function legal()
  {
    if (isset($_SESSION['user'])) {
      header('Location: index?p=category/index');
      exit;
    }


    return $this->render('home/legal', [
      'title' => 'Modifier une transaction',
      'description' => 'ceci est la description',
    ]);
  }

  public function conditions()
  {
    if (isset($_SESSION['user'])) {
      header('Location: index?p=category/index');
      exit;
    }

    return $this->render('home/conditions', [
      'title' => 'Modifier une transaction',
      'description' => 'ceci est la description',
    ]);
  }

  public function home()
  {

    $transaction = new Transaction;
    $categories = new Category;
    $incomes = new Income;
    $goals = new Goal;

    $columns = 't.*, c.title AS category_title, c.icon AS category_icon';
    $joins = [
      ['table' => 'category c', 'condition' => 't.category_id = c.id'],
    ];


    return $this->render('home/home', [
      'title' => 'Monimate : Votre espace de gestion',
      'description' => 'ceci est la description',
      'transactions' => $transaction->SumAllByCategory(),
      'transacs' => $transaction->sumAll('amount'),
      'trcs' => $transaction->findAllWithJoinAndLimit($columns, $joins),
      'categories' => $categories->findAll(),
      'incomes' => $incomes->sumAll('amount'),
      'savings' => $transaction->sumAllByEconomy(),
      'goals' => $goals->findAll(),
    ]);
  }

  public function date ($date=null)
  {
    $transaction = new Transaction;
    $categories = new Category;
    $incomes = new Income;
    $goals = new Goal;

    $currentYear = date('Y');
    $currentMonth = date('n');


    $columns = 't.*, c.title AS category_title, c.icon AS category_icon';
    $joins = [
      ['table' => 'category c', 'condition' => 't.category_id = c.id'],
    ];

    return $this->render('home/date', [
      'title' => 'Monimate : Votre espace de gestion',
      'description' => 'ceci est la description',
      'transactions' => $date ? $transaction->SumAllByCategory($date) : $transaction->SumAllByCategory($date),
      'transacs' => $transaction->sumAll('amount', $date),
      'trcs' => $transaction->findAllWithJoinAndLimit($columns, $joins, $date),
      'categories' => $categories->findAll(),
      'incomes' => $incomes->sumAll('amount', $date),
      'savings' => $transaction->sumAllByEconomy($date),
      'goals' => $goals->findAll(),
    ]);  }
}
