<?php

namespace App\Table;

use App\Model\User;
use App\Table\Exception\NotFoundException;
use PDO;

class UserTable extends Table
{

    protected $table = 'users';
    protected $class = User::class;

    public function findByUsername(string $username)
    {

        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE username = :username');
        //on excuse la requete
        $query->execute(['username' => $username]);
        //on recupere les resultats
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw  new  NotFoundException($this->table, $username);
        }
        return $result;
    }


}