<?php require('vistas/encabezado.php');?>
<main class="container-fluid">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php
                require_once('vistas/menu.php');
            ?>
        </section>
        <article class="col-9 p-0">
            <h2 class="bg-warning text-center p-2 m-0 border-top border-black mt-2">Actualizar Juego</h2>
            <form action="?c=Juego&a=modificarJuegoOk" method="post" enctype="multipart/form-data" class="text-white bg-primary w-50 p-3">
                <section class="pt-2">
                    <label for="tit" class="form-label">Titulo:</label>
                    <input type="text" name="titulo" id="tit" class="form-control" value = "<?php echo $resultados->titulo;?>">
                </section>
                <section class="pt-2">
                    <label for="jug" class="form-label">Jugadores:</label>
                    <input type="number" name="jugadores" id="jug" class="form-control" value = "<?php echo $resultados->jugadores;?>">
                </section>
                <section class="pt-2">
                    <label for="fec" class="form-label">Lanzamiento:</label>
                    <input type="date" name="lanzamiento" id="fec" class="form-control" value = "<?php echo $resultados->lanzamiento;?>">
                </section>
                <section class="pt-2">
                    <label for="gen" class="form-label" class="form-label">Genero</label>
                    <select name="genero" id="gen" class="form-control">
                        <option value="<?php echo $resultados->genero_id ?>" selected><?php echo $resultados->genero ?></option>
                        <option value="1">Rol</option>
                        <option value="2">Survival</option>
                        <option value="3">Estrategia</option>
                        <option value="4">Deporte</option>
                    </select>
                </section>
                <section class="pt-2">
                    <label for="port" class="form-label">Portada:</label>
                    <input type='hidden' name= 'MAX_FILE_SIZE' value= '6300000'>
                    <input type="file" name="portada" id="port" accept="image/*" class="form-control" required>
                </section>
                <input type="hidden" name="id" value="<?php echo $resultados->id_juego; ?>" id="id">
                <input type="hidden" name="nombFotoAnt" value="<?php echo $resultados->portada; ?>" id="ft">
                <section class="text-center pt-2 pb-2">
                    <input type="submit" value="Guardar" class="btn btn-success">
                </section>
            </form>
        </article>
    </section>         
</main>
<?php require_once ('vistas/pie.php');?>