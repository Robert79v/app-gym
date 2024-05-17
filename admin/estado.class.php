<?php
//MODELO 
require_once(__DIR__."/sistema.class.php");
class Estado extends Sistema{
    function getAll(){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_estado, estado
        from estado;");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getOne($id_estado){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_estado, nombre, primer_apellido, segundo_apellido 
                from estado
                WHERE id_estado=:id_estado;");
        $stmt->bindParam(':id_estado', $id_estado, PDO::PARAM_INT);
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
    function insert($datos) {
        $this->connect();
        
        if ($this->validate_estado($datos)) {
            $stmt = $this->conn->prepare("INSERT INTO estado (nombre, primer_apellido, segundo_apellido) VALUES (:nombre, :primer_apellido, :segundo_apellido);");
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
            $stmt->execute();
            $id_estado = $this->conn->lastInsertId();
    
            // Insertar los servicios y tipo de pago seleccionados en la tabla pago
            if (isset($datos['servicios']) && is_array($datos['servicios'])) {
                $pagoModelo = new Pago(); // Instanciar el modelo de Pago
                foreach ($datos['servicios'] as $id_servicio) {
                    // Obtener el id_tipo_pago seleccionado del formulario
                    $id_tipo_pago = $datos['id_tipo_pago'];
    
                    $fecha_inicio = date("Y-m-d"); // Fecha actual
                    $pagoModelo->insert([
                        'id_estado' => $id_estado,
                        'id_servicio' => $id_servicio,
                        'id_tipo_pago' => $id_tipo_pago,
                        'fecha_inicio' => $fecha_inicio
                    ]);
                }
            }
    
            return $id_estado;
        }
    
        return 0;
    }
    
    function Update($id_estado, $datos) {
        $this->connect();
        $stmt = $this->conn->prepare("UPDATE estado SET 
                                    nombre=:nombre,
                                    primer_apellido=:primer_apellido,
                                    segundo_apellido=:segundo_apellido
                                    WHERE id_estado=:id_estado;");                            
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':id_estado', $id_estado, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }    
    function delete($id_estado){
        $this->connect();
        $stmt = $this->conn->prepare("DELETE FROM estado WHERE id_estado=:id_estado;");
        $stmt->bindParam(':id_estado', $id_estado, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
    function validate_estado($datos){
        
        if (empty($datos['nombre'])) {
            return false;
        } 
        if (empty($datos['primer_apellido'])) {
            return false;
        }
        if (empty($datos['segundo_apellido'])) {
            return false;
        }
        return true;
    }

}
