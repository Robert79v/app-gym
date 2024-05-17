<?php
//MODELO 
require_once(__DIR__."/sistema.class.php");
class Socio extends Sistema{
    function getAll(){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_socio, CONCAT(s.nombre, ' ', s.primer_apellido, ' ', s.segundo_apellido) as nombre_completo, u.correo
        from socio s LEFT JOIN usuario u ON s.id_usuario = u.id_usuario;");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getOne($id_socio){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_socio, nombre, primer_apellido, segundo_apellido 
                from socio
                WHERE id_socio=:id_socio;");
        $stmt->bindParam(':id_socio', $id_socio, PDO::PARAM_INT);
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
        $app = new Sistema();
        
        try {
            $app->connect();
            $app->conn->beginTransaction();
        
            // Insertar el socio
            $stmt = $app->conn->prepare("INSERT INTO socio (nombre, primer_apellido, segundo_apellido) VALUES (:nombre, :primer_apellido, :segundo_apellido);");
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
            $stmt->execute();
        
            // Recuperar el ID del socio recién insertado
            $id_socio = $app->conn->lastInsertId();
        
            // Insertar los servicios seleccionados en la tabla de pago
            if ($id_socio && isset($datos['servicios']) && is_array($datos['servicios'])) {
                $id_tipo_pago = $datos['id_tipo_pago'];
                $fecha_inicio = date("Y-m-d");
                foreach ($datos['servicios'] as $id_servicio) {
                    // Obtener el id_membresia correspondiente al servicio seleccionado
                    $id_membresia = $datos["id_membresia_$id_servicio"]; // Utilizar el nombre único del campo oculto
                    // Insertar en la tabla de pago
                    $sql = "INSERT INTO pago (id_socio, id_servicio, id_tipo_pago, fecha_inicio, id_membresia) VALUES (:id_socio, :id_servicio, :id_tipo_pago, :fecha_inicio, :id_membresia);";
                    $stmt = $app->conn->prepare($sql);
                    $stmt->bindParam(':id_socio', $id_socio, PDO::PARAM_INT);
                    $stmt->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
                    $stmt->bindParam(':id_tipo_pago', $id_tipo_pago, PDO::PARAM_INT);
                    $stmt->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
                    $stmt->bindParam(':id_membresia', $id_membresia, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
        
            if ($id_socio) {
                $app->conn->commit();
                return $id_socio;
            } else {
                $app->conn->rollBack();
                return false;
            }
        } catch(PDOException $e) {
            $app->conn->rollBack();
            // Manejar el error como desees
            return false;
        }
    }
    
        
    function Update($id_socio, $datos) {
        $this->connect();
        $stmt = $this->conn->prepare("UPDATE socio SET 
                                    nombre=:nombre,
                                    primer_apellido=:primer_apellido,
                                    segundo_apellido=:segundo_apellido
                                    WHERE id_socio=:id_socio;");                            
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':id_socio', $id_socio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }    
    function delete($id_socio){
        $this->connect();
        $stmt = $this->conn->prepare("DELETE FROM socio WHERE id_socio=:id_socio;");
        $stmt->bindParam(':id_socio', $id_socio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
    function validate_socio($datos){
        
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
