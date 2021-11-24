<?php

class Autoload {

    public static function init() {
        spl_autoload_register(function ($name_space) {
            $array = explode("\\", $name_space);
            $len = count($array);
            $class_name = $array[$len - 1];

            $controller = './controllers/' . $class_name . '.php';
            $libs = './libs/' . $class_name . '.php';
            $models = './models/' . $class_name . '.php';
            $router = './router/' . $class_name . '.php';
            $jwt = './jwt/' . $class_name . '.php';
            $existe = false;

            if (file_exists($controller)) {
                require_once $controller;
                $existe = true;
            }
            if (file_exists($libs)) {
                require_once $libs;
                $existe = true;
            }
            if (file_exists($models)) {
                require_once $models;
                $existe = true;
            }
            if (file_exists($router)) {
                require_once $router;
                $existe = true;
            }
            if ($len == 3) {
                if ($array[0] == "Firebase" && $array[1] == "JWT") {
                    require_once $jwt;
                    $existe = true;
                } else {
                    $existe = false;
                }
            }

            if (!$existe) {
                throw new Exception("Error 404. Página no encontrada. $nombre_clase");
            }
        });
    }
}
