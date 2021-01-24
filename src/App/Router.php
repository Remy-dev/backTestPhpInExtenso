<?php



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
