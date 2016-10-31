<?php
require_once 'includes/database.inc.php';

$dsn = 'mysql:dbname=db_fecolsa;host=127.0.0.1';
$user = 'root';
$password = '';

try {
    $connection = new PDO($dsn, $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->exec("set names utf8");
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
}

if (isset($_REQUEST['v_conductorx'])) :
    $set['v_conductorx'] = $_REQUEST['v_conductorx'];
    $set['v_placaxxxxx'] = $_REQUEST['v_placaxxxxx'];
    $set['v_telefconta'] = $_REQUEST['v_telefconta'];
    $set['v_fechaasign'] = date('Y-m-d H:i:s');
        
    $where['n_reservaxxx'] = $_REQUEST['reserva'];

    db_update($connection, 'td_usuargrupo', $set, $where, false);
endif;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TechAmbits - Fecolsa - Asignar</title>
        <link rel="icon" type="image/png" href="public/images/logos/favicon.png" />
        <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="public/css/jumbotron-narrow.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <script src="public/jquery/js/jquery-3.1.1.min.js"></script>
        <script src="public/bootstrap/js/bootstrap.min.js"></script>
        <script src="public/js/fecolsa.js"></script>
    </head>

    <body onload="$('#v_conductorx').focus()">

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
                
                <?php 
                if (isset($_REQUEST['v_conductorx'])) {
                    ?>
                    <div class="success left">
                        <span class="glyphicon glyphicon-ok"></span>
                        &nbsp;&nbsp;
                        La Asignación de Vehiculo para la Reserva No. <b><?php echo $_REQUEST['reserva'] ?></b> se ha efectuado con éxito.
                        <br><br>
                        <p>
                            <b>Conductor:</b> <?php echo $_REQUEST['v_conductorx'] ?>
                        </p>
                        <p>
                            <b>Placa No:</b> <?php echo $_REQUEST['v_placaxxxxx'] ?>
                        </p>
                        <p>
                            <b>Teléfono de Contácto:</b> <?php echo $_REQUEST['v_telefconta'] ?>
                        </p>
                        <p>
                            <b>Fecha de Asignación:</b> <?php echo date('Y-m-d H:i:s') ?>
                        </p>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="col-md-6 center">
                        <div class="datos left">
                            <h4>RESERVA NO. <?php echo $_REQUEST['reserva'] ?></h4>

                            <?php
                                $sql = "SELECT a.*, b.*, 
                                               CONCAT(c.v_usuarnombr, ' ', c.v_usuarapell) AS v_lidernombr
                                          FROM td_usuargrupo a INNER JOIN 
                                               tm_usuariosxx b ON a.s_usuaramigo = b.s_usuarioxxx INNER JOIN 
                                               tm_usuariosxx c ON a.s_usuarlider = c.s_usuarioxxx
                                         WHERE b.i_usuartipox = 'A' 
                                           AND a.n_reservaxxx = '" . $_REQUEST['reserva'] . "'";
                                $rows = db_get_rows($connection, $sql, null, true);
                                $lengthRows = count($rows);
                            ?>
                            <hr>
                            <div>
                                <b>Dirección de Recogida:</b> <?php echo $rows[0]['v_direcrecog'] ?> 
                            </div>
                            <div>
                                <b>Fecha de Recogida:</b> <?php echo $rows[0]['v_fecharecog'] ?> 
                            </div>
                            <div>
                                <b>Destino Final:</b> <?php echo $rows[0]['v_destifinal'] ?> 
                            </div>
                            <hr>

                            <div>
                                &nbsp;&nbsp;<b>1</b>.&nbsp;&nbsp;
                                <span class="glyphicon glyphicon-user" style="cursor:pointer;"></span>&nbsp;&nbsp;
                                <?php echo $rows[0]['v_lidernombr'] ?> - <b>Líder del Grupo</b>
                            </div>

                            <?php
                            for ($a = 0; $a < $lengthRows; $a++) :
                                $title = null;
                                $title .= 'Nombre: ' . $rows[$a]['v_usuarnombr'] . ' ' . $rows[$a]['v_usuarapell'] . "\n";
                                $title .= 'Cédula: ' . $rows[$a]['v_usuarcedul'] . "\n";
                                $title .= 'Cargo: ' . $rows[$a]['v_usuarcargo'] . "\n";
                                $title .= 'E-mail: ' . $rows[$a]['v_usuaremail'] . "\n";
                                $title .= 'Dirección: ' . $rows[$a]['v_usuardirec'] . "\n";
                                $title .= 'Hora: ' . $rows[$a]['v_usuarhorar'] . "\n";
                                $title .= 'Celular: ' . $rows[$a]['v_usuarcelul'];
                                ?>
                                <div class="item">
                                    <b><?php echo (($a + 2) < 10 ? '&nbsp;&nbsp;' : null) . ($a + 2) ?></b>.&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-user" style="cursor:pointer;" title="<?php echo $title ?>"></span>&nbsp;&nbsp;
                                    <?php echo $rows[$a]['v_usuarnombr'] . ' ' . $rows[$a]['v_usuarapell'] ?>
                                </div>
                                <?php
                            endfor;
                            ?>
                            <br>
                            <div class="center">
                                <button type="button" class="btn btn-default" onclick="history.back()">Volver a Reservas</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 center">
                        <div class="datos left">
                            <h4>ASIGNACIÓN DE VEHÍCULO</h4>
                            <hr>

                            <form class="form-horizontal" method="post" action="asignar.php" id="formAsignar" onkeypress="return checkSubmit(event, this)">
                                <input type="hidden" name="v_usuarclave" id="v_usuarclave">
                                <div class="form-group">
                                    <label for="v_conductorx" class="col-sm-4 control-label">Conductor:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="v_conductorx" id="v_conductorx" maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="v_placaxxxxx" class="col-sm-4 control-label">Placa:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="v_placaxxxxx" id="v_placaxxxxx" maxlength="6">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="v_telefconta" class="col-sm-4 control-label">Tel. Contacto:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="v_telefconta" id="v_telefconta" onkeypress="return isNumeric(event)" maxlength="10">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <button type="button" class="btn btn-default" onclick="submitAsignar()">Asignar</button>
                                        <input type="hidden" name="reserva" id="reserva" value="<?php echo $_REQUEST['reserva'] ?>" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                }
                ?>
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



