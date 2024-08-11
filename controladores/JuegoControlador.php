<?php
    session_start();
    require_once('modelos/Juego.php');

    class JuegoControlador {
        private $modelo;

        function __construct()
        {
            $this->modelo = new Juego();
        }

        public function inicio()
        {
            if (!empty($_SESSION['usuario'])) {
                header('refresh:0;url=?c=Juego&a=mostrarJuegos;');
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function mostrarJuegos()
        {
            if (!empty($_SESSION['usuario'])) {
                require_once('vistas/juego/juego_listado.php');
            }else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function altaJuego()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {
                    require_once('vistas/juego/juego_alta.php');
                } else {
                    header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/juego/alertas.php');
                }
               
           }else {
               header('refresh:0;url=?c=Inicio&a=inicio');
           }
        }

        public function altaJuegoOk()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {

                    if (!empty($_POST['titulo']) && !empty($_POST['jugadores']) && !empty($_POST['lanzamiento']) && !empty($_POST['genero']) && !empty($_FILES['portada']['size'])){

                            $guardar = $this->modelo->guardarJuegoEnBD($_POST['titulo'], $_POST['jugadores'], $_POST['lanzamiento'], $_POST['genero'], $_FILES);

                            if ($guardar == true) {
                                header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                                $colorFondo = 'bg-success';
                                $respuesta = '¡Juego guardado con exito!';                                
                            } else {
                                header("refresh:3;url=?c=Juego&a=mostrarJuegos");
                                $colorFondo = 'bg-warning';
                                $respuesta = 'Error inesperado. Intentelo nuevamente.';                               
                            }

                            require_once('vistas/juego/alertas.php');

                    } else {
                        header('refresh:3;url=?c=Juego&a=altaJuego');
                        $colorFondo = 'bg-warning';
                        $respuesta = 'Faltan datos.'; 
                        require_once('vistas/juego/alertas.php');
                    }

                } else {
                    header('refresh:3;url=?C=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/juego/alertas.php');
                }
    
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function eliminarJuego()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {
                    if (!empty($_GET['id'])) {
                        $id = $_GET['id'];
                        $this->modelo->setTitulo($id);
                        require_once('vistas/juego/juego_eliminacion.php');
                    }else {
                        header('refresh:2;url=?c=Juego&a=mostrarJuegos');
                        $colorFondo = 'bg-warning';
                        $respuesta = 'Error inesperado. Intente nuevamente.'; 
                        require_once('vistas/juego/alertas.php');
                    }

                } else {
                    header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/juego/alertas.php');
                }
               
           }else {
               header('refresh:0;url=?c=Inicio&a=inicio');
           }
        }

        public function eliminarJuegoOk()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {

                    if (!empty($_GET['id'])){

                            $eliminar = $this->modelo->eliminarJuego($_GET['id']);

                            if ($eliminar == true) {
                                header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                                $colorFondo = 'bg-danger';
                                $respuesta = 'Juego eliminado con exito.'; 
                            } else {
                                header("refresh:3;url=?c=Juego&a=mostrarJuegos");
                                $colorFondo = 'bg-warning';
                                $respuesta = 'Error inesperado. Intentelo nuevamente.'; 
                            }

                    require_once('vistas/juego/alertas.php');

                    } else {
                        header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                        $colorFondo = 'bg-warning';
                        $respuesta = 'Faltan datos.'; 
                        require_once('vistas/juego/alertas.php');
                    }

                } else {
                    header('refresh:3;url=?C=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/juego/alertas.php');
                }
    
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function modificarJuego()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {
                    if (!empty($_GET['id'])) {
        
                        $id = $_GET['id'];
                        $resultados = $this->modelo->recuperarDatos($id);
                        require_once('vistas/juego/juego_modificacion.php');
                    }else {
                        header('refresh:2;url=?c=Juego&a=mostrarJuegos');
                        $colorFondo = 'bg-warning';
                        $respuesta = 'Error inesperado. Intente nuevamente.'; 
                        require_once('vistas/juego/alertas.php');
                    }
                } else {
                    header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/juego/alertas.php');
                }
               
           }else {
               header('refresh:0;url=?c=Inicio&a=inicio');
           }
        }

        public function modificarJuegoOk()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {

                    if (!empty($_POST['titulo']) && !empty($_POST['jugadores']) && !empty($_POST['lanzamiento']) && !empty($_POST['genero']) && !empty($_FILES['portada']['size'])){

                            $modificar = $this->modelo->modificarJuego($_POST['titulo'], $_POST['jugadores'], $_POST['lanzamiento'], $_POST['genero'], $_FILES, $_POST['id'], $_POST['nombFotoAnt']);

                            if ($modificar == true) {
                                header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                                $colorFondo = 'bg-success';
                                $respuesta = '¡Juego actualizado con exito!'; 
                            } else {
                                header("refresh:3;url=?c=Juego&a=mostrarJuegos");
                                $colorFondo = 'bg-danger';
                                $respuesta = 'Error inesperado. Intentelo nuevamente.'; 
                            }

                            require_once('vistas/juego/alertas.php');

                    } else {
                        header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                        $colorFondo = 'bg-warning';
                        $respuesta = 'Faltan datos.'; 
                        require_once('vistas/juego/alertas.php');
                    }

                } else {
                    header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/juego/alertas.php');
                }
    
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function preferencias()
        {
            if (!empty($_SESSION['usuario'])) {
                require_once('vistas/juego/cookies/preferencias.php');
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function gardarCookie()
        {
            if (!empty($_SESSION['usuario'])) {
          
                if (!empty($_POST['preferencia'])) {
                    $pref = $_POST['preferencia'];
        
                    $this->modelo->guardarPreferencia($pref, $_SESSION['usuario']);
                    header('refresh:2;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-primary';
                    $respuesta = '¡Se guardo la preferencia!'; 
                    require_once('vistas/juego/alertas.php');
                } else {
                    $colorFondo = 'bg-warning';
                    $respuesta = 'Faltan Datos.'; 
                    require_once('vistas/juego/alertas.php');
                }
        
            }else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function listarFavoritos()
        {
            if (!empty($_SESSION['usuario'])) {
                require_once('vistas/juego/cookies/listar_favoritos.php');
            }else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

    } // fin clase JuegoControlador
?>