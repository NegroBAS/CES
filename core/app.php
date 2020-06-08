<?php

require_once 'controllers/not_found.controller.php';
class App
{
    function __construct()
    {
        date_default_timezone_set("America/Bogota");
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        if (empty($url[0])) {
            $fileController = 'controllers/signin.controller.php';
            require_once $fileController;
            $controller = new SigninController();
            $controller->render();
            return false;
        }
        $fileController = 'controllers/' . $url[0] . '.controller.php';
        if (file_exists($fileController)) {
            require_once $fileController;
            $name_controller = $url[0] . "Controller";
            $controller = new $name_controller;
            $nparam = sizeof($url);

            if ($nparam > 1) {
                if ($nparam > 2) {
                    $param = [];
                    for ($i = 2; $i < $nparam; $i++) {
                        array_push($param, $url[$i]);
                    }
                    $controller->{$url[1]}($param);
                } else {
                    $controller->{$url[1]}();
                }
            } else {
                $controller->render();
            }
        } else {
            $controller = new Not_foundController();
            $controller->render();
        }
    }
}
