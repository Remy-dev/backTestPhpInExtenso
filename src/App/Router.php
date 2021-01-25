<?php

namespace App\App;

/**
 * Class Router
 * @package App\App
 */
class Router
{
    protected $routes = [];

    public function addRoute($route)
    {
        if (!in_array($route, $this->routes))
        {
            $this->routes[] = $route;
        }
    }

    public function getRoute($url)
    {
       return $this->routes;
    }
}
