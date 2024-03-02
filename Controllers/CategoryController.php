<?php
  namespace App\Controllers;

use App\Models\Category;

  class CategoryController extends Controller
  {
    /**
     * cette méthode affiche une page listant toutes les catégories de la base de données
     *
     * @return void
     */
    public function index (int $id = null)
    { 
      // on instancie le modèle correspondant à la table 'category'
      $categoryModel = new Category();

      //on va chercher toutes les catégories
      if ($id) {
      $category = $categoryModel->find($id);
    } else {
      $categories = $categoryModel->findAll();
    }

     
      $this->render('category/index', compact('categories'));

    }

    /**
     * Update article
     *
     * @param integer $id
     * @return void
     */
    public function update(int $id)
    {

      $categoryModel = new Category();

      //on va chercher toutes les catégories
      $category = $categoryModel->find($id);
      $this->render('category/index', compact('category'));
    }

    public function delete (int $id)
    {

    }

  }

?>