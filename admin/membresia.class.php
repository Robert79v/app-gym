<?php
//MODELO 
require_once(__DIR__."/sistema.class.php");
class Membresia extends Sistema{
    function getAll(){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_membresia, membresia, costo FROM membresia;");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }

    function getMembresiaPesas(){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_membresia, membresia
        FROM membresia
        WHERE membresia NOT LIKE '%boxeo%' AND membresia NOT LIKE '%yoga%';");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }

    function getMembresiaBoxeo(){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_membresia, membresia
        FROM membresia
        WHERE membresia LIKE '%boxeo%';");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }

    function getMembresiaYoga(){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_membresia, membresia
        FROM membresia
        WHERE membresia LIKE '%yoga%';");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }

    function getOne($id_membresia){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_membresia, membresia, costo FROM membresia WHERE id_membresia=:id_membresia;");
        $stmt->bindParam(':id_membresia', $id_membresia, PDO::PARAM_INT);
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
        if ($this->validate_membresia($datos)) {
            $dias_semana = $this->combinarDiasConsecutivos($datos['dias_semana']);
            
            $stmt=$this->conn->prepare("INSERT INTO membresia (membresia, costo, hora_inicio, hora_fin, dias_semana) VALUES (:membresia, :costo, :hora_inicio, :hora_fin, :dias_semana);");
            $stmt->bindParam(':membresia', $datos['membresia'], PDO::PARAM_STR);
            $stmt->bindParam(':costo', $datos['costo'], PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        }
        return 0;
    }

    function delete($id_membresia){
        $this->connect();
        $stmt = $this->conn->prepare("DELETE FROM membresia WHERE id_membresia=:id_membresia;");
        $stmt->bindParam(':id_membresia', $id_membresia, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    function update($id_membresia, $datos){//datos es un array
        $this->connect();
        $stmt=$this->conn->prepare("UPDATE membresia SET membresia=:membresia,
                                                        costo=:costo,
                                                        hora_inicio=:hora_inicio,
                                                        hora_fin=:hora_fin,
                                                        dias_semana=:dias_semana
        WHERE id_membresia=:id_membresia;");
        $stmt->bindParam(':membresia', $datos['membresia'], PDO::PARAM_STR);
        $stmt->bindParam(':id_membresia', $id_membresia, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
    function validate_membresia($datos){
        if (empty($datos['membresia'])) {
            return false;
        }   
        return true;
    }
    function combinarDiasConsecutivos($dias_semana) {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $dias_seleccionados = array_fill_keys($dias, false);
    
        foreach ($dias as $dia) {
            if (strpos($dias_semana, $dia) !== false) {
                $dias_seleccionados[$dia] = true;
            }
        }
    
        $dias_consecutivos = [];
        $inicio_rango = null;
        $ultimo_dia = null;
    
        foreach ($dias_seleccionados as $dia => $seleccionado) {
            if ($seleccionado) {
                if ($inicio_rango === null) {
                    $inicio_rango = $dia;
                }
                $ultimo_dia = $dia;
            } elseif ($inicio_rango !== null) {
                if ($inicio_rango === $ultimo_dia) {
                    $dias_consecutivos[] = $inicio_rango;
                } else {
                    $dias_consecutivos[] = $inicio_rango . ' a ' . $ultimo_dia;
                }
                $inicio_rango = null;
            }
        }
    
        if ($inicio_rango !== null) {
            if ($inicio_rango === $ultimo_dia) {
                $dias_consecutivos[] = $inicio_rango;
            } else {
                $dias_consecutivos[] = $inicio_rango . ' a ' . $ultimo_dia;
            }
        }
    
        if (count($dias_consecutivos) === 0) {
            return ''; // Si no hay días seleccionados
        } elseif (count($dias_consecutivos) === 1) {
            return reset($dias_consecutivos); // Si solo hay un día seleccionado
        } elseif ($dias_consecutivos === ['Lunes a Viernes']) {
            return 'Lunes a Viernes'; // Caso específico: lunes a viernes
        } elseif ($dias_consecutivos === ['Lunes a Sábado']) {
            return 'Lunes a Sábado'; // Caso específico: lunes a sábado
        }
    
        return implode(', ', $dias_consecutivos);
    }    
}
