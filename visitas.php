<?php session_start();
$userType = $_SESSION["userType"];
include './includes/header.php';
include './includes/menu.php';
if (empty($_SESSION)) {
    echo '<script type="text/javascript">onload=window.location="index.php";</script>';
}
?>

<div class="container">
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 align-items-end">
        <div class="col" id="contShowAgreVisita">
            <div class="mb-3 d-grid ">
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalAgreVisita">Agregar visita</button>
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="filtroFecha1Visitas" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control filtroVisitas" id="filtroFecha1Visitas">
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="filtroFecha2Visitas" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control filtroVisitas" id="filtroFecha2Visitas">
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="filtroUsuarioVisitas" class="form-label">Usuario</label>
                <select name="" class="form-select filtroVisitas" id="filtroUsuarioVisitas"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Tienda</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="tblVisitas">

                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <nav aria-label="Page navigation" id="paginationVisitas">

            </nav>
        </div>
    </div>
</div>

<!-- Modal agregar visita-->
<div class="modal fade" id="modalAgreVisita" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Agregar visita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="tiendaVisita" class="form-label">Tienda</label>
                            <input type="text" class="form-control" id="tiendaVisita" placeholder="Tienda">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center alert" id="msjAgreVisita">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="agregarVisita" class="btn btn-primary">Agregar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal ubicacion-->
<div class="modal fade" id="modalUbicacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="ratio ratio-16x9">
                            <iframe id="iframeUbicacion" src="" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const idUser = '<?php echo $_SESSION['idUser']; ?>';
    const userType = '<?php echo $userType;  ?>';
</script>
<script src="./assets/js/codigo.js"></script>
<script src="./assets/js/visitas.js?codigo?idUser?userType"></script>