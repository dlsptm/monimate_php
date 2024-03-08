<?php
  
  namespace App\Models;

  class Invoice extends Model
  {
    protected $id;
    protected $title;
    protected $href;
    protected $transaction_id;

    public function __construct() {
      parent::__construct(); // Appeler le constructeur de la classe parente Model
      $this->table = strtolower(str_replace(__NAMESPACE__.'\\', '', __CLASS__));
      $this->title = "Facture ".$this->title;
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
     * Get the value of href
     */
    public function getHref() {
        return $this->href;
    }

    /**
     * Set the value of href
     */
    public function setHref($href): self {
        $this->href = $href;
        return $this;
    }

    /**
     * Get the value of transaction_id
     */
    public function getTransactionId() {
        return $this->transaction_id;
    }

    /**
     * Set the value of transaction_id
     */
    public function setTransactionId($transaction_id): self {
        $this->transaction_id = $transaction_id;
        return $this;
    }
  }

