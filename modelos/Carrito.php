<?php

class Carrito {

    private $conexion;

    public function __construct()
    {
        $this->conexion = BaseDeDatos::conectar();
    }

    public function crearCarrito() 
    {
        $consulta = 'INSERT INTO carrito(usuario_id) VALUE (?)';
        $sentencia = $this->conexion->prepare($consulta);
        $sentencia->bindParam(1, $_SESSION['id_usuario']); 
        $sentencia->execute();
    }

    public function añadirAlCarrito(int $id_juego)
    {
        $consulta = 'SELECT id_carrito FROM carrito WHERE usuario_id = ?';
        $sentencia = $this->conexion->prepare($consulta);
        $sentencia->bindParam(1, $_SESSION['id_usuario']);
        $sentencia->bindColumn(1, $id_carrito);
        $sentencia->execute();
        $sentencia->fetch(); 

        if (empty($id_carrito)) {
            Carrito::crearCarrito();
            $consulta = 'SELECT id_carrito FROM carrito WHERE usuario_id = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $_SESSION['id_usuario']);  
            $sentencia->bindColumn(1, $id_carrito);
            $sentencia->execute();
            $sentencia->fetch(); 
        } else {
            $consulta = 'SELECT cantidad, carrito.id_carrito FROM carrito_producto 
                        INNER JOIN carrito ON carrito_producto.carrito_id = carrito.id_carrito  
                        WHERE juego_id = ? AND carrito.usuario_id = ?';
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $id_juego);
            $sentencia->bindParam(2, $_SESSION['id_usuario']);
            $sentencia->bindColumn(1, $cantidad);
            $sentencia->bindColumn(2, $id_carrito);
            $sentencia->execute();
            $sentencia->fetch();
        }

        

        $consulta = 'INSERT INTO carrito_producto(juego_id, carrito_id, cantidad) VALUE (?, ?, ?)';
        $consulta2 = 'UPDATE carrito_producto SET cantidad = ? 
                    WHERE juego_id = ? AND carrito_id = ?';
        if (!empty($cantidad)) {
            $cantidad += 1;
            $sentencia = $this->conexion->prepare($consulta2);
            $sentencia->bindParam(1, $cantidad); 
            $sentencia->bindParam(2, $id_juego);
            $sentencia->bindParam(3, $id_carrito); 
        } else {
            $cantidad = 1;
            $sentencia = $this->conexion->prepare($consulta);
            $sentencia->bindParam(1, $id_juego); 
            $sentencia->bindParam(2, $id_carrito);
            $sentencia->bindParam(3, $cantidad);
        }

        $sentencia->execute();
    }

    public function productos()
    {
        $consulta = 'SELECT titulo, jugadores, lanzamiento, portada, genero, cantidad FROM juego 
                    INNER JOIN carrito_producto ON juego.id_juego = carrito_producto.juego_id 
                    INNER JOIN carrito ON carrito.id_carrito = carrito_producto.carrito_id
                    INNER JOIN genero ON juego.genero_id = genero.id_genero
                    WHERE carrito.usuario_id = ?';
        $sentencia = $this->conexion->prepare($consulta);
        $sentencia->bindParam(1, $_SESSION['id_usuario']);  
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);

        return $resultado;
    }

}

?>