<?php require_once('vistas/encabezado.php');?>
<main class="container-fluid">
    <article class="pt-5 h-100 row justify-content-center align-items-center">
        <section class="row d-flex justify-content-center align-items-center h-100 col-10 ">
            <form action="?c=Usuario&a=loguear" method="post" class="col-md-8 col-lg-6 col-xl-5">
                <fieldset class="card bg-dark text-white" style="border-radius: 1rem;">
                    <section class="card-body p-5 text-center">
                        <h2 class="fw-bold mb-2">INICIAR SESIÓN</h2>
                        <p class="text-white-50 mb-5">Ingrese su mail y contraseña</p>

                        <section class="form-outline form-white mb-4">
                            <input type="text" id="user" name="usuario" required class="form-control form-control-lg <?php echo $class;?>" />
                            <label class="form-label" for="user">Usuario</label>
                        </section>

                        <section class="form-outline form-white mb-4">
                            <input type="password" id="pass" name="pass" required class="form-control form-control-lg <?php echo $class;?>" />
                            <label class="form-label" for="pass">Contraseña</label>
                        </section>
                        <section id="sec" class="bg-black rounded-3">
                            <p id="<?php echo $msj;?>" class="text-danger"></p>
                        </section>
                        <button class="btn btn-outline-light btn-lg btn-success px-5" type="submit">Login</button>
                    </section>
                </fieldset>
            </form>
        </section>
    </article>
</main>
<?php
    require("vistas/pie.php");
?>