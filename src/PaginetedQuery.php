<?php

namespace App;


use App\Model\Post;
use Exception;
use PDO;

class PaginetedQuery
{

    private $query;
    private $queryCount;
    private $classMapping;
    private $pdo;
    private $perPage;
    private $ĉount;


    public function __construct(
        string $query,
        string $queryCount,
        string $classMapping,
        ?\PDO $pdo = null,
        $perPage = 12
    )
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->classMapping = $classMapping;
        $this->pdo = $pdo ?: Conection::getPDO();
        $this->perPage = $perPage;
    }

    //on crée la premiere methode
    public function getItems(): array
    {
        //je recupère la page courrante
        $currentPage = $this->getCurrentPage();

        $pages = $this->getpages();

        // si la page la page courrente > au nombre de page alors on returne une exeption
        if ($currentPage > $pages) {
            throw new Exception('Cette page n\'existe pas');
        }
        //on calcule l'offset
        $offset = $this->perPage * ($currentPage - 1);

        //on fait la requete sql pour afficher 12 post; je vais faire une liaison
        return $this->pdo->query(
            $this->query .
            " LIMIT {$this->perPage} OFFSET $offset")
            //on recupère l'ensemble des article
            ->fetchAll(PDO::FETCH_CLASS, $this->classMapping);

    }

    //on gènère les liens presendent
    public function previousLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();

        if ($currentPage <= 1) return null;


        //si currente page supérieur 2 tu lui met la page currente -1
        if ($currentPage > 2) $link .= "?page" . ($currentPage - 1);
        var_dump($link);

        //on utilise de la syntax RRdoc
        return <<<HTML
            <a href="{$link}" class="btn btn-primary"> &laquo; Page précédente</a>
HTML;
    }

    //on gènère les liens suivant
    public function nextLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();

        if ($currentPage >= $pages) return null;
        $link .= "?page=" . ($currentPage + 1);
        //on utilise de la syntax RRdoc
        return <<<HTML
            <a href="{$link}" class="btn btn-primary ml-auto"> Page suivante  &raquo;</a>
HTML;
    }

    //on vérifie si la page currente est suppèrieur a 1
    private function getCurrentPage(): int
    {
        return Url::getPosstiveInt('page', 1);
    }

    //on méthode pour calculer le nombre de page
    private function getPages(): int
    {

        //si count est défini alors tu px continu avec
        if ($this->count === null) {

            //on fait une requete pour compter le nombre d'acticle qu'on a
            //et on lui demande recupere les info sous forme de tableau nurmérique
            $this->count = (int)$this->pdo
                ->query($this->queryCount)
                ->fetch(PDO::FETCH_NUM)[0];
        }
            // on divise article par page et je recupere le nombre de page
            return ceil($this->count / $this->perPage);
    }
}