<?php
class App
{
    protected $controller = 'LoginController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        // Tentukan controller
        if (isset($url[0]) && file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Tentukan method
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Tangkap parameter (misal: ID)
        $this->params = array_values($url ?? []);

        // Jalankan controller + method + parameter
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
