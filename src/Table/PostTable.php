<?php

namespace App\Table;

use App\Model\Category;
use App\Model\Post;
use App\PaginetedQuery;
use App\Table\Exception\NotFoundException;
use PDO;

class PostTable extends Table
{

    protected $table = 'post';
    protected $class = Post::class;

    //on change les donnée de l'aticle
    public function updatePost(Post $post): void
    {
        $this->update([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ], $post->getID());
    }

    //on crée un article
    public function createPost(Post $post): void
    {
        $id = $this->create([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        //on recupére l'id du post qu'on viens de créev
        $post->setID($id);
    }

    public function attachCategories(int $id, array $categories)
    {
        $this->pdo->exec('DELETE FROM post_category WHERE post_Id = ' .$id);
        //je parcourd l'ensemble des mes catégories que je souhaite
        $query = $this->pdo->prepare('INSERT INTO post_category SET post_id = ?, category_id = ? ');
        foreach ($categories as $category) {
            $query->execute([$id, $category]);
        }
    }

    public function findPaginated()
    {
        //on génére un nouveau paginatedQuery
        $paginatedQuery = new PaginetedQuery(
            "SELECT * FROM {$this->table} ORDER BY created_at DESC",
            //on lui passe la requete pour compte les pages
            "SELECT COUNT(id) FROM post",
            $this->pdo
        );
        //on recupère les 12 dernière données
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory(int $categoryID)
    {
        //on défini le constructeur
        $paginatedQuery = new PaginetedQuery(
            "SELECT p.*
            FROM {$this->table} p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$categoryID}
            ORDER BY created_at DESC ",
            "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$categoryID}",
        );
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

}