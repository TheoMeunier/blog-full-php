<?php
namespace App;

use AltoRouter;

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

    //cette fonction de charge de faire la logique qui fais les require
    public function run(): self
    {
        $match = $this->router->match();
        $view = $match['target'];
        ob_start();

        require $this->viewPath . DIRECTORY_SEPARATOR . $view. '.php';

        //on lit qui que contant est la partie section de la page
        $content = ob_get_clean();
        require $this->viewPath .DIRECTORY_SEPARATOR . 'layouts/default.php';

        return $this;
    }
}