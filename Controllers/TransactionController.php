<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\Transaction;

class TransactionController extends Controller
{

  public function index(int $id = null)
  {
    // protection des routes 
    if (!isset($_SESSION['user'])) {
      header('Location: index?p=security/login');
      exit;
    }

    $transaction = new Transaction();
    $invoice = new Invoice;
    $currentDate = date('Y-m-d');

    if ($id) {
      $transac = $transaction->find($id);
      $inv = $invoice->findOnebyTransactionId($id);
    }

    if (isset($_POST) && !empty($_POST)) {
      // vérification si tous les champs sont bien remplis 
      if (!Form::validate($_POST, ['title', 'amount', 'location', 'category', 'payment_option', 'created_at'])) {
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

      // on vérifie que l'utilisateur a mis une valeur de plus de 2 caractères
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
        $transaction->setUserId($_SESSION['user']['id']);

        if (isset($_POST['is_monthly']) && !empty($_POST['is_monthly'])) {
          $transaction->setIsMonthly(1);
        }

        if ($id)  {
          $transaction->update($id);
        } else {
          $transaction->insert($transaction);
        }

        // ici on vérifie que l'utilisateur a une facture
        // s'il check la checkbox, une facture est demandé
        if (isset($_POST['hasInvoice']) && !empty($_POST['hasInvoice'])) {
          // on vérifie bien qu'il y est un fichier
          if (!Form::validate($_FILES, ['invoice_href'])) {
            $_SESSION['error'] = 'Veuillez remplir tous les champs du formulaire.';
          }

          // le titre de la facture ayant déjà une valeur par défaut il n'est pas nécessaire que l'utilisateur le remplisse
          // on protège la requette sql
          $invoice_title = htmlspecialchars(strip_tags(trim($_POST['invoice_title'])));

          // on vérifie le type mime du fichier
          $allowed = [
            'jpg' => 'image/jpg',
            'jpeg' => 'image/jpg',
            'png' => 'image/png',
            'webapp' => 'image/webapp',
            'pdf' => 'application/pdf'
          ];

          $filename = $_FILES['invoice_href']['name'];
          $filetype = $_FILES['invoice_href']['type'];
          $filesize = $_FILES['invoice_href']['size'];

          $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

          //on vérifie l'absence de l'extension dans les clés $allowed ou l'absence du type MIME dans les valeurs
          if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
            $_SESSION['error'] = 'Le type du fichier n\'est pas autorisé. Nous acception les fichiers pdf, png, jpg/jpeg et webapp';
          }

          // Ici le type est correct
          // on vérifie le poids en la limitant à 3Mo
          if ($filesize > (1024 * 1024) * 5) {
            $_SESSION['error'] = 'Le fichier est trop volumineux (Maximum 5Mo)';
          }

          // on génère un nom unique
          $date = (new \DateTime('now', new \DateTimeZone('Europe/Paris')))->format('Y-m-d-H-i-s');

          $newname = $invoice_title . '_' . $date;

          // la route où le fichier doit se mettre
          $newfilename = ROOT . "/public/assets/upload/invoices/$newname.$extension";

          // erreur si l'envoit du fichier dans le dossier correspond a échoué
          if (!move_uploaded_file($_FILES['invoice_href']['tmp_name'], $newfilename)) {
            $_SESSION['error'] = 'Une erreur s\'est produite. Veuillez recommencer.';
          }

          // 6 = le propriétaire a le droit de lecture et d'écriture
          // 44 = le groupe et le visiteur a le droit de lecture.
          chmod($newfilename, 0644);

          // on réccupère ici l'id de la transaction
          $transactionId = $transaction->getLastInsertId();

          // on set le titre et href des invoices
          $invoice->setTitle($invoice_title);
          $invoice->setHref($newname . '.' . $extension);


          
          if ($id) {
            $oldFile =  ROOT . "/public/assets/upload/invoices/$inv->href";
            
            if (file_exists($oldFile)) {
              unlink($oldFile);
            }
            
            $invoice->update($id);
          }else {
            // on le met dans la colone transaction_id
            $invoice->setTransactionId($transactionId);
          $invoice->insert($invoice); 
        }

          // on réccupère le dernier ID du invoice afin de le transmettre à transaction
          $invoiceId = $invoice->getLastInsertId();

          // on modifie la colone invoice_id
          $transaction->setInvoiceId($invoiceId);
          // on update transaction
          $transaction->update($transactionId);
        }

        header('Location: index?p=transaction/read');
      }
    }


