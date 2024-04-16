<?php
    session_start();
    require_once('modelos/Usuario.php');

    class UsuarioControlador {

        private $modelo;

        function __construct()
        {
            $this->modelo = new Usuario();
        }

        public function inicio()
        {   
            if (!empty($_SESSION['usuario'])) {
                header('refresh:0;url=?c=Juego&a=mostrarJuegos;');
            }
            else {
                header('refresh:0;url=?c=Inicio&a=inicio');    
            }
        }

        public function loguear()
        {
            if (!empty($_POST['usuario']) && !empty($_POST['pass'])) {
                $usuForm = $_POST['usuario'];
                $contraForm = $_POST['pass'];
                $validacion = $this->modelo->validarDatos($usuForm, $contraForm);

                if ($validacion == true) {
                    $this->modelo->guardarTipo($usuForm);
                    $this->modelo->guardarVariablesDeSession();
                    header('refresh:0;url=?c=Juego&a=mostrarJuegos');
                }
                else {
                    header('refresh:0;url=?c=Inicio&a=inicio&int=1');   
                }
                
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
                echo '<p>Faltan datos</p>';
            }
        }

        public function cerrarSesion()
        {
            if (!empty($_SESSION['usuario'])) {
                header('refresh:3;url=?c=Usuario&a=inicio');
                session_destroy();
                $colorFondo = 'bg-primary';
                $respuesta = 'Cerrando sesion.'; 
                require_once('vistas/usuario/alertas.php');
            }else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function mostrarInfoUsuarios()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {
                    require_once("vistas/usuario/usuario_listado.php");
                    
                } else {
                    header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/usuario/alertas.php');
               }
        
           }else {
               header('refresh:0;url=?c=Inicio&a=inicio');
           }
        }

        public function altaUsuario()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {
                    require_once("vistas/usuario/usuario_alta.php");
                } else {
                    header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/usuario/alertas.php');
               }
        
           }else {
               header('refresh:0;url=?c=Inicio&a=inicio');
           }
        }

        public function altaUsuarioOk()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {

                    if (!empty($_POST['usuario']) && !empty($_POST['pass']) && !empty($_POST['tipo'])){
                        $registro = $this->modelo->registrarUsuario($_POST['usuario'], ($_POST['pass']), $_POST['tipo'], $_FILES);
            
                        if ($registro == true) {
                            header("refresh:3;url=?c=Usuario&a=mostrarInfoUsuarios");
                            $colorFondo = 'bg-success';
                            $respuesta = '¡Usuario registrado con exito!';
                        } else {
                            header("refresh:3;url=?c=Usuario&a=altaUsuario");
                            $colorFondo = 'bg-warning';
                            $respuesta = 'Error. Intentelo nuevamente.';
                        }

                        require_once('vistas/usuario/alertas.php');

                    } else {
                        header('refresh:3;url=?c=Usuario&a=altaUsuario');
                        echo '<p>Faltan datos.</p>';
                    }
        
                }else {
                    header('refresh:0;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/usuario/alertas.php');
                }
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function modificarUsuario()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {
                    if (!empty($_GET['id'])) {
                        $id = $_GET['id'];
                        $this->modelo->recuperarDatos($id);
                        require_once('vistas/usuario/usuario_modificacion.php');    
                    } else {
                        header("refresh:3;url=?c=Usuario&a=mostrarInfoUsuarios");
                        echo '<p>Error inesperado. Intente nuevamente</p>';
                    }
                    
                }else {
                    header('refresh:3;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/usuario/alertas.php');
                }
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function modificarUsuarioOk()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {

                    if (!empty($_POST['usuario']) && !empty($_POST['pass']) && !empty($_POST['tipo'])){
                        $modif = $this->modelo->actualizarDatos($_POST['usuario'], ($_POST['pass']), $_POST['tipo'], $_FILES, $_POST['id'], $_POST['nombFotoAnt']);
            
                        if ($modif == true) {
                            header("refresh:3;url=?c=Usuario&a=mostrarInfoUsuarios");
                            $colorFondo = 'bg-success';
                            $respuesta = '¡Modificado con exito!'; 
                        } else {
                            header("refresh:3;url=?c=Usuario&a=modificarUsuario");
                            $colorFondo = 'bg-warning';
                            $respuesta = 'Error inesperado. Intente nuevamente';                          
                        }

                        require_once('vistas/usuario/alertas.php');

                    } else {
                        header('refresh:3;url=?c=Usuario&a=mostrarInfoUsuarios');
                        $respuesta = 'Faltan datos.'; 
                        require_once('vistas/usuario/alertas.php');
                    }
        
                }else {
                    header('refresh:2;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/usuario/alertas.php');
                }
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function eliminarUsuario()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {
                    if (!empty($_GET['id'])) {
                        $id = $_GET['id'];
                        $this->modelo->setUsuario($id);
                        require_once('vistas/usuario/usuario_eliminacion.php');    
                    } else {
                        header("refresh:3;url=?c=Usuario&a=mostrarInfoUsuarios");
                        $respuesta = 'Error inesperado. Intente nuevamente'; 
                        require_once('vistas/usuario/alertas.php');
                    }
                    
                }else {
                    header('refresh:2;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/usuario/alertas.php');
                }
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function eliminarUsuarioOk()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {

                    if (!empty($_GET['id'])){
                        $eliminar = $this->modelo->eliminarUsuario($_GET['id']);
                        if ($eliminar == true) {
                            header("refresh:3;url=?c=Usuario&a=mostrarInfoUsuarios");
                            $colorFondo = 'bg-danger';
                            $respuesta = 'Usuario eliminado con exito.';
                        } else {
                            header("refresh:3;url=?c=Usuario&a=altaUsuario");
                            $colorFondo = 'bg-warning';
                            $respuesta = 'Error inesperado. Intentelo nuevamente';
                        }
                        require_once('vistas/usuario/alertas.php');
                    } else {
                        header("refresh:3;url=?c=Usuario&a=altaUsuario");
                        $respuesta = 'Faltan datos.';
                        require_once('vistas/usuario/alertas.php');
                    }
        
                } else {
                    header('refresh:2;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/usuario/alertas.php');
                }
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

        public function desactivarUsuario()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {
                    if (!empty($_GET['id'])) {
                        $id = $_GET['id'];
                        $this->modelo->setUsuario($id);
                        require_once('vistas/usuario/usuario_desactivacion.php');    
                    } else {
                        header("refresh:3;url=?c=Usuario&a=mostrarInfoUsuarios");
                        $colorFondo = 'bg-warning';
                        $respuesta = 'Error inesperado. Intente nuevamente.';
                        require_once('vistas/usuario/alertas.php');
                    }
                    
                }else {
                    header('refresh:2;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/usuario/alertas.php');
                }
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }
        
        public function desactivarUsuarioOk()
        {
            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['tipo'] == "Administrador") {

                    if (!empty($_GET['id'])){
                        $desac = $this->modelo->desactivarUsuario($_GET['id']);
                        if ($desac == true) {
                            header("refresh:3;url=?c=Usuario&a=mostrarInfoUsuarios");
                            $colorFondo = 'bg-warning';
                            $respuesta = 'Desactivado con exito.'; 
                        } else {
                            header("refresh:3;url=?c=Usuario&a=altaUsuario");
                            $colorFondo = 'bg-warning';
                            $respuesta = 'Error inesperado. Intentelo nuevamente.'; 
                        }

                        require_once('vistas/usuario/alertas.php');

                    } else {
                        header("refresh:3;url=?c=Usuario&a=altaUsuario");
                        echo '<p>Faltan datos.';
                    }
        
                } else {
                    header('refresh:2;url=?c=Juego&a=mostrarJuegos');
                    $colorFondo = 'bg-danger';
                    $respuesta = 'Contenido para administradores'; 
                    require_once('vistas/usuario/alertas.php');
                }
            } else {
                header('refresh:0;url=?c=Inicio&a=inicio');
            }
        }

    } // fin clase UsuarioControlador
?>