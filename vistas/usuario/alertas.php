<?php require_once('vistas/encabezado.php');?>
<main class="container-fluid">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php require_once('vistas/menu.php'); ?>
        </section>
        <article class="col-9 d-flex justify-content-center">
            <section class="align-self-center border border-primary border-2 rounded-4 pb-2 <?php echo $colorFondo;?>">
                <p class="text-center text-white text-4 p-4"><?php echo $respuesta;?> </p>
            </section>
        </article>
    </section>
</main>

<?php
    require_once('vistas/pie.php');
?>