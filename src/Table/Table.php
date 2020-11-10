<?php
namespace App\Table;

use App\Model\Post;
use App\Table\Exception\NotFoundException;
use PDO;

class Table
{
    //on protège une propriète
    protected $pdo;
    protected  $table = null;
    protected $class = null;

    public function __construct(PDO $pdo)
    {
        if ($this->table === null) {
            throw new \Exception("La classe" . get_class($this) . "n'a pas de propièté \$table");
        }
        if ($this->class === null) {
            throw new \Exception("La classe" . get_class($this) . "n'a pas de propièté \$class");
        }
        $this->pdo = $pdo;
    }

    //on crée une fonction pour récuper toute les post
    public function find(int $id)
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        //on excuse la requete
        $query->execute(['id' => $id]);
        //on recupere les resultats
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false){
            throw  new  NotFoundException($this->table, $id);
        }
        return $result;
    }

}