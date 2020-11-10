<?php
namespace App\Table;

use App\Model\Category;
use App\Table\Exception\NotFoundException;
use PDO;

class CategoryTable extends Table
{
     protected $table = "category";
     protected $class = Category::class;

    /**
     * @param App\Model\Post[] $posts
     */
    public function hydratePosts(array $posts): void
    {
        $postsByID = [];
        foreach($posts as $post){
            $postsByID[$post->getID()] = $post;
        }

        //on génére la requete
        $categories = $this->pdo
            ->query('SELECT c.*, pc.post_id
            FROM post_category pc
            JOIN category c ON c.id = pc.category_id
            WHERE pc.post_id IN (' . implode(',', array_keys($postsByID)) . ')'
            )->fetchAll(PDO::FETCH_CLASS, $this->class);

        //on parcourt charque categories
        foreach ($categories as $category){
            //trouver le post correspondant a la ligne
            $postsByID[$category->getPostID()]->addCategory($category);
        }
    }

}