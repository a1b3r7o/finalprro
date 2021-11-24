<?php
class MySqlDBException extends Exception {
}

class MySqlDB {
    const DNS = "mysql:host=localhost;dbname=furbo;port=3306;charset=UTF8";
    const USUARIO = 'root';
    const PASS = '';

    function __construct() {
        try {
            $conexion = new PDO(self::DNS, self::USUARIO, self::PASS);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db = $conexion;
        } catch (PDOException $e) {
            throw new MySqlDBException($e->getMessage());
        }
    }

    function __destruct() {
        $this->db = null;
    }

    function execute(string $sql, array $params = []) {
        $ok = false;
        try {
            $pre = $this->db->prepare($sql);
            $ok = $pre->execute($params);
        } catch (PDOException $e) {
            switch ($e->getCode()) {
                case 23000:
                    switch ($e->errorInfo[1]) {
                        case 1451:
                            throw new MySqlDBException('No se puede eliminar porque esta relacionada con otro dato.');
                            break;
                        case 1062:
                            throw new MySqlDBException('El usuario o el email ya existe.');
                            break;
                        default:
                            throw new MySqlDBException($e->getMessage());
                    }
                default:
                    throw new MySqlDBException($e->getMessage());
            }
        } catch (Exception $e) {
            throw new MySqlDBException($e->getMessage());
        }
        return $ok;
    }

    function prepare(string $sql) {
        return $this->db->prepare($sql);
    }

    function lastInsertId() {
        return $this->db->lastInsertId();
    }

    function query(string $sql, array $params = []) {
        $ok = false;
        try {
            $pre = $this->db->prepare($sql);
            $ok = $pre->execute($params);
            return $pre->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new MySqlDBException($e->getMessage());
        } catch (Exception $e) {
            throw new MySqlDBException($e->getMessage());
        }
        return $ok;
    }
}
