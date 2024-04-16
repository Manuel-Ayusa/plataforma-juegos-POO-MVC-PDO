<?php require_once('vistas/encabezado.php');?>
<main class="container-fluid">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php require_once('vistas/menu.php') ?>
        </section>
    <article class="col-9 text-center">
        <a class="btn btn-danger mt-3" href="?c=Usuario&a=mostrarInfoUsuarios">Cancelar</a>
        <form action="?c=Usuario&a=modificarUsuarioOk" method="post" enctype="multipart/form-data" class="col-7 align-self-center text-white bg-primary mt-4">
                <legend class="bg-warning border-info text-black text-center">Modificar Usuario</legend>     
                <section>
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="usuario" value="<?php echo $this->modelo->getUsuario(); ?>" id="usuario" placeholder="Usuario" required maxlength="45" class="form-control border-warning">
                    <label for="pass" class="form-label">Contraseña</label>
                    <input type="password" name="pass" id="pass" placeholder="Contraseña" required maxlength="45" class="form-control border-warning">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select border-warning">
                        <option value="<?php echo $this->modelo->getTipo(); ?>" selected disabled><?php echo $this->modelo->getTipo(); ?>(actual)</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Común">Común</option>
                    </select>
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto"  class="form-control border-warning">
                    <input type="hidden" name="id" value="<?php echo $this->modelo->getId(); ?>" id="id">
                    <input type="hidden" name="nombFotoAnt" value="<?php echo $this->modelo->getFoto(); ?>" id="ft">
                    <section class="text-center">
                        <input type="submit" name="enviar" value="Confirmar" class="btn btn-dark mt-3 mb-3">
                    </section>
                </section>
            </form>
    </article>
</main>
<?php
    require_once ('vistas/pie.php');
?>