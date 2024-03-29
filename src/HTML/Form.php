<?php
namespace App\HTML;


class Form
{
    private $data;
    private $errors;

    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string $label)
    {
        //on utilise la methode getValue et on lui passe la clé
        $value = $this->getValue($key);
        //on sauvegarde le type
        $type = $key === "password" ? "password" : 'text';

        return <<<HTML
        <div class="form-group">
                <label for="field{$key}">{$label}</label>
                <input type="{$type}" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" value="{$value}" required>
                {$this->getErrorFeedback($key)}
                 
        </div>
HTML;
    }

    public function textarea(string $key, string  $label): string
    {
        //on utilise la methode getValue et on lui passe la clé
        $value = $this->getValue($key);

        return <<<HTML
        <div class="form-group">
                <label for="field{$key}">{$label}</label>
                <textarea type="text" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" required>{$value}</textarea>
                {$this->getErrorFeedback($key)}
                 
        </div>
HTML;
    }

    public function select(string $key, string $label, array $options = []): string
    {
        $optionsHTML = [];
        //on recupere la valeur
        $value = $this->getValue($key);
        foreach ($options as $k => $v){
            $selected = in_array($k, $value) ? " selected" : "";
            $optionsHTML[] = "<option  value=\"$k\"$selected>$v</option>";
        }
        //on crée un tableau qui permet de liste les catégory
        $optionsHTML = implode('', $optionsHTML);

        return <<<HTML
        <div class="form-group">
                <label for="field{$key}">{$label}</label>
                <select id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}[]" required multiple>{$optionsHTML}</select>
                {$this->getErrorFeedback($key)}
                 
        </div>
HTML;
    }

    //on verifier si data est un tableau
    private function getValue(string $key)
    {
        if (is_array($this->data)){
            //on verifie que la donnée existe et on la retune
            return $this->data[$key] ?? null;
        }

        //on génére la methode et on remplace les espace par du vide
        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

        //on recuper nos donnée dans une variable
        $value = $this->data->$method();
        if ($value instanceof  \DateTimeInterface){
            //on lui dit quel format de date on veux avoir
            return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    //on crée un fonction pour ne pas ce repeter mais appeler la fonction
    private function getInputClass(string $key): string
    {
        //on crée une variable pour la classe from-control
        $inputClass = 'form-control';
        //est-ce que nous avons une erreur pour la clé donner
        if(isset($this->errors[$key])){
            $inputClass .= ' is-invalid';
        }
        return $inputClass;
    }

    //on crée un fonction pour ne pas ce repeter mais appeler la fonction
    private function getErrorFeedback(string $key): string
    {
        //on crée une variable pour nos erreur qui est par defaut vide
        $invalidFeedBack = '';
        //est-ce que nous avons une erreur pour la clé donner
        if(isset($this->errors[$key])){
            if (is_array($this->errors[$key])){
                //si y a un tableau alors fais comme ça
                $error = implode('<br>', $this->errors[$key]);
            }else{
                //alors on met l'erreur normalement
                $error = $this->errors[$key];
            }
            return '<div class="invalid-feedback">' . $error . '</div>';
        }
        return '';
    }
}