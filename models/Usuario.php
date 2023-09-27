<?php
    
    class Usuario extends Conectar{
        
        public function login(){
            $conectar= parent::Conexion();
            parent::set_names();
            
            if(isset($_POST["enviar"])){
                $correo = $_POST["usu_correo"];
                $pass = $_POST["usu_pass"];
                
                if(empty($correo) and empty($pass)){
                
                    header("Location:".conectar::ruta()."index.php?m=2");
                    exit();
                } else {
                    $sql = "SELECT * FROM tm_usuario WHERE usu_correo = ? AND usu_pass =? AND est = 1;";
                    
                    $stmr = $conectar->prepare($sql);
                    $stmr->bindValue(1, $correo);
                    $stmr->bindValue(2, $pass);
                    $stmr->execute();
                    
                    $resultado = $stmr->fetch();
                    
                    if(is_array($resultado) and count($resultado)>0){
                        $_SESSION["usu_id"] = $resultado["usu_id"];
                        $_SESSION["usu_nom"] = $resultado["usu_nom"];
                        $_SESSION["usu_ape"] = $resultado["usu_ape"];
                        header("Location:".conectar::ruta()."view/Home/");
                        exit();
                    } else {
                        header("Location:".conectar::ruta()."index.php?m=1");
                        exit();
                    }
                    
                }
                
            }
            
        }
        
    }
    
?>

