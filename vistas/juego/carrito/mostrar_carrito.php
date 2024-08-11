<?php require('vistas/encabezado.php');?>
<main class="container-fluid">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php require_once('vistas/menu.php'); ?>
        </section>
        <article class="col-9 listado pt-2 d-block p-1">
            <h3 class="mt-4 bg-warning text-center p-2">Su carrito contiene: </h3>
            <table class="table table-bordered table-hover table-striped table-info mt-5 align-middle"style="margin: 0 auto">
                <tr><th>Titulo</th><th>Portada</th><th>Genero</th><th>Jugadores</th><th>Cantidad</th>
                <?php 
                    foreach ($this->modelo->productos() as $juego) {
                        if ($juego->portada == '') {
                            $juego->portada = 'portada_default.png';
                        }
                ?>
                <tr><td class="col1"><?php echo $juego->titulo;?></td>
                <td><img class="" src="publico/img/portadas/<?php echo $juego->portada;?>"></td>
                <td class="col1"><?php echo $juego->genero;?></td>
                <td class="col1"><?php echo $juego->jugadores;?></td>
                <td class="col1"><?php echo $cantidad;?></td>
                <?php }?>
            </table>
        </article>
    </section>
</main>

<?php
    require_once ('vistas/pie.php');
?>