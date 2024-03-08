<?php

namespace App\Core;

use App\Models\User;

class Form
{
  public $formCode;

  /**
   * génère le formulaire HTML
   *
   * @return string
   */
  public function create(): string
  {
    return $this->formCode;
  }

  /**
   * Valide si tous les champs sont remplis
   *
   * @param array $form Tableau issue du formulaire ($_POST / $_GET)
   * @param array $fields Tableau listant les champs
   * @return bool
   */
  public static function validate(array $form, array $fields)
  {
      foreach ($fields as $field) {
          // Vérifie si le champ est présent dans le formulaire
          if (!isset($form[$field]) || empty($form[$field])) {
              return false; // Champ manquant
          }
      }
  
      return true; // Toutes les validations passées
  }
  

  /**
   * Ajout les attributs envoyé à la balise
   *
   * @param array $attributes tableau associatif
   * @return string chaine de caractères générés
   */
  private function addAttributes(array $attributes): string
  {
    // On initialise une chaine de caractères
    $str = '';

    //on liste les attributs 'courts'
    $shorts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

    // on boucle sur le tableau

    foreach ($attributes as $attribute => $value) {
      // si c'est un attribut court + la valeur est true
      if (in_array($attribute, $shorts) && $value == true) {
        $str .= " $attribute";
      } else {
        // on ajoute attribut = value
        $str .= " $attribute='$value'";
      }
    }

    return $str;
  }

  /**
   * fait la balise d'ouverture du formulaire (post ou get)
   *
   * @param string $method
   * @param string $action
   * @param array $attributes
   * @return self
   */
  public function startForm(string $method = "post", string $action = "#", array $attributes = []): self
  {
    // Créer la balise form
    $this->formCode = "<form action='$action' method='$method'";

    // Ajouter les attributs
    $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';

    // Fermer la balise form
    $this->formCode .= '>';

    return $this;
  }


  /**
   * balise de fermeture du formulaire
   *
   * @return self
   */
  public function endForm(): self
  {
    $this->formCode .= '</form>';
    return $this;
  }

  /**
   * Ajour d'un labal
   *
   * @param string $text
   * @param string|null $for
   * @param array $attributes
   * @return self
   */
  public function addLabel(string $text, string $for, array $attributes = []): self
  {

    // on ouvre la balise 
    $this->formCode .= "<label for='$for'";

    //on ajoute les attributs
    $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';

    // on ajoute le texte
    $this->formCode .= ">$text</label>";

    return $this;
  }

  public function addInput(string $type, string $name, array $attributes = []): self
  {
    // on ouvre la balise
    $this->formCode .= "<input type='$type' name='$name'";

    // on ajoute les attributs
    $this->formCode .= $attributes ? $this->addAttributes($attributes) . '>' : '>';

    return $this;
  }

  public function addTextarea(string $text, string $name, array $attributes = []): self
  {
    // on ouvre la balise 
    $this->formCode .= "<textarea name='$name'";

    //on ajoute les attributs
    $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';

    // on ajoute le texte
    $this->formCode .= ">$text</textarea>";
    return $this;
  }

  public function addSelect(string $name, array $options, string $selectedValue, array $attributes = []): self
  {
      $this->formCode .= "<select name='$name'";
      $this->formCode .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
  
      $value = 1; // Commencez à partir de 1
      foreach ($options as $text) {
          $selected = $value == $selectedValue ? 'selected' : ''; // Vérifiez si cette option est sélectionnée
          $this->formCode .= "<option value='$value' $selected>$text</option>";
          $value++; // Incrémentez la valeur
      }
      $this->formCode .= "</select>";
  
      return $this;
  }
  
  

  public function addSubmit(string $text, array $attributes = []): self
  {
    $this->formCode .= "<button ";

    $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';

    $this->formCode .= ">$text</button ";

    return $this;
  }
}
