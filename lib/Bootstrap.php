<?php

namespace lib;

use Controllers\Erro;
use Controllers\Index;

class Bootstrap
{
    protected $url = null;
    protected $controller = null;

    public function init()
    {
        //Inicializa $url
        $this->getURL();

        if (empty($this->url[0])) :
            $this->loadDefaultController();
            return false;
        endif;

        $this->loadExistingController();
        $this->callControllerMethod();
    }

    private function getURL()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->url = explode('/', $url);
    }

    private function loadDefaultController()
    {
        $controller = new Index();
        $controller->index();
    }

    private function loadExistingController()
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . '/MVC/Controllers/' . $this->url[0] . '.php';
        if (!file_exists($file)) :
            $this->error("Essa página não existe<br>");
            return false;
        endif;

        $urlController = "\Controllers\\" . $this->url[0];
        $this->controller = new $urlController();
        $this->controller->loadModel($this->url[0]);
    }

    private function callControllerMethod()
    {
        //http://mvctest.com/Controller/Method/Param/Param2
        //url[0] = Controller
        //url[1] = Method
        //url[2] = Param
        //url[3] = Param 2

        if ($this->controller == null) :
            return false;
        endif;

        if (!isset($this->url[1])) :
            $this->controller->index();
            return false;
        endif;

        if (!method_exists($this->controller, $this->url[1])) :
            $this->error("Esse método não existe<br>");
            return false;
        endif;

        if (isset($this->url[3])) :
            $this->controller->{$this->url[1]}($this->url[2], $this->url[3]);
            return false;
        endif;

        if (isset($this->url[2])) :
            $this->controller->{$this->url[1]}($this->url[2]);
            return false;
        endif;

        if (isset($this->url[1])) :
            $this->controller->{$this->url[1]}();
            return false;
        endif;
    }

    private function error($erro)
    {
        $controller = new Erro();
        $controller->index($erro);
        return false;
    }
}
