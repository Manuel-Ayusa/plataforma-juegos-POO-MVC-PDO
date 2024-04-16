<?php
    require_once('modelos/BaseDeDatos.php');

    if (!isset($_GET['c'])) {
        require_once('controladores/InicioControlador.php');
        $controlador = new InicioControlador();
        $controlador->inicio();
    } else {
        $controlador = $_GET['c'];
        require_once('controladores/' . $controlador . 'Controlador.php');  
        $controlador = $controlador . "Controlador";
        $controlador = new $controlador;
        $accion = isset($_GET['a']) ? $_GET['a'] : "inicio";
        $controlador->$accion();
    }
?>