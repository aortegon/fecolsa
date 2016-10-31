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

/*
echo '<pre>';
print_r($_REQUEST);
echo '</pre>';
*/

if (isset($_REQUEST['v_direcrecog'])) :
    
    $sql = "SELECT MAX(a.n_reservaxxx) AS reserva 
              FROM td_usuargrupo a 
             WHERE a.s_usuarlider = '" . $_REQUEST['s_usuarlider'] . "' ";
    $record = db_get_rows($connection, $sql);
    $reserva = (int) $record['reserva'] + 1;
    
    $set['v_direcrecog'] = $_REQUEST['v_direcrecog'];
    $set['v_fecharecog'] = $_REQUEST['v_fecharecog'];
    $set['v_destifinal'] = $_REQUEST['v_destifinal'];
    $set['n_reservaxxx'] = $reserva;
    $set['v_fechareser'] = date('Y-m-d H:i:s');
        
    $where['s_usuarlider'] = $_REQUEST['s_usuarlider'];
    $where['n_reservaxxx'] = '0';

    db_update($connection, 'td_usuargrupo', $set, $where, false);
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
                <!--
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <li role="presentation" class="active"><a href="#">Home</a></li>
                        <li role="presentation"><a href="#">About</a></li>
                        <li role="presentation"><a href="#">Contact</a></li>
                    </ul>
                </nav>
                -->
                <!--
                <h3 class="text-muted">Project name</h3>
                -->
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
                        La Reserva No. <b><?php echo $set['n_reservaxxx'] ?></b> se ha registrado con éxito.
                        <br><br>
                        El grupo relacionado consta de los siguientes integrantes:
                        
                        
                        <div>
                            &nbsp;&nbsp;<b>1</b>.&nbsp;&nbsp;
                            <span class="glyphicon glyphicon-user" style="cursor:pointer;"></span>&nbsp;&nbsp;
                            <?php echo $_REQUEST['v_usuarlider'] ?> - <b>Líder del Grupo</b>
                        </div>

                        <?php

                        $sql = "SELECT b.* 
                                  FROM td_usuargrupo a INNER JOIN 
                                       tm_usuariosxx b ON a.s_usuaramigo = b.s_usuarioxxx 
                                 WHERE b.i_usuartipox = 'A' 
                                   AND a.s_usuarlider = '" . $_REQUEST['s_usuarlider'] . "' 
                                   AND a.n_reservaxxx = '" . $record['reserva'] . "'";
                        $rows = db_get_rows($connection, $sql, null, true);
                        $lengthRows = count($rows);

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

                        $disabled = $lengthRows >= 12 && $lengthRows <= 18 ? null : 'disabled="disabled"';
                        ?>
                    </div>
                    <br>
                    <form method="post" action="dashboard.php">
                        <button type="button" class="btn btn-default" onclick="goToHome()">Generar otra Reserva</button>
                        <input type="hidden" name="email" value="<?php echo $_REQUEST['email'] ?>">
                        <input type="hidden" name="password" value="<?php echo $_REQUEST['password'] ?>">
                    </form>
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



