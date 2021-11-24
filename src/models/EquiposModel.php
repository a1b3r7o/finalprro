<?php


/**
 * Representa la clase Equipos model 
 */
class EquiposModel
{
    
    /**
     *Inicia el objeto Equipos model
     */
    function __construct()
    {
        $this->cnx = new MysqlDB();
    }    
    /**
     * recogemos los equipos de la tabla equipos
     * 
     * @return var
     */
    function getEquipos()
    {
        $sql = "SELECT * FROM equipos";
        $equipos = $this->cnx->query($sql);
        return $equipos;
    }
    
    /**
     * recogemos un equipo mediante el id proporcionado
     *
     * @param  mixed $id_equipo utilizamos el parametro <u>id_equipo</u>
     * 
     * @return null/array
     */
    function getEquipo($id_equipo)
    {
        $sql = "SELECT * FROM equipos WHERE id_equipo=?";
        $equipos = $this->cnx->query($sql, [$id_equipo]);
        return empty($equipos) ? null : $equipos[0];
    }
    
    /**
     * recoge los equipos mediante la division dada
     *
     * @param  mixed $division utilizamos el parametro <u>division</u>
     */
    function getDivision($division)
    {
        $sql = "SELECT * FROM equipos WHERE division=?";
        $equipos = $this->cnx->query($sql, [$division]);
        return empty($equipos) ? null : $equipos;
    }
    
    /**
     * getCiudad recoge los equipos mediante la ciudad dada
     *
     * @param  mixed $ciudad utilizamos el parametro <u>ciudad</u>
     * 
     * @return null/array
     */
    function getCiudad($ciudad)
    {
        $sql = "SELECT * FROM equipos WHERE ciudad=?";
        $equipos = $this->cnx->query($sql, [$ciudad]);
        return empty($equipos) ? null : $equipos;
    }
      
    /**
     * se utiliza para crear un equipo 
     *
     * @param  mixed $equipos utilizamos el parametro <u>equipos</u>
     * 
     * @return bol
     */
    function createEquipo(array $equipos)
    {
        $sql = "INSERT INTO equipos (nombre_equipo, ciudad, 
        numero_jugadores, nombre_estadio, division) VALUES (?,?,?,?,?)";
        $params = [
            $equipos["nombre_equipo"],
            $equipos["ciudad"],
            $equipos["numero_jugadores"],
            $equipos["nombre_estadio"],
            $equipos["division"]
        ];
        $ok = $this->cnx->execute($sql, $params);
        return $ok;
    }
    
    /**
     * recoge los datos de la tabla equipos para actualizar un dato de la tabla
     *
     * @param  mixed $id_equipo utilizamos el parametro <u>id_equipo</u>
     * @param  array $equipo utilizamos el parametro <u>equipo</u>
     * 
     * @return bol
     */
    function updateEquipo($id_equipo, array $equipo)
    {
        $sql = "UPDATE equipos 
                        SET nombre_equipo = ?, ciudad = ?, 
                        numero_jugadores = ?, nombre_estadio = ?, division = ?  
                        WHERE id_equipo = ?";
        $params = [
            $equipo["nombre_equipo"],
            $equipo["ciudad"],
            $equipo["numero_jugadores"],
            $equipo["nombre_estadio"],
            $equipo["division"],
            $id_equipo
        ];
        $ok = $this->cnx->execute($sql, $params);
        return $ok;
    }
        
        /**
         * Elimina los datos de la tabla equipos mediante un id proporcionado
         *
         * @param  mixed $id_equipo utilizamos el parametro <u>id_equipo</u>
         * 
         * @return bol
         */
        function deleteEquipo($id_equipo) {
        $sql = "DELETE FROM equipos WHERE id_equipo=?";
        $ok = $this->cnx->execute($sql, [$id_equipo]);
        return $ok;
    }
}











































