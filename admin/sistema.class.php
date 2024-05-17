<?php     
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    require __DIR__."/config.php";
    class Sistema extends Config{
        var $conn;
        var $count=0;
        function connect(){
            // Crea conexión
            $this->conn = new PDO(DB_DRIVER.":host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        }
        function query($sql){
            $this->connect();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $datos=array();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos = $stmt->fetchAll();
            return $datos;
        }
        function getRol($correo){
            $this->connect();
            $sql="SELECT r.rol from usuario u
            JOIN usuario_rol ur on u.id_usuario=ur.id_usuario
            JOIN rol r on ur.id_rol=r.id_rol
            where u.correo='".$correo."'";
            $datos=$this->query($sql);
            $info=array();
            foreach($datos as $row)
                array_push($info,$row['rol']);
            
            return $info;
        }
        function getPrivilegios($correo){
            $this->connect();
            $sql="SELECT p.privilegio from usuario u
            JOIN usuario_rol ur on u.id_usuario=ur.id_usuario
            JOIN rol_privilegio rp on ur.id_rol=rp.id_rol
            JOIN privilegio p on rp.id_privilegio=p.id_privilegio
            where u.correo='".$correo."'";
            $datos=$this->query($sql);
            $info=array();
            foreach($datos as $row)
                array_push($info,$row['privilegio']);
            return $info;
        }
        function login($correo,$contrasena){
            $contrasena=md5($contrasena);
            $this->connect();
            $sql="SELECT * from usuario where correo=:correo and contrasena=:contrasena;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':correo', $correo,PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $contrasena,PDO::PARAM_STR);
            $stmt->execute();
            $datos=array();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos = $stmt->fetchAll();
            
            if(isset($datos[0])){
                $roles=array();
                $roles=$this->getRol($correo);
                $privilegios=array();
                $privilegios=$this->getPrivilegios($correo);
                $_SESSION['validado']=true;
                $_SESSION['correo']=$correo;
                $_SESSION['roles']=$roles;
                $_SESSION['privilegios']=$privilegios;
                $_SESSION['id_usuario']= $datos[0]['id_usuario'];
                return $datos[0];
            }else{
                $this->logout();
            }
            return false;
        }
        function logout(){
            if(isset($_SESSION['cart'])){
                unset($_SESSION);
                session_destroy();
            } else {
                unset($_SESSION['validado']);
                unset($_SESSION['correo']);
                unset($_SESSION['roles']);
                unset($_SESSION['privilegios']);
            }

        }
        function checkRol($rol,$kill=false){
            if(isset($_SESSION['roles'])){
                if($_SESSION['validado']){
                    if(in_array($rol,$_SESSION['roles'])){
                        return true;
                    }
                }
            }
            if($kill){
                $this->logout();
                $this->alert('danger','Rol no permitido');
                die;
            }
            return false;
        }
        function checkPrivilegio($privilegio,$kill=false){
            if(isset($_SESSION['privilegios'])){
                if($_SESSION['validado']){
                    if(in_array($privilegio,$_SESSION['privilegios'])){
                        return true;
                    }
                }
            }
            if($kill){
                $this->logout();
                $this->alert('danger','Rol no permitido');
                die;
            }
            return false;
        }
        function alert($tipo, $mensaje){
            $alerta =array();
            $alerta['tipo']=$tipo;
            $alerta['mensaje']=$mensaje;
            include __DIR__.'/views/alert.php';
        }
        function SetCount($count){
            $this->count = $count;
        }
        function GetCount(){
            return $this->count;
        }
        function upload($carpeta){
            if(in_array($_FILES['fotografia']['type'],$this->getImageType())){
                if($_FILES['fotografia']['size']<=$this->getImageSize()){
                    $n=rand(1,1000000);
                    $nombre_archivo =$n.$_FILES['fotografia']['size'].$_FILES['fotografia']['name'];
                    $nombre_archivo=md5($nombre_archivo);
                    // espatula 25.jpg
                    // taladro.trupper x.jpg
                    $extencion=explode('.',$_FILES['fotografia']['name']);
                    $extencion=$extencion[sizeof($extencion)-1];
                    $nombre_archivo=$nombre_archivo.'.'.$extencion;
                    if(!file_exists('../uploads/'.$carpeta.'/'.$nombre_archivo)){
                        move_uploaded_file($_FILES['fotografia']['tmp_name'],'../uploads/'.$carpeta.'/'.$nombre_archivo);
                        return $nombre_archivo;
                    }
                }
            }
            return false;
        }
        function reset($correo){
            if(filter_var($correo,FILTER_VALIDATE_EMAIL)){
                $this->connect();
                $sql="SELECT * from usuario where correo=:correo;";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':correo', $correo,PDO::PARAM_STR);
                $stmt->execute();
                $datos=array();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $datos = $stmt->fetchAll();
                if(isset($datos[0])){
                    $token1 = md5($correo.'ALeaToRio52');
                    $token2 = md5($correo.date('Y-m-d H:i:s').rand(1,1000000));
                    $token = $token1.$token2;
                    $sql="UPDATE usuario set token=:token where correo=:correo;";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                    $stmt->bindParam(':correo', $correo,PDO::PARAM_STR);
                    $stmt->execute();
                    $destinatario = $correo;
                    $nombre_persona = 'Juanito Bananas'; 
                    $asunto = 'Recuperar contraseña';
                    $mensaje = " 
                    Hola, se ha solicitado un cambio de contraseña para tu cuenta.<br>
                    Usted puede recuperarla presionando el siguiente enlace <br>
                    <a href = 'http://localhost/gimnasio/admin/login.php?action=recovery&token=".$token."'>Recuperar contraseña</a> <br>
                    Muchas gracias <br>
                    Gimnasio Smart Zone";
                    if ($this->sendMail($destinatario,$nombre_persona,$asunto,$mensaje)){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }

        function recovery($token, $contrasena=null){
            $this->connect();
            if(strlen($token)==64){
                $sql="SELECT * from usuario where token=:token;";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':token', $token,PDO::PARAM_STR);
                $stmt->execute();
                $datos=array();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $datos = $stmt->fetchAll();
                if(isset($datos[0])){
                    if(!is_null($contrasena)){
                        $contrasena=md5($contrasena);
                        $correo=$datos[0]['correo'];
                        $sql="UPDATE usuario set contrasena=:contrasena, token=null where correo=:correo;";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
                        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                        $stmt->execute();
                    }
                    return true;
                }
            }
            return false;
        }

        function sendMail($destinatario,$nombre_persona,$asunto,$mensaje){
            require '../vendor/autoload.php';
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->Username = '21030097@itcelaya.edu.mx';
            $mail->Password = 'daeieanbsvtumhbh';
            $mail->setFrom('21030097@itcelaya.edu.mx', 'Roberto Carlos Andrade Ramírez');
            $mail->addAddress($destinatario, $nombre_persona);
            $mail->Subject = $asunto;
            $mail->msgHTML($mensaje);
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        }

        function register($datos){
            if(!filter_var($datos['correo'],FILTER_VALIDATE_EMAIL)){
                return false;
            }
            $this->connect();

            try{
                $this->conn->beginTransaction();
                $sql = 'select * from usuario where correo=:correo;';
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
                $stmt->execute();
                $usuario = $stmt->fetchAll();
                if(isset($usuario[0])){
                    $this->conn->rollBack();
                    return false;
                }
                $sql = 'insert into usuario (correo,contrasena) values (:correo,:contrasena);';
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
                $contrasena = $datos['contrasena'];
                $contrasena = md5($contrasena);
                $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
                $stmt->execute();
                $sql = 'select * from usuario where correo = :correo';
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
                $stmt->execute();
                $usuario = $stmt->fetchAll();
                if($usuario[0]){
                    $id_usuario = $usuario[0]['id_usuario'];
                    $sql = 'insert into usuario_rol (id_usuario,id_rol) values (:id_usuario,2);';
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    $stmt->execute();
                    $sql = 'insert into socio (nombre,primer_apellido,segundo_apellido,id_usuario) values (:nombre,:primer_apellido,:segundo_apellido,:id_usuario);';
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
                    $stmt->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
                    $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);                    
                    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    $stmt->execute();
                    $sql = 'select * from socio s join usuario u on u.id_usuario = s.id_usuario where s.id_usuario = :id_usuario;';
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    $stmt->execute();
                    $info = $stmt->fetchAll();
                    if(isset($info[0])){
                        $this->conn->commit();
                        return true;
                    }
                    $this->conn->rollBack();
                    return false;
                }else{
                    $this->conn->rollBack();
                    return false;        
                }
            }catch(PDOException $e){
                $this->conn->rollBack();
                return false;
            }
        }

        public function validateEmail($email){
            if(FILTER_VAR($email, FILTER_VALIDATE_EMAIL)){
                return true;
            }
            return false;
        }
    }
?>