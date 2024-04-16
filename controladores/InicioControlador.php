<?php

    class InicioControlador {

        private $modelo;

        public function inicio()
        {
            if (!empty($_GET['int'])) { //para agregar un mensaje en caso de contraseña o usuario incorrecto 
                $msj = 'msj';
                $class = "input";
            } else { 
                $class = '';
                $msj = '';
            }
            require_once('vistas/usuario/form_logueo.php');
        }
    }
?>