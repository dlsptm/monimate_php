<?php
  namespace App\Models;

  class Income extends Model
  {
    protected $id;
    protected $user_id;
    protected $title;
    protected $amount;
    protected $created_at;

    public function __construct() {
      parent::__construct(); // Appeler le constructeur de la classe parente Model
      $this->table = strtolower(str_replace(__NAMESPACE__.'\\', '', __CLASS__));
    }

    public function findAllById(int $id, $date=null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE `user_id` = $id";

        if (isset($date) && strlen($date) == 4) {
            $sql.= " AND YEAR(created_at) = $date";
          } else if (isset($date)){
            $sql.= " AND MONTH(created_at) = $date";
          }

          $sql .= " ORDER BY id DESC";
          $sql .= " LIMIT 3"; // Ajout de la limite

      return $this->sql($sql)->fetchAll();
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
     * Get the value of user_id
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     */
    public function setUserId($user_id): self {
        $this->user_id = $user_id;
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
     * Get the value of amount
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * Set the value of amount
     */
    public function setAmount($amount): self {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     */
    public function setCreatedAt($created_at): self {
        $this->created_at = $created_at;
        return $this;
    }
  }