<?php
  
  namespace App\Models;

  class Transaction extends Model
  {
    protected $id;
    protected $category_id;
    protected $user_id;
    protected $invoice_id;
    protected $title;
    protected $amount;
    protected $location;
    protected $payment_option;
    protected $is_monthly;
    protected $created_at;

    public function __construct() {
      parent::__construct(); // Appeler le constructeur de la classe parente Model
      $this->table = strtolower(str_replace(__NAMESPACE__.'\\', '', __CLASS__));
      $this->created_at = (new \DateTime('now', new \DateTimeZone('Europe/Paris')))->format('d-m-Y'); // Date actuelle au format MySQL datetime avec l'heure de Paris

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
     * Get the value of category_id
     */
    public function getCategoryId() {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     */
    public function setCategoryId($category_id): self {
        $this->category_id = $category_id;
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
     * Get the value of invoice_id
     */
    public function getInvoiceId() {
        return $this->invoice_id;
    }

    /**
     * Set the value of invoice_id
     */
    public function setInvoiceId($invoice_id): self {
        $this->invoice_id = $invoice_id;
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
     * Get the value of location
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * Set the value of location
     */
    public function setLocation($location): self {
        $this->location = $location;
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

    /**
     * Get the value of payment_option
     */
    public function getPaymentOption() {
        return $this->payment_option;
    }

    /**
     * Set the value of payment_option
     */
    public function setPaymentOption($payment_option): self {
        $this->payment_option = $payment_option;
        return $this;
    }

    /**
     * Get the value of is_monthly
     */
    public function getIsMonthly() {
        return $this->is_monthly;
    }

    /**
     * Set the value of is_monthly
     */
    public function setIsMonthly($is_monthly): self {
        $this->is_monthly = $is_monthly;
        return $this;
    }
  }