    // Commencer le formulaire
    $form = new Form();
    $category = new Category();
    $categories = $category->findAllbyTitle();

    $form
      ->startForm('post', '', ['class' => 'form', "enctype" => "multipart/form-data"])
      ->addLabel('Titre de la transaction', 'title')
      ->addInput('text', 'title', ['required' => true, "value" => $transac->title ?? ''])
      ->addLabel('Montant', 'amount')
      ->addInput('text', 'amount', ['required' => true, "value" => $transac->amount ?? ''])
      ->addLabel('Lieu de l\'achat', 'location')
      ->addInput('text', 'location', ['required' => true, "value" => $transac->location ?? ''])
      ->addLabel('Catégorie', 'category')
      ->addSelect('category', $categories, $transac->category_id ?? '')
      ->addLabel('Facilité de paiement', 'payment_option')
      ->addInput('number', 'payment_option', ['required' => true, 'min' => 1, 'value' => $transac->payment_option ?? 1])
      ->addLabel('Date', 'created_at')
      ->addInput('date', 'created_at', ['required' => true, 'min' => 1, 'value' => $transac->created_at ?? $currentDate])
      ->addLabel('Transaction Courante', 'is_monthly')
      ->addInput('checkbox', 'is_monthly', isset($transac) && $transac->is_monthly !== 0 ? [
        'checked' => true
      ] : [])

      ->addLabel( $id ? 'Modifier la facture' : 'Télécharger une facture', 'hasInvoice',)
      ->addInput('checkbox', 'hasInvoice', isset($transac) && $transac->invoice_id !== null ? [
        'id' => 'hasInvoice',
        'checked' => true
      ] : [
        'id' => 'hasInvoice',

      ])
      ->addLabel('Titre de la facture', 'invoice_title', ['class' => 'invoices-info'])
      ->addInput('text', 'invoice_title', ['class' => 'invoices-info', 'value' => isset($inv) ? $inv->title  : ''])
      ->addLabel('Fichier', 'invoice_href', ['class' => 'invoices-info'])
      ->addInput('file', 'invoice_href', ['class' => 'invoices-info'])

      ->addSubmit('Valider')
      ->endForm();


    // Afficher le formulaire
    $this->render('transaction/index', [
      'form' => $form->create(),
    ]);
  }


  public function read()
  {
    $transaction = new Transaction();
    // on prépare la jointure
    $columns = 't.*, c.title AS category_title, i.href as invoice_href';
    $joins = [
      ['table' => 'category c', 'condition' => 't.category_id = c.id'],
      ['table' => 'invoice i', 'condition' => 't.invoice_id = i.id']
    ];

    // Afficher le formulaire
    return $this->render('transaction/read', [
      'transactions' => $transaction->findAllWithJoin($columns, $joins)
    ]);
  }


  public function delete(int $id)
  {
    // protection des routes 
    if (!isset($_SESSION['user'])) {
      header('Location: index?p=security/login');
      exit;
    }

    $transactionModel = new Transaction();
    $invoiceModel = new Invoice();

    // Vérifiez si un identifiant est spécifié
    if ($id !== null) {
      $transaction = $transactionModel->find($id);

      if (!$transaction) {
        $_SESSION["error"] = 'Transaction non trouvée';
        header('Location: index?p=transaction/index');
        exit;
      }

      if ($transaction->invoice_id != null) {
        $invoice = $invoiceModel->find($transaction->invoice_id);

        if (!$invoice) {
          $_SESSION["error"] = 'Facture non trouvée';
          header('Location: index?p=transaction/index');
          exit;
        }

        // Delete the invoice associated with the transaction
        $invoiceModel->delete($transaction->invoice_id);

        // Check if the invoice file exists and delete it
        $file = ROOT . "/public/assets/upload/invoices/" . $invoice->href;
        if (file_exists($file)) {
          unlink($file);
        }
      }

      // Delete the transaction
      $transactionModel->delete($id);

      $_SESSION['success'] = 'Vous avez bien supprimer la transaction';
      header('Location: index?p=transaction/index');
      exit;
    }
  }
}
