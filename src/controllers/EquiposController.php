<?php

use Firebase\JWT\JWT;

/**
 * # Class EquiposController
 */
class EquiposController
{
    
    /**
     * Inicia el objeto EquiposController
     */
    function __construct()
    {
        $this->model = new EquiposModel();
    }
    
    /**
     * Creamos el metodo index 
     */
    function index()
    {
        $equipos = $this->model->getEquipos();
        echo json_encode($equipos);
    }
    
    /**
     * getEquipo devuelve un equipo
     *
     * @param   array  $params utilizamos un parametro 
     */
    function getEquipo(array $params)
    {
        $id_equipo = $params["id"];

        $equipo = $this->model->getEquipos($id_equipo);
        if (!is_null($equipo)) {
            $res = [
                "data" => $equipo,
                "status" => 200,
                "ok" => true,
                "message" => "Equipo encontrado."
            ];
        } else {
            $res = [
                "status" => 404,
                "ok" => true,
                "message" => "Equipo no encontrado."
            ];
        }
        http_response_code($res["status"]);
        echo json_encode($res);
    }
    
    /**
     * getDivision devuelve los equipos de una division division
     * 
     * @param   array  $params utilizamos un parametro 
     */
    function getDivision(array $params)
    {
        $division = $params["id"];

        $division = $this->model->getDivision($division);
        if (!is_null($division)) {
            $res = [
                "data" => $division,
                "status" => 200,
                "ok" => true,
                "message" => "division encontrado."
            ];
        } else {
            $res = [
                "status" => 404,
                "ok" => true,
                "message" => "division no encontrado."
            ];
        }
        http_response_code($res["status"]);
        echo json_encode($res);
    }
    
    /**
     * getCiudad devuelve los equipos de una ciudad
     *
     * @param   array  $params utilizamos un parametro 
     * 
     */
    function getCiudad(array $params)
    {
        $ciudad = $params["id"];

        $ciudad = $this->model->getCiudad($ciudad);
        if (!is_null($ciudad)) {
            $res = [
                "data" => $ciudad,
                "status" => 200,
                "ok" => true,
                "message" => "ciudad encontrado."
            ];
        } else {
            $res = [
                "status" => 404,
                "ok" => true,
                "message" => "ciudad no encontrado."
            ];
        }
        http_response_code($res["status"]);
        echo json_encode($res);
    }
    
    /**
     * nuevo crea un nuevo equipo 
     *
     */
    function nuevo()
    {
        AdministradorAcceso::verificar();

        $postequipo = file_get_contents("php://input");
        $equipo = json_decode($postequipo, true);

        $ok = $this->model->createEquipo($equipo);
        if ($ok) {
            $res = [
                "status" => 200,
                "ok" => true,
                "message" => "El equipo se ha creado satisfactoriamente."
            ];
        } else {
            $res = [
                "status" => 500,
                "ok" => true,
                "message" => "El equipo no se ha podido crear."
            ];
        }
        http_response_code($res["status"]);
        echo json_encode($res);
    }
    
    /**
     * update actualiza un equipo ya existente
     *
     * @param   array  $params utilizamos un parametro 
     * 
     */
    function update(array $params)
    {
        AdministradorAcceso::verificar();

        $id_equipo = $params["id"];
        $postequipo = file_get_contents("php://input");
        $equipo = json_decode($postequipo, true);
        $ok = $this->model->updateEquipo($id_equipo, $equipo);
        if ($ok) {
            $res = [
                "status" => 200,
                "ok" => true,
                "message" => "El equipo se ha actualizado satisfactoriamente."
            ];
        } else {
            $res = [
                "status" => 500,
                "ok" => true,
                "message" => "El equipo no se ha podido actualizar."
            ];
        }
        http_response_code($res["status"]);
        echo json_encode($res);
    }

    
    /**
     * delete elimina un equipo 
     *
     * @param   array  $params utilizamos un parametro 
     * 
     */
    function delete(array $params)
    {
        AdministradorAcceso::verificar();

        $id_equipo = $params["id"];
        $ok = $this->model->deleteEquipo($id_equipo);
        if ($ok) {
            $res = [
                "status" => 200,
                "ok" => true,
                "message" => "El equipo se ha eliminado satisfactoriamente."
            ];
        } else {
            $res = [
                "status" => 500,
                "ok" => true,
                "message" => "El equipo no se ha podido eliminar."
            ];
        }
        http_response_code($res["status"]);
        echo json_encode($res);
    }
}

