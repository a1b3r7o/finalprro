<?php

/**
 * Permite crear usuarios 
 */
class UsuariosModel {
    
    /**
     * inicia el objeto usuario model
     *
     */
    function __construct() {
        $this->cnx = new MySqlDB();
    }
    
    /**
     * crea un usuario nuevo
     *
     * @param  array $user pararametro user
     * 
     * @return bool
     */
    function crearUsuario($user) {
        $sql = "INSERT INTO usuarios 
            (nombre, email, password) 
            VALUES (?,?,?)";
        $params = [
            $user["nombre"],
            $user["email"],
            $user["password"]
        ];
        $ok = $this->cnx->execute($sql, $params);
        return $ok;
    }
    
    /**
     *  recoge a los usuarios mediante su email
     *
     * @param   string   $email  correo del usuario
     * 
     * @return  null | array
     */
    function getUsuarioByEmail(string $email) {
        $sql = "SELECT * FROM usuarios WHERE email=?";
        $user = $this->cnx->query($sql, [$email]);
        return empty($user) ? null : $user[0];
    }
}
