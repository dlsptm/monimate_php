<?php
  
  namespace App\Models;

  class User extends Model
  {
    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $roles;
    protected $profile;
    protected $active;
    protected $token;
    protected $dark_light_mode;
    protected $created_at;

    public function __construct() {
      parent::__construct(); // Appeler le constructeur de la classe parente Model
      $this->table = strtolower(str_replace(__NAMESPACE__.'\\', '', __CLASS__));
      $this->roles = json_encode(['ROLE_USER']);
      $this->active = 0;
      $this->created_at = (new \DateTime('now', new \DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s'); // Date actuelle au format MySQL datetime avec l'heure de Paris
      $this->profile = 'default-profile.png';
      $this->dark_light_mode = 0;
      }

    /**
     * reccupération d'un user à partir de son mail
     *
     * @param string $email
     * @return void
     */
    public function findOnebyEmail(string $email)
    {   

        return $this->sql("SELECT * FROM $this->table WHERE email = ?", [$email])->fetch();
    }

        public static function emailExists(string $email)
    {
        // Vérifie si l'email existe déjà dans la base de données
        $userModel = new User(); // Supposons que votre modèle d'utilisateur s'appelle User
        $user = $userModel->findOneByEmail($email);

        if($user) {
            return true; // L'email existe déjà dans la base de données
        } 
    
        return false; // L'email n'existe pas dans la base de données
    
    }

    public function findOnebyUsername(string $username)
    {   

        return $this->sql("SELECT * FROM $this->table WHERE username = ?", [$username])->fetch();
    }

    public static function usernameExists(string $username)
    {
        // Vérifie si l'email existe déjà dans la base de données
        $userModel = new User(); // Supposons que votre modèle d'utilisateur s'appelle User
        $user = $userModel->findOnebyUsername($username);
        if($user) {
            return true; // Le nom d'utilisateur existe déjà dans la base de données
        } 
    
        return false; // Le nom d'utilisateur n'existe pas dans la base de données      
    }

    public function findOnebyToken(string $token)
    {   

        return $this->sql("SELECT * FROM $this->table WHERE token = ?", [$token])->fetch();
    }

    public function getMode(int $id)
    {   

        return $this->sql("SELECT dark_light_mode FROM $this->table WHERE id = ?", [$id])->fetch();
    }

    /**
     * Création de la session utilisateur
     *
     * @return void
     */
    public function getSession ()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'profile'=>$this->profile
        ];
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
     * Get the value of username
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set the value of username
     */
    public function setUsername($username): self {
        $this->username = $username;
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



    /**
     * Get the value of dark_light_mode
     */
    public function getDarkLightMode() {
        return $this->dark_light_mode;
    }

    /**
     * Set the value of dark_light_mode
     */
    public function setDarkLightMode($dark_light_mode): self {
        $this->dark_light_mode = $dark_light_mode;
        return $this;
    }
  }

