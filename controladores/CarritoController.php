<?php 
    require_once('modelos/Carrito.php');

    class CarritoController {
        
        private $modelo;

        public function __construct() 
        {
            $this->modelo = new Carrito;    
        }

        public function añadirAlCarrito()
        {
            if (!empty($_SESSION['usuario'])) {

                if (!empty($_GET['id'])) {
                    $this->modelo->añadirAlCarrito($_GET['id']);
                    header('refresh:2;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-success';
                    $respuesta = '¡Se agrego un producto al carrito!'; 
                    require_once('vistas/juego/alertas.php');
                }
               
           }else {
               header('refresh:0;url=?c=Inicio&a=inicio');
           }
        }

        public function mostrarCarrito()
        {
            if (!empty($_SESSION['usuario'])) {
                //$juegos = $this->modelo->productos();

                if (!empty($juegos)) {
                    require_once('vistas/juego/carrito/mostrar_carrito.php');    
                } else {
                    $colorFondo = 'bg-primary';
                    $respuesta = '¡Su carrito esta vacio!'; 
                    require_once('vistas/juego/alertas.php');
                }
                
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

    }

?>