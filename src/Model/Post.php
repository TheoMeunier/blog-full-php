<?php
namespace App\Model;

use App\Helpers\Text;
use DateTime;

class Post
{
    private $id;
    private $slug;
    private $name;
    private $content;
    private $created_at;
    private $categories = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getFormattedContent (): ?string
    {
        return nl2br(e($this->content));
    }

    public function getExcerpt() : ?string
    {
        if ($this->content === null){
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, 60)));
    }

    //on definie que c'est un datetime
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    //on lui difinie qui aura un entier ou il sera null
    public function getID(): ?int
    {
        return $this->id;
    }

    /**
     * @return Category[]
     */
    public function getCategories (): array
    {
        return $this->categories;
    }

    //ajouter les category au post
    public function addCategory (Category $category): void
    {
        $this->categories[] = $category;
        //on sauvegard l'article associer
        $category->setPost($this);
    }
}