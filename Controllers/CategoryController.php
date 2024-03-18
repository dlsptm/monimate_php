<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\Category;

class CategoryController extends Controller
{
  /**
   * cette méthode affiche une page listant toutes les catégories de la base de données
   *
   * @return void
   */
  public function index(string $id = null)
  {
        // protection des routes 
        if (!isset($_SESSION['user'])) {
          header('Location: index?p=security/login');
          exit;
        }

    $category = new Category;

    // Vérifiez si un identifiant est spécifié
    if ($id !== null) {
      // Récupérez les détails de la catégorie à l'index spécifié
      $cat = $category->find($id);

      // Vérifiez si la catégorie existe
      if (!$cat) {
        $_SESSION["error"] = 'Catégorie non trouvée';
        header('Location: index?p=category/index');
        exit;
      }
    }

    if (isset($_POST) && !empty($_POST)) {
      // vérification si tous les champs sont bien remplis 
      if (!Form::validate($_POST, ['title'])) {
        $_SESSION['error'] = 'Veuillez remplir tous les champs du formulaire.';
      }
      if (!Form::validate($_FILES, ['icon'])) {
        $_SESSION['error'] = 'Veuillez remplir tous les champs du formulaire.';
      }

      if (strlen($_POST['title']) < 3) {
        $_SESSION['error'] = 'Le titre est trop court.';
      }

      // Si aucune erreur n'a été définie, procéder à l'inscription
      if (!isset($_SESSION['error'])) {

        // on réccupère le titre et on le protège
        $title = htmlspecialchars(strip_tags(trim($_POST['title'])));


        // on vérifie l'icon
        $allowed = [
          'jpg' => 'image/jpg',
          'jpeg' => 'image/jpg',
          'png' => 'image/png',
          'webapp' => 'image/webapp'
        ];

        $filename = $_FILES['icon']['name'];
        $filetype = $_FILES['icon']['type'];
        $filesize = $_FILES['icon']['size'];

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        //on vérifie l'absence de l'extension dans les clés $allowed ou l'absence du type MIME dans les valeurs
        if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
          $_SESSION['error'] = 'Le type du fichier n\'est pas autorisé. Nous acception les fichiers png, jpg/jpeg et webapp';
        }

        // Ici le type est correct
        // on vérifie le poids en la limitant à 3Mo
        if ($filesize > (1024 * 1024) * 3) {
          $_SESSION['error'] = 'L\'image est trop volumineux. Elle doit faire moins de 3Mo';
        }

        // on génère un nom unique
        $date = (new \DateTime('now', new \DateTimeZone('Europe/Paris')))->format('Y-m-d-H-i-s');

        $newname = $title . '_' . $date;

        $newfilename = ROOT . "/public/assets/upload/categories_icon/$newname.$extension";

        if (!move_uploaded_file($_FILES['icon']['tmp_name'], $newfilename)) {
          $_SESSION['error'] = 'Une erreur s\'est produite. Veuillez recommencer.';
        }

        // 6 = le propriétaire a le droit de lecture et d'écriture
        // 44 = le groupe et le visiteur a le droit de lecture.
        chmod($newfilename, 0644);

        
        $category->setter($id);

        $category->setTitle($title);
        $category->setIcon($newname . '.' . $extension);

        if ($id) {
          $icon = ROOT . "/public/assets/upload/categories_icon/$cat->icon";

          if (file_exists($icon)) {
            unlink($icon);
          }

          $category->update($id);

          $_SESSION['success'] = 'Vous avez bien modifié une catégorie';
          header('Location: index?p=category/index');
          exit;
        } else {
          // vérification si la catégorie existe déjà
          if (Category::titleExists($_POST['title'])) {
            $_SESSION['error'] = 'Une catégorie avec ce nom existe déjà';
          }

          $category->insert();
          $_SESSION['success'] = 'Vous avez bien ajouté une catégorie';
          header('Location: index?p=category/index');
          exit;
        }
      }
    }

    $form = new Form();

    // Commencer le formulaire
    $form
      ->startForm('post', '#', ['class' => 'form', "enctype" => "multipart/form-data"])
      ->addLabel('Titre de la category', 'title')
      ->addInput('text', 'title', ['required' => true, 'value' => $cat->title ?? ''])
      ->addLabel('Icon', 'icon')
      ->addInput('file', 'icon', ['required' => true, 'value' => $cat->icon ?? ''])
      ->addSubmit('Valider')
      ->endForm();


    // Afficher le formulaire
    $this->render('category/index', [
      'form' => $form->create(),
      'categories' => $category->findAll()
    ]);
  }

  public function delete(string $id)
  {
    // protection des routes 
    if (!isset($_SESSION['user'])) {
      header('Location: index?p=security/login');
      exit;
    }
    $category = new Category();
    // Vérifiez si un identifiant est spécifié
    if ($id !== null) {
      // Récupérez les détails de la catégorie à l'index spécifié
      $cat = $category->find($id);

      // Vérifiez si la catégorie existe
      if (!$cat) {
        $_SESSION["error"] = 'Catégorie non trouvée';
        header('Location: index?p=category/index');
        exit;
      }

      $icon = ROOT . "/public/assets/upload/categories_icon/$cat->icon";

      if (file_exists($icon)) {
        unlink($icon);
      }

      $category->setter($id);
      $category->delete($id);

      $_SESSION['success'] = 'Vous avez bien modifié une catégorie';
      header('Location: index?p=category/index');
      exit;
    }
  }
}
