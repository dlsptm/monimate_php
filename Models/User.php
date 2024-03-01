<?php
  
  namespace App\Models;

  class User extends Model
  {
    protected $id;
    protected $email;
    protected $password;
    protected $roles;
    protected $active;
    protected $token;
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
     * Get the value of email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self {
        $this->password = $password;
        return $this;
    }

    /**
     * Get the value of roles
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * Set the value of roles
     */
    public function setRoles($roles): self {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Get the value of active
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set the value of active
     */
    public function setActive($active): self {
        $this->active = $active;
        return $this;
    }

    /**
     * Get the value of token
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Set the value of token
     */
    public function setToken($token): self {
        $this->token = $token;
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

