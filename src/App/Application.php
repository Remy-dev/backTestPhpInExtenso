<?php
namespace App\App;

/**
 * Class Application
 * @package App\App
 */
class Application {
    /**
     * @var HTTPRequest
     */
    protected $httpRequest;

    public function __construct()
    {
        $this->httpRequest = new HTTPRequest();

    }

    /**
     * @return mixed
     */
    public function getController()
    {
        $handle = file_get_contents(__DIR__.'/routes.json');
        $content = json_decode($handle, true);
        $controllerClass = ucfirst($content['controller']);
        $controller = new $controllerClass($this);
        return $controller;
    }


}
