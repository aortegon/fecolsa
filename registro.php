<?php

require_once 'includes/database.inc.php';

$dsn = 'mysql:dbname=db_fecolsa;host=127.0.0.1';
$user = 'root';
$password = '_WillyRomer@_2@16_';

try {
    $connection = new PDO($dsn, $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->exec("set names utf8");
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
}

if (isset($_REQUEST['v_usuarnombr']) && !db_find($connection, 'tm_usuariosxx', 'v_usuarcedul', $_REQUEST['v_usuarcedul'])) :
    $data['v_usuarnombr'] = $_REQUEST['v_usuarnombr'];
    $data['v_usuarapell'] = $_REQUEST['v_usuarapell'];
    $data['v_usuarcedul'] = $_REQUEST['v_usuarcedul'];
    $data['v_usuarcargo'] = $_REQUEST['v_usuarcargo'];
    $data['v_usuaremail'] = $_REQUEST['v_usuaremail'];
    $data['v_usuarclave'] = $_REQUEST['v_usuarclave'];
    $data['v_usuardirec'] = $_REQUEST['v_usuardirec'];
    $data['v_usuarhorar'] = $_REQUEST['v_usuarhorar'];
    $data['v_usuarcelul'] = $_REQUEST['v_usuarcelul'];
    $data['i_usuartipox'] = 'L';

    db_insert($connection, 'tm_usuariosxx', $data);
endif;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TechAmbits - Fecolsa - Registro</title>
        <link rel="icon" type="image/png" href="public/images/logos/favicon.png" />
        <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="public/css/jumbotron-narrow.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <script src="public/jquery/js/jquery-3.1.1.min.js"></script>
        <script src="public/bootstrap/js/bootstrap.min.js"></script>
        <script src="public/js/fecolsa.js"></script>
    </head>

    <body>

        <div class="container">
            <div class="header clearfix">
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <li role="presentation"><a href="#" onclick="goToHome()">Salida Segura</a></li>
                    </ul>
                </nav>
                <img src="public/images/logos/logo_fecolsa.png" height="45">
                &nbsp;&nbsp;&nbsp;
                <img src="public/images/logos/logo_sival.png" height="45">
                &nbsp;&nbsp;&nbsp;
                <img src="public/images/logos/logo_set.png" height="45">
            </div>

            <!--
            <div class="jumbotron">
                <h1>Jumbotron heading</h1>
                <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                <p><a class="btn btn-lg btn-success" href="#" role="button">Sign up today</a></p>
            </div>
            -->

            <div class="row marketing">
                <div class="col-md-12 center">
                    <div class="success left">
                        <span class="glyphicon glyphicon-ok"></span>
                        &nbsp;&nbsp;
                        El líder de Grupo <b><?php echo ucwords($_REQUEST['v_usuarnombr'] . ' ' . $_REQUEST['v_usuarapell']) ?></b> se ha registado con éxito.
                        <br>
                        Revisa tu correo <b><?php echo $_REQUEST['v_usuaremail'] ?></b> para conocer tu clave de acceso. En caso de no encontrar el correo revisa en la bandeja de correo no deseado.
                    </div>
                    <br>
                    <button type="button" class="btn btn-default" onclick="goToHome()">Autentícate</button>
                </div>
            </div>
            
            <footer class="footer center" style="font-size:12px;">
                <p>Desarrollado por <a href="https://www.techambits.com" target="_blank">TechAmbits</a> &copy; <?php echo date('Y') ?> Todos los Derechos Reservados.</p>
                <p>Costo del servicio por pasajero de ida y regreso: <b>$20.000</b></p>
                <p>Email para información sobre la plataforma: <a href="mailto:comercial1@sival.com.co">comercial1@sival.com.co</a></p>
                <p>Email para información sobre los móviles: <a href="mailto:coordinacion@sival.com.co">coordinacion@sival.com.co</a></p>
                <p>Celular para información sobre la plataforma: +57 (317) 348-2661, +57 (320) 288-9729</p>
                <p>Celular para información sobre los móviles: +57 (316) 342-7013</p>
            </footer>

        </div> <!-- /container -->
    </body>

</html>



