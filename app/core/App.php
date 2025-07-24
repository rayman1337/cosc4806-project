<?php

class App {

    protected $controller = 'home';  
    protected $method = 'index';
    protected $special_url = ['apply'];
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        if (!empty($url) && file_exists('app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            $_SESSION['controller'] = $this->controller;

            if (in_array($this->controller, $this->special_url)) {
                $this->method = 'index';
            }
            unset($url[0]);
        } elseif (!empty($url) && $url[0] === 'login') {
            $this->controller = 'login';
        } else {
            $this->controller = 'home';
        }

        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            $url[1] = explode('?', $url[1])[0]; 
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                $_SESSION['method'] = $this->method;
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = filter_var(trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return array_slice($url, 0); 
        }
        return [];
    }
}
?>