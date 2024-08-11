<?php
    require_once('traits/Session.php');

    class Usuario {

        use Session;

        private $idUsu;
        private $usuario;
        private $contraseña;
        private $tipo;
        private $foto;
        private $activado;
        private $conexion;

        public function __construct()
        {
            $this->conexion = BaseDeDatos::conectar();
        }

        public function recuperarDatos(int $id)
        {
            $consulta = 'SELECT id_usuario, usuario, pass, tipo, foto, activado FROM usuario WHERE id_usuario = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $id);
            $sentencia->setFetchMode(PDO::FETCH_BOUND);
            $sentencia->execute();
            $sentencia->bindColumn(1, $this->idUsu);
            $sentencia->bindColumn(2, $this->usuario);
            $sentencia->bindColumn(3, $this->contraseña);
            $sentencia->bindColumn(4, $this->tipo);
            $sentencia->bindColumn(5, $this->foto);
            $sentencia->bindColumn(6, $this->activado);
            $sentencia->fetch();    
        }

        public function getId():int
        {
            return $this->idUsu;
        }

        public function getUsuario():string
        {
            return $this->usuario;
        }

        public function getContraseña():string
        {
            return $this->contraseña;
        }

        public function getTipo()
        {
            return $this->tipo;
        }

        public function getFoto():string
        {
            return $this->foto;
        }

        public function getActivado()
        {
            return $this->activado;
        }

        public function listaDeUsuarios() // devuelve un arreglo con todos los usuarios activos
        {
            $consulta = 'SELECT usuario, foto, tipo, id_usuario FROM usuario WHERE activado = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $activado = 'S';
            $sentencia->bindParam(1, $activado);
            $sentencia->execute();
            $resultados = $sentencia->fetchAll(PDO::FETCH_OBJ);
            
            if (!empty($resultados)) {
                return $resultados;    
            } else {
                echo 'No hay resultados';
            }
        }

        public function moverFoto(string $usuario, $foto):string // renombra a la foto proveniente del formulario, con el nombre de usuario, la mueve a la carpeta 'img/usuarios' y devuelve el nombre de la foto para ser guardada en la BD
        {
            if (!empty($foto['foto']['size'])) {
                $tipoDeArchivo = $foto['foto']['type'];
                if ($tipoDeArchivo == 'image/jpeg' || $tipoDeArchivo == 'image/jpg' || $tipoDeArchivo == 'image/png' || $tipoDeArchivo == 'image/  avif' || $tipoDeArchivo == 'image/webp') {
                    $nombreFoto = $foto['foto']['name'];
                    $ext = explode('.', $nombreFoto);
                    $cant = count($ext) - 1;
                    $nombreFoto = $usuario . '.' . $ext[$cant]; 
                    $origen = $foto['foto']['tmp_name'];
                    $destino =  'publico/img/usuarios/' . $nombreFoto;
                    $envio = move_uploaded_file($origen, $destino);
                } else {
                    $nombreFoto = '';
                }
            } else {
                $nombreFoto = '';
            }
            
            return $nombreFoto;
        }

        public function registrarUsuario(string $usuario, string $contraseña, string $tipo, $foto):bool // metodo para registrar un usuario en la BD
        {
            $nombreFoto = $this->moverFoto($usuario, $foto); // mueve la foto y le asigna el nombre para ser guardada en la BD

            $contraseña = sha1($contraseña);
            $confirmacion = false;
            $consulta = 'INSERT INTO usuario(usuario, pass, tipo, foto) VALUE (?, ?, ?, ?)';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $usuario);
            $sentencia->bindParam(2, $contraseña);
            $sentencia->bindParam(3, $tipo);
            $sentencia->bindParam(4, $nombreFoto);
            $confirmacion = $sentencia->execute();

            return $confirmacion;
        }

        public function setUsuario(int $id) // recibiendo un id, obtiene el usuario al que pertenece dicho identificador en la BD y lo asigna a la propiedad '$usuario'
       {
            $consulta = 'SELECT usuario FROM usuario WHERE id_usuario = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $id);
            $sentencia->setFetchMode(PDO::FETCH_BOUND);
            $sentencia->execute();
            $sentencia->bindColumn(1, $this->usuario);
            $sentencia->fetch();
       }

       public function guardarTipo(string $usuario)
       {
            $consulta = 'SELECT tipo FROM usuario WHERE usuario = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $usuario);
            $sentencia->setFetchMode(PDO::FETCH_BOUND);
            $sentencia->execute();
            $sentencia->bindColumn(1, $this->tipo);
            $sentencia->fetch();
       }

        public function eliminarUsuario(int $id):bool // recibiendo un id, elimina de la base de datos al usuario coincidiente con dicho id
        {
            $confirmacion = false;
            $consulta = 'DELETE FROM usuario WHERE id_usuario = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $id);
            $confirmacion = $sentencia->execute();

            return $confirmacion;
        }

        public function desactivarUsuario(int $id):bool
        {
            $confirmacion = false;
            $desactivar = 'N';
            $consulta = 'UPDATE usuario SET activado = ? WHERE id_usuario = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $desactivar);
            $sentencia->bindParam(2, $id);
            $confirmacion = $sentencia->execute();

            return $confirmacion;
        }

        public function actualizarDatos(string $usuario, string $contraseña, string $tipo, $foto, int $id, string $nombreFotoAnt):bool
        {   
            $nombreFoto = $this->moverFoto($usuario, $foto);

            if (($nombreFoto == '' && $nombreFotoAnt != '') || ($nombreFotoAnt != '' && $nombreFoto != $nombreFotoAnt)) {
                unlink('publico/img/usuarios/' . $nombreFotoAnt);
            } 

            $confirmacion = false;
            $consulta = 'UPDATE usuario SET usuario = ?, pass = ?, tipo = ?, foto = ? WHERE id_usuario = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $usuario);
            $contraseña = sha1($contraseña);
            $sentencia->bindParam(2, $contraseña);
            $sentencia->bindParam(3, $tipo);
            $sentencia->bindParam(4, $nombreFoto);
            $sentencia->bindParam(5, $id);
            $confirmacion = $sentencia->execute();

            return $confirmacion;
        }

    } // fin de la clase Usuario
?>