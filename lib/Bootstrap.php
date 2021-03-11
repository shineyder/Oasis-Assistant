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
        //Sets the protected URL
        $this->getURL();

        //Load the default controller if no URL is set
        if (empty($this->url[0])) :
            $this->loadDefaultController();
            return false;
        endif;

        //Load the Controller
        $this->loadExistingController();

        //Call methods
        $this->callControllerMethod();
    }

    /**
     * getURL
     * @param string $url Get a url and work on her
     * @return array $url Processed url pass to this->url
     */

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
        //http://mvctest.com/Controller/Method/Param
        //so...
        //url[0] = Controller
        //url[1] = Method
        //url[2] = Param

        if ($this->controller == null) :
            return false;
        endif;

        if (isset($this->url[1])) :
            if (method_exists($this->controller, $this->url[1])) :
                if (isset($this->url[2])) :
                    $this->controller->{$this->url[1]}($this->url[2]);
                else :
                    $this->controller->{$this->url[1]}();
                endif;
            else :
                $this->error("Esse método não existe<br>");
            endif;
        else :
            $this->controller->index();
        endif;
    }

    /**
     * error
     * @param string $erro Description of an error
     */
    private function error($erro)
    {
        $controller = new Erro();
        $controller->index($erro);
        return false;
    }
}