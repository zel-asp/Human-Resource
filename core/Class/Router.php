<?php

namespace Core;
class Router
{
    public $route = [];

    private function add($uri, $controller, $method)
    {
        $this->route[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function get($uri, $controller)
    {
        $this->add($uri, $controller, 'GET');
    }

    public function post($uri, $controller)
    {
        $this->add($uri, $controller, 'POST');
    }

    public function delete($uri, $controller)
    {
        $this->add($uri, $controller, 'DELETE');
    }

    public function put($uri, $controller)
    {
        $this->add($uri, $controller, 'PUT');
    }

    public function patch($uri, $controller)
    {
        $this->add($uri, $controller, 'PATCH');
    }

    public function routes($uri, $method)
    {
        foreach ($this->route as $routes) {
            if ($uri === $routes['uri'] && strtoupper($method) === $routes['method']) {
                return require base_path($routes['controller']);
            }
        }

        $this->status(404);
    }

    private function status($code = 404)
    {
        http_response_code($code);
        require base_path("view/status/{$code}.php");
        die();
    }
}