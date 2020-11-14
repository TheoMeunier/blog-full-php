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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
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


    //on definie que c'est un datetime
    public function setCreatedAt(string $date): self
    {
        $this->created_at = $date;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    //on lui difinie qui aura un entier ou il sera null
    public function getID(): ?int
    {
        return $this->id;
    }

    //on lui difinie qui aura un entier ou il sera null
    public function setID(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCategoriesIds(): array
    {
        $ids = [];
        // je parcour l'ensemble de mes catégories
        foreach ($this->categories as $category){
            $ids[] = $category->getID();
        }
        // je return mon tableau id
        return $ids;
    }

    /**
     * @return Category[]
     */
    public function getCategories (): array
    {
        return $this->categories;
    }


    /**
     * @return Category[]
     */
    public function setCategories (array $categories): self
    {
       $this->categories = $categories;

       return $this;
    }

    //ajouter les category au post
    public function addCategory (Category $category): void
    {
        $this->categories[] = $category;
        //on sauvegard l'article associer
        $category->setPost($this);
    }
}