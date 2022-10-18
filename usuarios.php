<?php session_start();
$userType = $_SESSION["userType"];
include './includes/header.php';
include './includes/menu.php';
if ($userType != 'admin') {
    echo '<script type="text/javascript">onload=window.location="visitas.php";</script>';
}
?>

<div class="container">
    <div class="row">
        <div class="col-6 col-md-4 col-lg-2">
            <div class="mb-3 d-grid ">
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalAgreUsuario">Agregar usuario</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Telefono</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="tblUsuarios">

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal agregar usuario -->
<div class="modal fade" id="modalAgreUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formAgregarUser">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" placeholder="Apellido">
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Telefono</label>
                                <input type="text" class="form-control" id="telefono" placeholder="Telefono">
                            </div>
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" placeholder="Usuario">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="text" class="form-control" id="password" placeholder="Contraseña">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12 text-center alert" id="msjAgreUsuario">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregarUsuario">Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar usuario -->
<div class="modal fade" id="modalEditUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="nombreEdit" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreEdit" placeholder="Nombre">
                        </div>
                        <div class="mb-3">
                            <label for="apellidoEdit" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellidoEdit" placeholder="Apellido">
                        </div>
                        <div class="mb-3">
                            <label for="telefonoEdit" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefonoEdit" placeholder="Telefono">
                        </div>
                        <div class="mb-3">
                            <label for="usuarioEdit" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuarioEdit" placeholder="Usuario">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center alert" id="msjEditUsuario">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="editarUsuario">Editar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar contraseña -->
<div class="modal fade" id="modalEditPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar contraseña</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCambioPassword" action="">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="passwordEdit" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="passwordEdit">
                            </div>
                            <div class="mb-3">
                                <label for="passwordEditConfir" class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" id="passwordEditConfir">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center alert" id="msjEditPassword">

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="editarPassword">Editar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const idUser = '<?php echo $_SESSION['idUser']; ?>';
    const userType = '<?php echo $userType;  ?>';
</script>
<script src="./assets/js/codigo.js"></script>
<script src="./assets/js/usuario.js?codigo?idUser?userType"></script>