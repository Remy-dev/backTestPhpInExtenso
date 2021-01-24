<?php



class Application {
    protected $httpRequest;


    public function __construct()
    {
        $this->httpRequest = new HTTPRequest();

    }

    public function getController()
    {
        $handle = file_get_contents(__DIR__.'/routes.json');
        $content = json_decode($handle, true);
        $controllerClass = ucfirst($content['controller']);
        $controller = new $controllerClass($this);
        return $controller;
    }


}
