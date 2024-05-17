<?php
//MODELO 
require_once(__DIR__."/sistema.class.php");
class Equipo extends Sistema{
    function getAll(){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT e.id_equipo, e.equipo, s.servicio, es.estado 
        FROM equipo e JOIN servicio s ON e.id_servicio = s.id_servicio
                      JOIN estado es ON e.id_estado = es.id_estado;");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }

    function getOne($id_equipo){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_equipo, nombre, primer_apellido, segundo_apellido, curp, rfc FROM equipo WHERE id_equipo=:id_equipo;");
        $stmt->bindParam(':id_equipo', $id_equipo, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = array();
        $datos = $stmt->fetchAll();
        if (isset($datos[0])) {
            $this->setCount(count($datos));
            return $datos[0];
        }
        return array();
    }
    function insert($datos){
        $this->connect();
        if ($this->validate_equipo($datos)) {       
            $stmt=$this->conn->prepare("INSERT INTO equipo (nombre, primer_apellido, segundo_apellido, curp, rfc) VALUES (:nombre, :primer_apellido, :segundo_apellido, :curp, :rfc);");
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':curp', $datos['curp'], PDO::PARAM_STR);
            $stmt->bindParam(':rfc', $datos['rfc'], PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
        }
        return 0;

    }

    function delete($id_equipo){
        $this->connect();
        $stmt = $this->conn->prepare("DELETE FROM equipo WHERE id_equipo=:id_equipo;");
        $stmt->bindParam(':id_equipo', $id_equipo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    function update($id_equipo, $datos){//datos es un array
        $this->connect();
        $stmt=$this->conn->prepare("UPDATE equipo SET nombre=:nombre, 
        primer_apellido=:primer_apellido, 
        segundo_apellido=:segundo_apellido, 
        rfc=:rfc, 
        curp=:curp
        WHERE id_equipo=:id_equipo;");
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':rfc', $datos['rfc'], PDO::PARAM_STR);
        $stmt->bindParam(':curp', $datos['curp'], PDO::PARAM_STR);
        $stmt->bindParam(':id_equipo', $id_equipo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
    function validate_equipo($datos){
        
        if (empty($datos['nombre'])) {
            return false;
        }
        if (empty($datos['primer_apellido'])) {
            return false;
        }
        if (empty($datos['segundo_apellido'])) {
            return false;
        }
        if (empty($datos['rfc'])) {
            return false;
        }
        if (empty($datos['curp'])) {
            return false;
        }
        if(!$this->validarRFC($datos['rfc'])){
            return false;
        }
        if(!$this->validarCURP($datos['curp'])){
            return false;
        }
        return true;
    }
    
    function validarRFC($rfc){
        $regex = '/^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$/';
        return preg_match($regex, $rfc);
    }//fin función
    function validarCURP($curp){
        $regex = '/^[A-Z]{4}[0-9]{6}[H|M]{1}[A-Z0-9]{7}$/';
        return preg_match($regex, $curp);
    }//fin función
}
