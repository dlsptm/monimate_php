<?php
  
  namespace App\Models;

use PDO;

  class Category extends Model
 {
    protected $id;
    protected $title;
    protected $icon;

    public function __construct() {
      parent::__construct(); // Appeler le constructeur de la classe parente Model
      // $this->table = strtolower(str_replace(__NAMESPACE__.'\\', '', __CLASS__));

      $this->table = strtolower(str_replace(__NAMESPACE__.'\\', '', __CLASS__));
    }

    public function findAllbyTitle()
    {   

        return $this->sql("SELECT title FROM $this->table ")->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findOnebyTitle(string $title)
    {   

        return $this->sql("SELECT * FROM $this->table WHERE title = ?", [$title])->fetch();
    }

        public static function titleExists(string $title)
    {
        // Vérifie si l'title existe déjà dans la base de données
        $categoryModel = new Category(); // Supposons que votre modèle d'utilisateur s'appelle category
        $category = $categoryModel->findOnebyTitle($title);

        if($category) {
            return true; // L'title existe déjà dans la base de données
        } 
    
        return false; // L'title n'existe pas dans la base de données
    
    }

    /**
     * Get the value of id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle($title): self {
        $this->title = $title;
        return $this;
    }

    /**
     * Get the value of icon
     */
    public function getIcon() {
        return $this->icon;
    }

    /**
     * Set the value of icon
     */
    public function setIcon($icon): self {
        $this->icon = $icon;
        return $this;
    }
 } 

?>