<?php
  
  namespace App\Models;

  class Goal extends Model
  {
    protected $id;
    protected $user_id;
    protected $title;
    protected $amount;
    protected $deadline;
    protected $created_at;

    public function __construct() {
      parent::__construct(); // Appeler le constructeur de la classe parente Model
      $this->table = strtolower(str_replace(__NAMESPACE__.'\\', '', __CLASS__));
    }


  }

