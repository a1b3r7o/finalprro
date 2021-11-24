<?php

use Firebase\JWT\JWT;

class AdministradorAcceso {

    static function verificar() {
        if (!isset(getallheaders()["Authorization"])) {
            $res = [
                "status" => 403,
                "ok" => false,
                "message" => "No estás autorizado para realizar esta operación."
            ];
            http_response_code($res["status"]);
            echo json_encode($res);
            exit;
        };
        $autho = getallheaders()["Authorization"];
        // var_dump($autho);
        // exit;
        $token = substr($autho, 7);
        //var_dump($token);
        $ok = JWT::decode($token, Config::AUTH_KEY, [Config::AUTH_ENCRYPT]);
        //var_dump($ok);
        if ($ok->data->rol != "administrador") {
            $res = [
                "status" => 403,
                "ok" => false,
                "message" => "No estás autorizado para realizar esta operación."
            ];
            http_response_code($res["status"]);
            echo json_encode($res);
            exit;
        }
    }
}
