<?php
//MODELO 
require_once(__DIR__."/sistema.class.php");
class TipoPago extends Sistema{
    function getAll(){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_tipo_pago, descripcion FROM tipo_pago;");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }

    function getOne($id_tipo_pago){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_tipo_pago, descripcion FROM tipo_pago WHERE id_tipo_pago=:id_tipo_pago;");
        $stmt->bindParam(':id_tipo_pago', $id_tipo_pago, PDO::PARAM_INT);
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
        if ($this->validate_tipo_pago($datos)) {       
            $stmt=$this->conn->prepare("INSERT INTO tipo_pago (descripcion) VALUES (:descripcion);");
            $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
        }
        return 0;

    }
    function delete($id_tipo_pago){
        $this->connect();
        $stmt = $this->conn->prepare("DELETE FROM tipo_pago WHERE id_tipo_pago=:id_tipo_pago;");
        $stmt->bindParam(':id_tipo_pago', $id_tipo_pago, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
    function update($id_tipo_pago, $datos){//datos es un array
        $this->connect();
        $stmt=$this->conn->prepare("UPDATE tipo_pago SET nombre=:nombre, 
        primer_apellido=:primer_apellido, 
        segundo_apellido=:segundo_apellido, 
        rfc=:rfc, 
        curp=:curp
        WHERE id_tipo_pago=:id_tipo_pago;");
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':rfc', $datos['rfc'], PDO::PARAM_STR);
        $stmt->bindParam(':curp', $datos['curp'], PDO::PARAM_STR);
        $stmt->bindParam(':id_tipo_pago', $id_tipo_pago, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
