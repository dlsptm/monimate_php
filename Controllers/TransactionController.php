<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\Category;
use App\Models\Transaction;

class TransactionController extends Controller
{

  public function index ()
  {
    $transaction = new Transaction();
    $category = new Category();
    $categories = $category->findAllbyTitle();
    $currentDate = date('Y-m-d');

    if (isset($_POST) && !empty($_POST)) {
      // vérification si tous les champs sont bien remplis 
      if (!Form::validate($_POST, ['title', 'amount', 'location', 'category', 'payment_option', 'created_at'])) {
        $_SESSION['error'] = 'Veuillez remplir tous les champs du formulaire.';
        var_dump($_POST);
    }    

    if (!is_numeric($_POST['amount'])) {
      $_SESSION['error'] = 'Le montant doit être un nombre.';
    }

    if (strlen($_POST['title']) < 3) {
      $_SESSION['error'] = 'Le titre est trop court.';
    }

    if (strlen($_POST['location']) < 3) {
      $_SESSION['error'] = 'Le nom du lieu est trop court.';
    }

      // Si aucune erreur n'a été définie, procéder à l'inscription
      if (!isset($_SESSION['error'])) {
        $title = htmlspecialchars(strip_tags(trim($_POST['title'])));
        $amount = htmlspecialchars(strip_tags(trim($_POST['amount'])));
        $location = htmlspecialchars(strip_tags(trim($_POST['location'])));

        $transaction->setTitle($title);
        $transaction->setAmount($amount);
        $transaction->setLocation($location);
        $transaction->setCategoryId($_POST['category']);
        $transaction->setCreatedAt($_POST['created_at']);
        $transaction->setPaymentOption($_POST['payment_option']);
        // $transaction->setUserId($_SESSION['user']['id']);
        $transaction->setUserId(22);

        if (isset($_POST['is_monthly']) && !empty($_POST['is_monthly'])) {
          $transaction->setIsMonthly(1);
        }
        $transaction->insert($transaction);

      }

    }
    
    $form = new Form();

    // Commencer le formulaire
    $form
      ->startForm('post', '', ['class' => 'form', "enctype" => "multipart/form-data"])
      ->addLabel('Titre de la transaction', 'title')
      ->addInput('text', 'title', ['required' => true])
      ->addLabel('Montant', 'amount')
      ->addInput('text', 'amount', ['required' => true])
      ->addLabel('Lieu de l\'achat', 'location')
      ->addInput('text', 'location', ['required' => true])
      ->addLabel('Catégorie', 'category')
      ->addSelect('category', $categories, )
      ->addLabel('Facilité de paiement', 'payment_option')
      ->addInput('number', 'payment_option', ['required' => true, 'min' => 1, 'value' => 1])
      ->addLabel('Date', 'created_at')
      ->addInput('date', 'created_at', ['required' => true, 'min' => 1, 'value' => $currentDate])
      ->addLabel('Transaction Courante', 'is_monthly')
      ->addInput('checkbox', 'is_monthly')
      ->addSubmit('Valider')
      ->endForm();


    // Afficher le formulaire
    $this->render('transaction/index', [
      'form' => $form->create(),
      'transactions' => $transaction->findAllWithJoin('t.*, c.title AS category_title', 'category c', 't.category_id = c.id')
    ]);
  }

}