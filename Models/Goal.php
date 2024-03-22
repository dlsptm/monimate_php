<?php
  namespace App\Models;

  class Goal extends Model
  {
    protected $id;
    protected $user_id;
    protected $title;
    protected $amount;
    protected $deadline;

    public function __construct() {
      parent::__construct(); // Appeler le constructeur de la classe parente Model
      $this->table = strtolower(str_replace(__NAMESPACE__.'\\', '', __CLASS__));
      $this->deadline = (new \DateTime('now', new \DateTimeZone('Europe/Paris')))->format('Y-m-d');
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
     * Get the value of deadline
     */
    public function getDeadline() {
        return $this->deadline;
    }

    /**
     * Set the value of deadline
     */
    public function setDeadline($deadline): self {
        $this->deadline = $deadline;
        return $this;
    }
  }