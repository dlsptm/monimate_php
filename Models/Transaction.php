<?php
  
  namespace App\Models;

  class Transaction extends Model
  {
    protected $id;
    protected $category_id;
    protected $type_id;
    protected $option_id;
    protected $user_id;
    protected $invoice_id;
    protected $title;
    protected $amount;
    protected $location;
    protected $created_at;

    public function __construct() {
      parent::__construct(); // Appeler le constructeur de la classe parente Model
      $this->table = strtolower(str_replace(__NAMESPACE__.'\\', '', __CLASS__));
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
     * Get the value of type_id
     */
    public function getTypeId() {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     */
    public function setTypeId($type_id): self {
        $this->type_id = $type_id;
        return $this;
    }

    /**
     * Get the value of option_id
     */
    public function getOptionId() {
        return $this->option_id;
    }

    /**
     * Set the value of option_id
     */
    public function setOptionId($option_id): self {
        $this->option_id = $option_id;
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
  }

