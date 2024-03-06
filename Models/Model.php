<?php

namespace App\Models;

use App\Core\Db; // Importer la classe Db depuis le namespace App\DB

class Model extends Db // Déclarer la classe Model qui étend la classe Db
{
  protected $table; // Propriété pour stocker le nom de la table de la base de données. accessible à la fois à l'intérieur de la classe et dans les classes filles qui en héritent
  private $db; // Propriété pour stocker l'instance de la connexion à la base de données. accessible qu'à l'intérieur de la classe 

  public function __construct()
  {
    $this->db = $this->getInstance(); // Initialiser $db avec l'instance de la connexion à la base de données
  }

  // Méthode pour trouver tous les enregistrements dans la table
  public function findAll(): array // Déclarer la méthode publique findAll()
  {
    // Utiliser la méthode sql() pour exécuter la requête SQL et récupérer tous les résultats
    return $this->sql('SELECT * FROM ' . $this->table)->fetchAll();
  }

  // Méthode pour trouver des enregistrements dans la table basés sur des paramètres spécifiés
  public function findBy(array $params): string // Déclarer la méthode publique findBy() avec un paramètre de tableau $params
  {
    $champs = []; // Initialiser un tableau pour stocker les conditions de la requête WHERE
    $values = []; // Initialiser un tableau pour stocker les valeurs liées

    // Parcourir le tableau des paramètres
    foreach ($params as $champ => $value) {
      // Construire les conditions de la requête WHERE
      $champs[] = "$champ = ?"; // Ajouter le champ et le symbole d'égalité à la liste des champs
      $values[] = $value; // Ajouter la valeur à la liste des valeurs
    }

    // Transformer le tableau des champs en une chaîne de caractères séparée par 'AND'
    $liste_champs = implode(' AND ', $champs);

    // Utiliser la méthode sql() pour exécuter la requête SQL avec les conditions WHERE
    return $this->sql('SELECT * FROM ' . $this->table . ' WHERE ' . $liste_champs, $values)->fetchAll();
  }

  public function find(int $id): array
  {
    return $this->sql("SELECT * FROM {$this->table} WHERE id = $id")->fetch();
  }

  public function insert(): object // Déclarer la méthode publique findBy() avec un paramètre de tableau $params
  {
    $champs = []; 
    $inter = [];
    $values = [];

    foreach ($this as $champ => $value) {
      // INSERT INTO 

      if ($value !== null && $champ != 'db' && $champ != 'table') {
        $champs[] = "$champ";
        $inter[] = "?";
        $values[] = $value; // Ajouter la valeur à la liste des valeurs
      }
    }

    // Transformer le tableau des champs en une chaîne de caractères séparée par 'AND'
    $liste_champs = implode(', ', $champs);
    $liste_inter = implode(', ', $inter);

    // Utiliser la méthode sql() pour exécuter la requête SQL avec les conditions WHERE
    return $this->sql('INSERT INTO '. $this->table . ' (' . $liste_champs .') VALUES(' . $liste_inter.')', $values);
  }


  public function update(int $id): object
{
    $champs = []; 
    $values = [];

    foreach ($this as $champ => $value) {
        // Update 

        if ($value !== null && $champ !== 'db' && $champ !== 'table') {
            $champs[] = "$champ = ?";
            $values[] = $value; // Ajouter la valeur à la liste des valeurs
        }
    }

    // Ajouter l'ID à la liste des valeurs (pour la clause WHERE)
    $values[] = $id;

    // Transformer le tableau des champs en une chaîne de caractères séparée par des virgules
    $liste_champs = implode(', ', $champs);

    // Utiliser la méthode sql() pour exécuter la requête SQL avec les conditions WHERE
    return $this->sql('UPDATE '.$this->table.' SET '. $liste_champs.' WHERE id = ?', $values);
}

public function delete(int $id): object
{
  return $this->sql("DELETE FROM {$this->table} WHERE id = ?", [$id]);
}


  // Méthode protégée pour exécuter des requêtes SQL
  protected function sql(string $query, ?array $data = null): object // Déclarer la méthode protégée sql() avec un paramètre pour la requête SQL et un paramètre optionnel pour les données liées
  {
    if ($data !== null) { // Vérifier si des données liées sont fournies
      // Requête préparée avec des valeurs liées
      $stmt = $this->db->prepare($query); // Préparer la requête SQL
      $stmt->execute($data); // Exécuter la requête SQL avec les données liées
      return $stmt; // Retourner le résultat de la requête préparée
    } else {
      // Requête SQL simple
      return $this->db->query($query); // Exécuter la requête SQL et retourner le résultat
    }
  }


  public function setter($data): self
  {
    foreach ($data as $key => $value) {
      // on réccup!re le nom du setter correspondant à la clé (key)
      // titre -> setTitre

      $setter = 'set' . ucfirst($key);

      // on vérifie si le setter existe

      if (method_exists($this, $setter)) {
        // On appelle le setter
        $this->$setter($value);
      }
    }
    return $this;
  }

  public function getter($data): self
  {
    foreach ($data as $key => $value) {
      // on réccup!re le nom du setter correspondant à la clé (key)
      // titre -> getTitre

      $getter = 'get' . ucfirst($key);

      // on vérifie si le setter existe

      if (method_exists($this, $getter)) {
        // On appelle le setter
        $this->$getter($value);
      }
    }
    return $this;
  }
}
