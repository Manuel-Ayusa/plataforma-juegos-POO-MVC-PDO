<?php

    trait Session {

        private $usuForm;
        private $contraForm;
        private $varSessionUsu; 
        private $varSessionFoto;
        private $id_usuario; 

        public function validarDatos(string $usuForm, string $contraForm) //valida los datos
        {
            $this->usuForm = $usuForm;
            $this->contraForm = sha1($contraForm);

            $validacion = false;
            $activado = 'S';
            $consulta = 'SELECT id_usuario, usuario, foto FROM usuario WHERE usuario = ? AND pass = ? AND activado = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $this->usuForm);
            $sentencia->bindParam(2, $this->contraForm);
            $sentencia->bindParam(3, $activado);
            $sentencia->execute();
            $sentencia->bindColumn(1, $this->id_usuario);
            $sentencia->bindColumn(2, $this->varSessionUsu);
            $sentencia->bindColumn(3, $this->varSessionFoto);
            $filas = $sentencia->rowCount();
            $sentencia->fetch(PDO::FETCH_BOUND);

            if ($filas == 1) {
                $validacion = true;
            }

            return $validacion;
        }

        public function guardarVariablesDeSession()
        {
            $_SESSION['usuario'] = $this->varSessionUsu;
            $_SESSION['foto'] = $this->varSessionFoto;
            $_SESSION['tipo'] = $this->tipo;
            $_SESSION['id_usuario'] = $this->id_usuario;
         }

        public function getVarSessionUSu():string
        {
            return $this->varSessionUsu;
        }

        public function getVarSessionFoto():string
        {
            return $this->varSessionFoto;
        }


    }
?>