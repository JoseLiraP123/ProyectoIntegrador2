<?php
    class Prioridad extends Conectar{

        /* TODO:Todos los registros */
        public function get_prioridad(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_prioridad WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Insert */
        public function insert_prioridad($prio_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_prioridad (prio_id, prio_nom, est) VALUES (NULL,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prio_nom);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Update */
        public function update_prioridad($prio_id,$prio_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_prioridad set
                prio_nom = ?
                WHERE
                prio_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prio_nom);
            $sql->bindValue(2, $prio_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Delete */
        public function delete_prioridad($prio_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_prioridad SET
                est = 0
                WHERE 
                prio_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prio_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Registro x id */
        public function get_prioridad_x_id($prio_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_prioridad WHERE prio_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prio_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>