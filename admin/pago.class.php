<?php
//MODELO 
require_once(__DIR__."/sistema.class.php");
class Pago extends Sistema{
    function getAll() {
        $this->connect();
        $stmt = $this->conn->prepare("SELECT p.id_socio, p.id_servicio, CONCAT(s.nombre, ' ', s.primer_apellido, ' ', s.segundo_apellido) as socio, se.servicio, p.fecha_inicio, p.fecha_fin, tp.descripcion, m.membresia
        FROM pago p
        INNER JOIN socio s ON p.id_socio = s.id_socio
        INNER JOIN servicio se ON p.id_servicio = se.id_servicio
        INNER JOIN tipo_pago tp ON p.id_tipo_pago = tp.id_tipo_pago
        INNER JOIN membresia m ON p.id_membresia = m.id_membresia;");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }

    function getOne($id_socio, $id_servicio){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_socio, id_servicio, fecha_inicio, fecha_fin,tipo_pago FROM pago WHERE id_socio=:id_socio AND id_servicio=:id_servicio;");
        $stmt->bindParam(':id_socio', $id_socio, PDO::PARAM_INT);
        $stmt->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        if (isset($datos[0])) {
            $this->setCount(count($datos));
            return $datos[0];
        }
        return array();
    }
    function getPagosPorSocio($id_socio) {
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_socio, id_servicio, fecha_inicio, fecha_fin FROM pago WHERE id_socio = :id_socio");
        $stmt->bindParam(':id_socio', $id_socio, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $pagos = $stmt->fetchAll();
        return $pagos;
    }
    function Insert($datos){
        $this->connect();
        if ($this->validate_pago($datos)) { 
            try {
                $stmt=$this->conn->prepare("INSERT INTO pago (id_socio, id_servicio, fecha_inicio, id_tipo_pago) VALUES (:id_socio, :id_servicio, :fecha_inicio, :id_tipo_pago);");
                $stmt->bindParam(':id_socio', $datos['id_socio'], PDO::PARAM_INT);
                $stmt->bindParam(':id_servicio', $datos['id_servicio'], PDO::PARAM_INT);
                $stmt->bindParam(':fecha_inicio', $datos['fecha_inicio'], PDO::PARAM_STR);
                $stmt->bindParam(':id_tipo_pago', $datos['id_tipo_pago'], PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->rowCount();
            } catch (PDOException $e) {
                echo "Error al ejecutar la consulta: " . $e->getMessage(); // Mensaje de error
                return 0; // Retornar 0 en caso de error
            }
        }
        return 0; // Retornar 0 si los datos no son válidos
    }

    function Delete($id_socio, $id_servicio) {
        $this->connect();
        $stmt = $this->conn->prepare("DELETE FROM pago WHERE id_socio = :id_socio AND id_servicio = :id_servicio;");
        $stmt->bindParam(':id_socio', $id_socio, PDO::PARAM_INT);
        $stmt->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    function validate_pago($datos) {
        return true;
    }
}
?>
