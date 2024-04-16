<?php require_once('vistas/encabezado.php');?>
<main class="container-fluid">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php require_once('vistas/menu.php') ?>
        </section>
        <article class="col-9">
            <article class="row p-2">
                <section class="menu_tmp">
                    <a class="btn btn-success" href="?c=Usuario&a=altaUsuario">+ Alta usuario</a>
                </section>
                <table class="table table-bordered table-hover table-striped w-auto align-middle">
                    <caption class="caption-top text-center bg-warning text-black">Listado de usuarios</caption>
                    <tr>
                        <th class="bg-secondary text-white">Foto</th>
                        <th class="bg-secondary text-white">Usuario</th>
                        <th class="bg-secondary text-white">Tipo</th>
                        <th class="bg-secondary text-white ">Modificar</th>
                        <th class="bg-secondary text-white">Eliminar</th>
                        <th class="bg-secondary text-white">Desactivar</th>
                    </tr>
                    <tr>
                    <?php
                        foreach ($this->modelo->listaDeUsuarios() as $resultado) {
                            if ($resultado->foto == '') {
                                $resultado->foto = 'usuario_default.png';
                            }      
                    ?>
                    <td><img src="publico/img/usuarios/<?php echo $resultado->foto;?>"></td>
                    <td> <?php echo $resultado->usuario; ?> </td>
                    <td> <?php echo $resultado->tipo; ?> </td>
                    <td class="align-middle" ><a href="?c=Usuario&a=modificarUsuario&id=<?php echo $resultado->id_usuario ?> "><img src="publico/img/iconos/modificar.png"></a></td>
                    <td class="align-middle"><a href="?c=Usuario&a=eliminarUsuario&id=<?php echo $resultado->id_usuario ?> "><img src="publico/img/iconos/eliminar.png"></a></td>
                    <td class="align-middle"><a href="?c=Usuario&a=desactivarUsuario&id=<?php echo $resultado->id_usuario ?>"><img src="publico/img/iconos/desactivar.png"></a></td>
                    </tr>
                    <?php }?>
                </table>
            </article>
        </article>
    </section>
</main>
<?php require_once('vistas/pie.php'); ?>