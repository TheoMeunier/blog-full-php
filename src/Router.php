<?php
namespace App;

use AltoRouter;
use App\Security\ForbiddenExecption;

class Router
{
    //propriète priver
    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var AltoRouter
     */
    private $router;

    //on defini sont contructeur
    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
    }

    public function get(string $url, string $view, string $name = null): self
    {
        $this->router->map('GET', $url, $view, $name);

        // toute les methode renvoye this
        return $this;

    }


    public function post(string $url, string $view, string $name = null): self
    {
        $this->router->map('POST', $url, $view, $name);

        // toute les methode renvoye this
        return $this;

    }

    //fonction qui fais passer les url en post et en get
    public function match(string $url, string $view, string $name = null): self
    {
        $this->router->map('POST|GET', $url, $view, $name);

        // toute les methode renvoye this
        return $this;

    }

    //on crée notre propre fonction de route
    public function url(string $name, array $params = [])
    {
        return $this->router->generate($name, $params);
    }

    //cette fonction de charge de faire la logique qui fais les require
    public function run(): self
    {
        $match = $this->router->match();
        $view = $match['target'] ?: 'e404' ;
        $params = $match['params'];
        $router = $this;
        //on regarde si nous sommes dans l'administration
        $isAdmin = strpos($view, 'admin/') !== false;
        //on definié le layout qu'il faut utiliser
        $layout = $isAdmin ? 'admin/layouts/default' : 'layouts/default';

        try {
            ob_start();
            require $this->viewPath . DIRECTORY_SEPARATOR . $view. '.php';

            //on lit qui que contant est la partie section de la page
            $content = ob_get_clean();
            require $this->viewPath .DIRECTORY_SEPARATOR . $layout . '.php';

        }catch (ForbiddenExecption $e){
            header('Location: ' . $this->url('login') . '?forbidden=1');
            exit();
        }

        return $this;
    }
}