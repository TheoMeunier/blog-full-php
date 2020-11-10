<?php

namespace App\Table;

use App\Model\Category;
use App\Model\Post;
use App\PaginetedQuery;
use App\Table\Exception\NotFoundException;
use PDO;

class PostTable extends Table
{

    protected  $table = 'post';
    protected $class = Post::class;

    public function findPaginated()
    {
        //on génére un nouveau paginatedQuery
        $paginatedQuery = new PaginetedQuery(
            "SELECT * FROM post ORDER BY created_at DESC",
            //on lui passe la requete pour compte les pages
            "SELECT COUNT(id) FROM post",
            $this->pdo
        );
        //on recupère les 12 dernière données
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return[$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory(int $categoryID)
    {
        //on défini le constructeur
        $paginatedQuery = new PaginetedQuery(
            "SELECT p.*
            FROM post p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$categoryID}
            ORDER BY created_at DESC ",
            "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$categoryID}",
        );
        $posts= $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return[$posts, $paginatedQuery];
    }

}