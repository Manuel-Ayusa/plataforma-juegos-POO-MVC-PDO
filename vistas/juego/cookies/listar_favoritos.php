<?php require('vistas/encabezado.php');?>
<main class="container-fluid">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php require_once('vistas/menu.php'); ?>
        </section>
        <article class="col-9 listado pt-2">
        <section class="col-9 m-0 p-0"><p class="btn btn-primary float-end "><a href="?c=Juego&a=mostrarCarrito" class="bi bi-cart text-white nav-link">Mi carrito</a></p></section>
                <?php
                    foreach ($this->modelo->mostrarJuegosFav($_SESSION['usuario']) as $resultado) {
                        if ($resultado->portada == '') {
                            $resultado->portada = 'portada_default.png';
                        }        
                ?>
                    <section class="col-5 mt-2 mb-2">
                        <section class="card">
                            <img src="publico/img/portadas/<?php echo $resultado->portada;?>" />
                            
                            <section class="card-content p-3">
                                <h4 class="card-title text-center"><?php echo $resultado->titulo; //muestra el titulo ?></h4>
                                <p class="">Jugadores: <?php echo $resultado->jugadores;//muestra los jugadores ?></p>
                                <p class="">Fecha de lanzamiento: <?php echo $resultado->lanzamiento;//muestra la fecha de lanzamiento ?></p>
                                <section>
                                    <p class="btn btn-primary"><?php echo $resultado->genero;//muestra el género ?></p>
                                    <a href="?c=Juego&a=reservarJuego&id=<?php echo $resultado->id_juego;?>" class="bi bi-cart text-white btn btn-success mb-3"></a>
                                </section>
                            </section>
                        </section>
                    </section>
                <?php }?>
        </article>
    </section>
</main>
<?php
    require_once ('vistas/pie.php');
?>