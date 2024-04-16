<?php
    require_once('BaseDeDatos.php');

    class Juego {

        public $id_juego;
        public $titulo;
        public $jugadores;
        public $lanzamiento;
        public $genero;
        public $portada;
        public $preferencia;
        private $conexion;

        public function __construct()
        {
            $this->conexion = BaseDeDatos::conectar();
        }


        public function recuperarDatos(int $id)
        {
            $consulta = 'SELECT * FROM juego WHERE id_juego = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();
            $resultados = $sentencia->fetch(PDO::FETCH_OBJ);

            return $resultados;
        }

        public function mostrarJuegos()
        {
            $consulta = 'SELECT * FROM juego';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->execute();
            $resul = $sentencia->fetchAll(PDO::FETCH_OBJ);

            if (!$resul) {
                echo '<section class="col-5 mt-2 mb-2 text-center">';
                echo '<p>No hay resultados</p></section>';
            }

            return $resul;
        }

        public function guardarJuegoEnBD(string $titulo, int $jugadores, string $lanzamiento, string $genero, $portada):bool
        {
            $nombrePortada = $this->moverPortadaJuego($titulo, $portada);
            
            $confrimacion = false;
            $consulta = 'INSERT INTO juego(titulo, jugadores, lanzamiento, genero, portada) VALUE (?, ?, ?, ?, ?)';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1 , $titulo);
            $sentencia->bindParam(2 , $jugadores);
            $sentencia->bindParam(3 , $lanzamiento);
            $sentencia->bindParam(4 , $genero);
            $sentencia->bindParam(5 , $nombrePortada);
            $confrimacion = $sentencia->execute();

            return $confrimacion;
        }

        public function moverPortadaJuego(string $titulo, $portada)
        {
            $tipoDeArchivo = $portada['portada']['type'];
            if ($tipoDeArchivo == 'image/jpeg' || $tipoDeArchivo == 'image/jpg' || $tipoDeArchivo == 'image/png' || $tipoDeArchivo == 'image/avif' || $tipoDeArchivo == 'image/webp') {
                $nombreOrg = $portada['portada']['name'];
                $imagen = $titulo; //variable para guardar en la carpeta 'img'
                $imagen = explode(' ', $imagen); 
                $imagen = implode('_', $imagen);
                $origen = $portada['portada']['tmp_name'];
                $ext = explode('.', $nombreOrg);
                $cant = count($ext) - 1; // componentes del arreglo - 1
                $nuevoNombre = $imagen . '.' . $ext[$cant];
                $destino = 'publico/img/portadas/' . $nuevoNombre; // $ext[$cant] selecciona el ultimo valor del arreglo ext, que seria la extencion de la imagen(esto se hace por las imagenes que tienen mas de un punto en su nombre)
                $envio = move_uploaded_file($origen, $destino);
            }

            return $nuevoNombre;
        }

        public function modificarJuego(string $titulo, int  $jugadores, string $lanzamiento, string $genero, $portada, int $id, string $nombreFotoAnt):bool
        {
            unlink('publico/img/portadas/' . $nombreFotoAnt);

            $portada = $this->moverPortadaJuego($titulo, $portada);

            $confirmacion = false;

            $consulta = 'UPDATE juego SET titulo = ?, jugadores = ?, lanzamiento = ?, genero = ?, portada = ? WHERE id_juego = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1 , $titulo);
            $sentencia->bindParam(2 , $jugadores);
            $sentencia->bindParam(3 , $lanzamiento);
            $sentencia->bindParam(4 , $genero);
            $sentencia->bindParam(5 , $portada);
            $sentencia->bindParam(6 , $id);
            $confirmacion = $sentencia->execute();

            return $confirmacion;
        }

        public function setTitulo(int $id)
        {
            $consulta = 'SELECT titulo FROM juego WHERE id_juego = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();
            $sentencia->bindColumn(1, $this->titulo);
            $sentencia->fetch(PDO::FETCH_BOUND); 
        }

        public function eliminarJuego(int $id):bool
        {
            $confirmacion = false;

            $consulta = 'DELETE FROM juego WHERE id_juego = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $id);
            $confirmacion = $sentencia->execute();

            return $confirmacion;
        }

        public function agregarACarrito(int $id)
        {
            if (empty($_SESSION['carrito'])) {
                $_SESSION['carrito'] = array();
            }
            if (empty($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id] = 1;
            }
            else {
                $_SESSION['carrito'][$id]++;
            }
        }        

        public function obtenerGeneros()
        {
            $consulta = 'SELECT DISTINCT(genero) FROM juego ORDER BY genero';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->execute();
            $resul = $sentencia->fetchAll(PDO::FETCH_OBJ);

            return $resul;
        }

        public function guardarPreferencia(string $preferencia, string $usuario)
        {
            $this->preferencia = $preferencia;
            setCookie($usuario, $this->preferencia, time()+360*24*60*60, '/');
        }

        public function getPreferencia():string
        {
            return $_COOKIE['preferencia'];
        }
        
        public function mostrarJuegosFav(string $usuario)
        {
            $consulta = 'SELECT * FROM juego WHERE genero = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $_COOKIE[$usuario]);
            $sentencia->execute();
            $resul = $sentencia->fetchAll(PDO::FETCH_OBJ);

            if (!$resul) {
                echo '<section class="col-5 mt-2 mb-2 text-center">';
                echo '<p class="text-white">No hay resultados</p></section>';
            }

            return $resul;
        }

        public function mostrarCarrito(int $id)
        {
            $consulta = 'SELECT * FROM juego WHERE id_juego = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();

            return $sentencia;
        }
    }
?>