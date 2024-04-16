<?php require('vistas/encabezado.php');?>
<main class="container-fluid">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php require('vistas/menu.php'); ?>
        </section>
        <article class="col-9 listado pt-2 d-block p-0">
            <h2 class="text-center mt-4 bg-warning p-3">Preferencias</h2>
                <form action="?c=Juego&a=gardarCookie" class="col-5 mt-5 mb-2 p-2 bg-light border" method="post" >
                    <legend class="text-center bg-danger p-2">Género favorito</legend>
                    <label class="form-label mt-3" for="pref">Elija el género:</label>
                    <select class="form-select" name="preferencia" id="pref">
                        <?php
                            foreach ($this->modelo->obtenerGeneros() as $resul) {
                        ?>
                        <option value="<?php echo $resul->genero;?>"><?php echo $resul->genero;?></option>
                        <?php }?>
                        <!-- etiquetas option a mano o bucle recorriendo los resultados de la consulta -->
                    </select>
                    <section class="text-center">
                        <input type="submit" value="Guardar" class="btn btn-success mt-3 mb-3">
                    </section>
                </form>
        </article>
    </section>
</main>

<?php require_once('vistas/pie.php');?>