<?php
//MODELO 
require_once(__DIR__."/sistema.class.php");
class Servicio extends Sistema{
    function getAll(){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_servicio, servicio, hora_inicio, hora_fin, dias_semana FROM servicio;");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }

    function getOne($id_servicio){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_servicio, servicio, descripcion, hora_inicio, hora_fin, dias_semana FROM servicio WHERE id_servicio=:id_servicio;");
        $stmt->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
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
        if ($this->validate_servicio($datos)) {
            // Verificar si hay días consecutivos y actualizar la cadena de días en consecuencia
            $dias_semana = $this->combinarDiasConsecutivos($datos['dias_semana']);
            
            $stmt=$this->conn->prepare("INSERT INTO servicio (servicio, descripcion, hora_inicio, hora_fin, dias_semana) VALUES (:servicio, :descripcion, :hora_inicio, :hora_fin, :dias_semana);");
            $stmt->bindParam(':servicio', $datos['servicio'], PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
            $stmt->bindParam(':hora_inicio', $datos['hora_inicio'], PDO::PARAM_STR);
            $stmt->bindParam(':hora_fin', $datos['hora_fin'], PDO::PARAM_STR);
            $stmt->bindParam(':dias_semana', $dias_semana, PDO::PARAM_STR); // Usar la cadena de días formateada
            $stmt->execute();
            return $stmt->rowCount();
        }
        return 0;
    }

    function delete($id_servicio){
        $this->connect();
        $stmt = $this->conn->prepare("DELETE FROM servicio WHERE id_servicio=:id_servicio;");
        $stmt->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    function update($id_servicio, $datos){//datos es un array
        $this->connect();
        $stmt=$this->conn->prepare("UPDATE servicio SET servicio=:servicio,
                                                        descripcion=:descripcion,
                                                        hora_inicio=:hora_inicio,
                                                        hora_fin=:hora_fin,
                                                        dias_semana=:dias_semana
        WHERE id_servicio=:id_servicio;");
        $stmt->bindParam(':servicio', $datos['servicio'], PDO::PARAM_STR);
        $stmt->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
    function validate_servicio($datos){
        if (empty($datos['servicio'])) {
            return false;
        }   
        return true;
    }
    function combinarDiasConsecutivos($dias_semana) {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $dias_seleccionados = array_fill_keys($dias, false);
    
        // Marcar los días seleccionados
        foreach ($dias as $dia) {
            if (strpos($dias_semana, $dia) !== false) {
                $dias_seleccionados[$dia] = true;
            }
        }
    
        // Construir la cadena de días
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
    
        // Verificar casos especiales
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
