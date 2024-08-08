<?php

    trait Session {

        private $usuForm;
        private $contraForm;
        private $varSessionUsu; 
        private $varSessionFoto; 

        public function validarDatos(string $usuForm, string $contraForm) //valida los datos e inicializa las variables de session
        {
            $this->usuForm = $usuForm;
            $this->contraForm = sha1($contraForm);

            $validacion = false;
            $activado = 'S';
            $consulta = 'SELECT usuario, foto FROM usuario WHERE usuario = ? AND pass = ? AND activado = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $this->usuForm);
            $sentencia->bindParam(2, $this->contraForm);
            $sentencia->bindParam(3, $activado);
            $sentencia->execute();
            $sentencia->bindColumn(1, $this->varSessionUsu);
            $sentencia->bindColumn(2, $this->varSessionFoto);
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