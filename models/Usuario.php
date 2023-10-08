<?php

class Usuario extends Conectar
{

    public function login()
    {
        $conectar = parent::Conexion();
        parent::set_names();

        if (isset($_POST["enviar"])) {
            $correo = $_POST["usu_correo"];
            $pass = $_POST["usu_pass"];
            $rol = $_POST["rol_id"];

            if (empty($correo) and empty($pass)) {

                header("Location:" . conectar::ruta() . "index.php?m=2");
                exit();
            } else {
                $sql = "SELECT * FROM tm_usuario WHERE usu_correo = ? AND usu_pass =? AND rol_id=? AND est = 1;";

                $stmr = $conectar->prepare($sql);
                $stmr->bindValue(1, $correo);
                $stmr->bindValue(2, $pass);
                $stmr->bindValue(3, $rol);
                $stmr->execute();

                $resultado = $stmr->fetch();

                if (is_array($resultado) and count($resultado) > 0) {
                    $_SESSION["usu_id"] = $resultado["usu_id"];
                    $_SESSION["usu_nom"] = $resultado["usu_nom"];
                    $_SESSION["usu_ape"] = $resultado["usu_ape"];
                    $_SESSION["rol_id"] = $resultado["rol_id"];
                    header("Location:" . conectar::ruta() . "view/Home/");
                    exit();
                } else {
                    header("Location:" . conectar::ruta() . "index.php?m=1");
                    exit();
                }
            }
        }
    }

    public function insert_usuario($usu_nom, $usu_ape, $usu_correo, $usu_pass, $rol_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO tm_usuario (usu_id, usu_nom, usu_ape, usu_correo, usu_pass, rol_id, fech_crea, fech_modi, fech_elim,est) VALUES(NULL,?,?,?,?,?,now(),NULL,NULL,'1')";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_nom);
        $sql->bindValue(2, $usu_ape);
        $sql->bindValue(3, $usu_correo);
        $sql->bindValue(4, $usu_pass);
        $sql->bindValue(5, $rol_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_usuario()
    {
    }

    public function delete_usuario($usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario SET est='0' WHERE usu_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);

        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_usuario()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_usuario WHERE est='0'";
        $sql = $conectar->prepare($sql);

        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_usuario_x_id($usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_usuario WHERE usu_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
