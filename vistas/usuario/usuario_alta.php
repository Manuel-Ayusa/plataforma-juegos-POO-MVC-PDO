<?php require_once('vistas/encabezado.php');?>
<main class="container-fluid">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php require_once('vistas/menu.php'); ?>
        </section>
        <article class="col-9 p-0 d-flex">
            <form action="?c=Usuario&a=altaUsuarioOk" method="post" enctype="multipart/form-data" class="col-7 align-self-center text-white bg-primary">
                <legend class="bg-warning border-info text-black text-center">Alta usuario</legend>     
                <section>
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario" required maxlength="45" class="form-control border-black">
                    <label for="pass" class="form-label">Contraseña</label>
                    <input type="password" name="pass" id="pass" placeholder="Contraseña" required maxlength="45" class="form-control border-black">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select border-black">
                        <option value="Administrador">Administrador</option>
                        <option value="Común">Común</option>
                    </select>
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto"  class="form-control border-black">
                    <section class="text-center">
                        <input type="submit" name="enviar" value="Confirmar" class="btn btn-success mt-3 mb-3 border-white">
                    </section>
                </section>
            </form>
        </article>
    </section>
</main>

<?php
    require_once('vistas/pie.php');
?>