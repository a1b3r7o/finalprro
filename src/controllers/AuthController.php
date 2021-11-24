<?php

use Firebase\JWT\JWT;

/**
 * Represeta una clase
 */
class AuthController {
    
    /**
     * Inicia el objeto
     */
    function __construct() {
        $this->model = new UsuariosModel();
    }
    
    /**
     * Se utiliza para poder registrar un usuario
     *
     */
    function registrar() {
        $postdata = file_get_contents("php://input");
        $user = json_decode($postdata, true);
        $user["password"] = password_hash($user["password"], PASSWORD_DEFAULT);
        $ok = $this->model->crearUsuario($user);
        if ($ok) {
            $res = [
                "status" => 201,
                "ok" => true,
                "message" => "El usuario se ha creado satisfactoriamente."
            ];
        } else {
            $res = [
                "status" => 500,
                "ok" => true,
                "message" => "El usuario no se ha podido crear."
            ];
        }
        http_response_code($res["status"]);
        echo json_encode($res);
    }
    
    /**
     * Lo usamos para poder registrarse con usuario ya creado
     *
     */
    function login() {
        $postdata = file_get_contents("php://input");
        $auth = json_decode($postdata, true);
        $user = $this->model->getUsuarioByEmail($auth["email"]);
        if (is_null($user)) {
            $res = [
                "status" => 401,
                "ok" => true,
                "message" => "Credenciales incorrectas."
            ];
            http_response_code($res["status"]);
            echo json_encode($res);
            exit();
        }
        $ok = password_verify($auth["password"], $user["password"]);
        if (!$ok) {
            $res = [
                "status" => 401,
                "ok" => true,
                "message" => "Credenciales incorrectas."
            ];
            http_response_code($res["status"]);
            echo json_encode($res);
            exit();
        }
        $time = time();
        $token = array(
            'iat' => $time, // Tiempo que inició el token
            'exp' => $time + Config::AUTH_TIME, // Tiempo que expirará el token
            'data' => [ // información del usuario
                'id' => $user["id_usuario"],
                'username' => $user["nombre"],
                'rol' => $user["rol"]
            ]
        );
        $token = JWT::encode($token, Config::AUTH_KEY, Config::AUTH_ENCRYPT);
        $res = [
            "status" => 200,
            "ok" => true,
            "message" => "Identificación satisfactoria.",
            "token" => $token
            // "data" => $untoken // Solo para comprobar, hay que quitarlo
        ];
        http_response_code($res["status"]);
        echo json_encode($res);
    }
}
