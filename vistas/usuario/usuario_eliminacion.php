<?php require_once('vistas/encabezado.php');?> <!-- encabezado -->
<main class="container-fluid">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php require_once('vistas/menu.php') ?>
        </section>
    <article class="col-9 text-center d-flex justify-content-center">
        <section class="align-self-center border border-primary border-2 rounded-4 pb-2 bg-white">
            <h2 class="bg-danger p-3 rounded-top-3"><b>Eliminar Usuario</b></h2>
            <p class="p-3">¿Esta seguro/a que quiere eliminar el/la usuario/a <b><?php echo $this->modelo->getUsuario();?></b>?</p>
            <a class="btn btn-success m-2" href="?c=Usuario&a=eliminarUsuarioOk&id=<?php echo $id ?>">Eliminar</a>
            <a class="btn btn-danger m-2" href="?c=Usuario&a=mostrarInfoUsuarios">Cancelar</a>
        </section>
    </article>
</main>
<?php require_once ('vistas/pie.php');?> <!-- pie -->