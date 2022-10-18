<?php
include './includes/conecction.php';

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'guardarVisita') {
    $datos = (isset($_REQUEST['datos']) && $_REQUEST['datos'] != NULL) ? json_decode($_REQUEST['datos'], true) : '';
    extract($datos);
    date_default_timezone_set("America/Mexico_City");
    $hora = date('H:i:s');
    $fecha = date('Y-m-d');

    $queryInsert = mysqli_query($con, "INSERT INTO visita (idUser, fecha, hora, tienda, latitud, longitud) VALUES ('$usuario','$fecha','$hora','$tienda','$latitud','$longitud')");

    if ($queryInsert) {
        $array = array('status' => 1, 'msj' => 'Visita agregada');
    } else {
        $array = array('status' => 0, 'Error, intenta más tarde');
    }

    echo json_encode($array);
} elseif ($action == 'getUsuarios') {
    $datos = (isset($_REQUEST['datos']) && $_REQUEST['datos'] != NULL) ? json_decode($_REQUEST['datos'], true) : '';
    extract($datos);
    $sqlUserType = ($userType != '') ? " WHERE ut.userType = '$userType'" : '';
    $queryUsers = mysqli_query($con, "SELECT p.nombre AS nombre, u.idUser, userType, u.idUserType FROM user u INNER JOIN user_type ut ON u.idUserType = ut.idUserType INNER JOIN persona p ON u.idPersona = p.idPersona" . $sqlUserType);

    $usuarios = array();

    while ($r = mysqli_fetch_assoc($queryUsers)) {
        $nombre = $r['nombre'];
        $idUser = $r['idUser'];
        $userType = $r['userType'];
        $idUserType = $r['idUserType'];
        $usuario = array('nombre' => $nombre, 'idUser' => $idUser, 'userType' => $userType, 'idUserType' => $idUserType);
        $usuarios[] = $usuario;
    }

    $array = array('usuarios' => $usuarios);
    echo json_encode($array);
} elseif ($action == 'getVisitas') {
    $datos = (isset($_REQUEST['datos']) && $_REQUEST['datos'] != NULL) ? json_decode($_REQUEST['datos'], true) : '';
    extract($datos);
    include('includes/paginationHp.php');
    $filtros = array();
    ($usuario != '') && $filtros[] = " v.idUser = '$usuario' ";
    ($fecha1 != '' && $fecha2 == '') ? $filtros[] = " v.fecha = '$fecha1' " : (($fecha1 != '' && $fecha2 != '') ? $filtros[] = " fecha BETWEEN '$fecha1' AND '$fecha2'" : ($fecha1 == '' && $fecha2 != '') && $filtros[] = " fecha < '$fecha2'");

    $sql = "SELECT v.idVisita AS idVisita, CONCAT(p.nombre,' ',p.apellido) AS usuario, v.fecha,v.hora, v.tienda FROM visita v 
	INNER JOIN user u ON v.idUser = u.idUser 
	INNER JOIN persona p ON p.idPersona = u.idPersona ";

    foreach ($filtros as $valor => $key) {
        $sql .= ($valor == 0) ? ' WHERE ' . $key : ' AND' . $key;
    }

    $per_page = 8;
    $adjacents  = 4;
    $offset = ($page - 1) * $per_page;
    $reload = 'visitas.php';
    $numrows = mysqli_num_rows(mysqli_query($con, $sql));
    $total_pages = ceil($numrows / $per_page);
    $sql .= " ORDER BY idVisita DESC LIMIT $offset,$per_page";
    $queryVisitas = mysqli_query($con, $sql);

    $total_pages = ceil($numrows / $per_page);
    $tbl = '';
    while ($r = mysqli_fetch_assoc($queryVisitas)) {
        $idVisita = $r['idVisita'];

        $tbl .= "<tr>
                    <td>" . str_pad($idVisita, 5, 0, STR_PAD_LEFT) . "</td>
                    <td>" . $r['usuario'] . "</td>
                    <td>" . $r['fecha'] . "</td>
                    <td>" . $r['hora'] . "</td>
                    <td>" . $r['tienda'] . "</td><td>";

        $tbl .= ($userType == 'admin') ? "<button type='button' onclick ='" . 'visitas.mostrarUbicacion(this)' . "' data-id='" . $idVisita . "' class='btn btn-outline-info verUbicacion'>Ubicación</button>" : '';
        $tbl .=    "</td>
                </tr>";
    }
    $pagination = paginate($reload, $page, $total_pages, $adjacents, $funcion);
    echo json_encode(array("tbl" => $tbl, "pagination" => $pagination,));
} elseif ($action == "getVisita") {
    $datos = (isset($_REQUEST['datos']) && $_REQUEST['datos'] != NULL) ? json_decode($_REQUEST['datos'], true) : '';
    extract($datos);

    $queryVisita = mysqli_query($con, "SELECT v.tienda, v.latitud,v.longitud, p.nombre AS usuario, v.fecha FROM visita v INNER JOIN user u ON v.idUser = u.idUser 
    INNER JOIN persona p ON u.idPersona = p.idPersona WHERE v.idVisita = '$idVisita'");

    echo json_encode(mysqli_fetch_assoc($queryVisita));
}
