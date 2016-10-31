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

$sql = "SELECT * FROM tm_usuariosxx 
        WHERE v_usuaremail = '" . $_REQUEST['email'] . "' 
          AND v_usuarclave = '" . $_REQUEST['password'] . "'";
$datos = db_get_rows($connection, $sql);

/*
echo '<pre>';
print_r($datos);
echo '</pre>';
*/

if (isset($_REQUEST['v_usuarnombr']) && !db_find($connection, 'tm_usuariosxx', 'v_usuarcedul', $_REQUEST['v_usuarcedul'])) {
    
    $data['s_usuarioxxx'] = db_next($connection, 'tm_usuariosxx', 's_usuarioxxx');
    $data['v_usuarnombr'] = $_REQUEST['v_usuarnombr'];
    $data['v_usuarapell'] = $_REQUEST['v_usuarapell'];
    $data['v_usuarcedul'] = $_REQUEST['v_usuarcedul'];
    $data['v_usuarcargo'] = $_REQUEST['v_usuarcargo'];
    $data['v_usuaremail'] = $_REQUEST['v_usuaremail'];
    $data['v_usuarclave'] = $_REQUEST['v_usuarclave'];
    $data['v_usuardirec'] = $_REQUEST['v_usuardirec'];
    $data['v_usuarhorar'] = $_REQUEST['v_usuarhorar'];
    $data['v_usuarcelul'] = $_REQUEST['v_usuarcelul'];
    $data['i_usuartipox'] = 'A';

    db_insert($connection, 'tm_usuariosxx', $data);
    
    $modu['s_usuarlider'] = $datos['s_usuarioxxx'];
    $modu['s_usuaramigo'] = $data['s_usuarioxxx'];
            
    db_insert($connection, 'td_usuargrupo', $modu);
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TechAmbits - Fecolsa - Dashboard</title>
        <link rel="icon" type="image/png" href="public/images/logos/favicon.png" />
        <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="public/css/jumbotron-narrow.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <script src="public/jquery/js/jquery-3.1.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="public/bootstrap/js/bootstrap.min.js"></script>
        <script src="public/js/fecolsa.js"></script>
        
        <script>
            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                weekHeader: 'Sm',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
 
            $.datepicker.setDefaults($.datepicker.regional['es']);
                $(function() {
                    $( ".datepicker" ).datepicker();
            });
        </script>
    </head>

    <body onload="$('#v_usuarnombr').focus()">
        
        <div class="container">
            <div class="header clearfix">
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <li role="presentation"><a href="#" onclick="goToHome()">Salida Segura</a></li>
                    </ul>
                </nav>
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
            
            <?php
            if ($datos['i_usuartipox'] === 'A') {
                
                ?>
                <h3>Bienvenido Administrador</h3>
                <div><b><?php echo $datos['v_usuarnombr'] . ' ' . $datos['v_usuarapell'] ?></b></div>
                <?php
                
                $sql = "SELECT a.*, b.* 
                          FROM td_usuargrupo a INNER JOIN 
                               tm_usuariosxx b ON a.s_usuarlider = b.s_usuarioxxx 
                         WHERE a.n_reservaxxx > '0' 
                           AND a.v_fechaasign IS NULL 
                      GROUP BY a.n_reservaxxx ";

                $reservas = db_get_rows($connection, $sql, null, true);
                $lengthReservas = count($reservas);
                
                /*
                echo '<pre>';
                print_r($reservas);
                echo '</pre>';
                */
                
                ?>
                
                
                <div class="row marketing">
                    <div class="col-md-12 center">
                        <div class="datos">
                            <p><b>RESERVAS EFECTUADAS POR ASIGNAR</b></p>
                            <div style="overflow-x:auto; padding-bottom: 15px;">
                                <table class="t-reservas" width="100%">
                                    <tr>
                                        <th nowrap>Reserva No.</th>
                                        <th nowrap>Fecha Reserva</th>
                                        <th nowrap>Dirección Recogida</th>
                                        <th nowrap>Fecha Recogida</th>
                                        <th nowrap>Destino Final</th>
                                        <th nowrap>Líder</th>
                                        <th nowraph>Cédula</th>
                                    </tr>
                                    <?php
                                    for ($r = 0; $r < $lengthReservas; $r++) :
                                        ?>
                                        <tr>
                                            <td nowrap class="center"><a onclick="seleccionarReserva('<?php echo $reservas[$r]['n_reservaxxx'] ?>')" href="#"><?php echo $reservas[$r]['n_reservaxxx'] ?></a></td>
                                            <td nowrap><?php echo $reservas[$r]['v_fechareser'] ?></td>
                                            <td nowrap><?php echo $reservas[$r]['v_direcrecog'] ?></td>
                                            <td nowrap><?php echo $reservas[$r]['v_fecharecog'] ?></td>
                                            <td nowrap><?php echo $reservas[$r]['v_destifinal'] ?></td>
                                            <td nowrap><?php echo $reservas[$r]['v_usuarnombr'] . ' ' . $reservas[$r]['v_usuarapell'] ?></td>
                                            <td nowrap><?php echo $reservas[$r]['v_usuarcedul'] ?></td>
                                        </tr>
                                        <?php
                                    endfor;
                                    ?>
                                </table>
                            </div>
                            <form id="formReservas" method="POST" action="asignar.php">
                                <input type="hidden" name="reserva" id="reserva">
                            </form>
                        </div>
                    </div>
                </div>
                
                <?php
                
                
            } else {
                
                ?>
                <div class="row marketing">
                    <?php


                    $access = db_login($connection, $_REQUEST);

                    $sql = "SELECT MAX(a.n_reservaxxx) AS reserva 
                              FROM td_usuargrupo a 
                             WHERE a.s_usuarlider = '" . $datos['s_usuarioxxx'] . "' ";

                    $record = db_get_rows($connection, $sql);
                    $reserva = $record['reserva'];

                    if ($access === true) {

                        ?>
                        <div class="col-md-6 center">
                            <div class="datos left">
                                <form id="formReservar" method="POST" action="reserva.php">
                                    <div class="form-group">
                                        <label for="v_direcrecog">DIRECCIÓN DE RECOGIDA:</label>
                                        <input type="text" class="form-control" name="v_direcrecog" id="v_direcrecog" placeholder="Direción de recogida" maxlength="100">
                                    </div>
                                    <div class="form-group">
                                        <label for="v_fecharecog_f">FECHA Y HORA DE RECOGIDA:</label>
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <?php
                                                    $v_fecharecog = date('Y-m-d');
                                                    ?>
                                                    <input type="text" class="form-control datepicker" name="v_fecharecog_f" id="v_fecharecog_f" placeholder="Fecha" maxlength="10" value="<?php echo $v_fecharecog ?>">
                                                    <input type="hidden" name="v_fecharecog" id="v_fecharecog" <?php echo $v_fecharecog . ' 00:00:00'?>>
                                                </td>
                                                <td width="10%" class="center">&nbsp;</td>
                                                <td width="20%">
                                                    <select class="form-control center" id="v_fecharecog_h" onchange="setHora()">
                                                        <?php
                                                        for ($h = 0; $h < 24; $h++) :
                                                            $hora = str_pad($h, 2, "0", STR_PAD_LEFT);
                                                            ?>
                                                            <option value="<?php echo $hora ?>"><?php echo $hora ?></option>
                                                            <?php
                                                        endfor;
                                                        ?>
                                                    </select>
                                                </td>
                                                <td width="10%" class="center"><b>:</b></td>
                                                <td width="20%">
                                                    <select class="form-control center" id="v_fecharecog_m" onchange="setHora()">
                                                        <?php
                                                        for ($m = 0; $m < 60; $m++) :
                                                            $minuto = str_pad($m, 2, "0", STR_PAD_LEFT);
                                                            ?>
                                                            <option value="<?php echo $minuto ?>"><?php echo $minuto ?></option>
                                                            <?php
                                                        endfor;
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                    <div class="form-group">
                                        <label for="v_destifinal">DESTINO FINAL:</label>
                                        <input type="text" class="form-control" name="v_destifinal" id="v_destifinal" placeholder="Destino final" maxlength="100">
                                    </div>
                                    <input type="hidden" name="s_usuarlider" value="<?php echo $datos['s_usuarioxxx'] ?>">
                                    <input type="hidden" name="v_usuarlider" value="<?php echo ($datos['v_usuarnombr'] . ' ' . $datos['v_usuarapell']) ?>">
                                    <input type="hidden" name="email" value="<?php echo $_REQUEST['email'] ?>">
                                    <input type="hidden" name="password" value="<?php echo $_REQUEST['password'] ?>">
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 right">
                            <b>BIENVENIDO SR: <?php echo strtoupper($datos['v_usuarnombr'] . ' ' . $datos['v_usuarapell']) ?></b>
                            <br>
                            Última Reserva Efectuada No. <b><?php echo $reserva ?></b>.
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="col-md-12 center">
                            <div class="wrong left">
                                <span class="glyphicon glyphicon-remove"></span>
                                &nbsp;&nbsp;
                                <b>Acceso denegado</b>. Revisa tus credenciales de acceso.
                            </div>
                            <br>
                            <button type="button" class="btn btn-default" onclick="goToHome()">Autentícate</button>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
                if ($access === true) :
                    $sql = "SELECT b.* 
                              FROM td_usuargrupo a INNER JOIN 
                                   tm_usuariosxx b ON a.s_usuaramigo = b.s_usuarioxxx 
                             WHERE b.i_usuartipox = 'A' 
                               AND a.s_usuarlider = '" . $datos['s_usuarioxxx'] . "'
                               AND a.n_reservaxxx = '0' ";
                    $rows = db_get_rows($connection, $sql, null, true);
                    $lengthRows = count($rows);
                    ?>
                    <div class="row marketing">
                        <div class="col-md-6">
                            <h4>Agregar Amigos</h4>
                            <div class="datos">
                                <?php 
                                if ($lengthRows >= 18) {
                                    echo '<span style="color:#cc0000;">Se han agregado el máximo total de <b>19</b> personas al Grupo.</span>';
                                } else {
                                    ?>

                                    <form class="form-horizontal" method="post" action="dashboard.php" id="formAgregar" onkeypress="return checkSubmit(event, this)">
                                        <input type="hidden" name="v_usuarclave" id="v_usuarclave">
                                        <div class="form-group">
                                            <label for="v_usuarnombr" class="col-sm-4 control-label">Nombres:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="v_usuarnombr" id="v_usuarnombr" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="v_usuarapell" class="col-sm-4 control-label">Apellidos:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="v_usuarapell" id="v_usuarapell" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="v_usuarcedul" class="col-sm-4 control-label">Cédula:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="v_usuarcedul" id="v_usuarcedul" onkeypress="return isNumeric(event)" maxlength="15">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="v_usuarcargo" class="col-sm-4 control-label">Cargo:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="v_usuarcargo" id="v_usuarcargo" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="v_usuaremail" class="col-sm-4 control-label">E-mail:</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" name="v_usuaremail" id="v_usuaremail" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="v_usuardirec" class="col-sm-4 control-label">Dir. Regreso:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="v_usuardirec" id="v_usuardirec" maxlength="100">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="v_usuarhorar" class="col-sm-4 control-label">Hora Regreso:</label>
                                            <div class="col-sm-8">
                                                <table width="100%" cellspacing="0" cellpadding="0">
                                                    <td width="45%">
                                                        <select class="form-control center" id="v_usuarhorar_h" onchange="setHora()">
                                                            <?php
                                                            for ($h = 0; $h < 24; $h++) :
                                                                $hora = str_pad($h, 2, "0", STR_PAD_LEFT);
                                                                ?>
                                                                <option value="<?php echo $hora ?>"><?php echo $hora ?></option>
                                                                <?php
                                                            endfor;
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td width="10%" class="center"><b>:</b></td>
                                                    <td width="45%">
                                                        <select class="form-control center" id="v_usuarhorar_m" onchange="setHora()">
                                                            <?php
                                                            for ($m = 0; $m < 60; $m++) :
                                                                $minuto = str_pad($m, 2, "0", STR_PAD_LEFT);
                                                                ?>
                                                                <option value="<?php echo $minuto ?>"><?php echo $minuto ?></option>
                                                                <?php
                                                            endfor;
                                                            ?>
                                                        </select>
                                                    </td>
                                                </table>
                                                <input type="hidden" name="v_usuarhorar" id="v_usuarhorar" value="00:00" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="v_usuarcelul" class="col-sm-4 control-label">Celular:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="v_usuarcelul" id="v_usuarcelul" onkeypress="return isNumeric(event)" maxlength="10">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-4 col-sm-8">
                                                <button type="button" class="btn btn-default" onclick="submitAgregar()">Agregar</button>
                                                <input type="hidden" name="email" id="email" value="<?php echo $_REQUEST['email'] ?>" />
                                                <input type="hidden" name="password" id="password" value="<?php echo $_REQUEST['password'] ?>" />
                                            </div>
                                        </div>
                                    </form>

                                    <?php
                                }
                                ?>
                            </div>
                        </div>



                        <div class="col-md-6">
                            <h4>Mi Grupo</h4>
                            <div class="datos">

                                <div>
                                    &nbsp;&nbsp;<b>1</b>.&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-user" style="cursor:pointer;"></span>&nbsp;&nbsp;
                                    <?php echo $datos['v_usuarnombr'] . ' ' . $datos['v_usuarapell'] ?> - <b>Líder del Grupo</b>
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

                                $disabled = $lengthRows >= 12 && $lengthRows <= 18 ? null : 'disabled="disabled"';
                                ?>

                                <div class="center">
                                    <br>
                                    <form>
                                        <button type="button" class="btn btn-primary" onclick="submitReservar()" <?php echo $disabled ?>>Reservar</button>
                                        <input type="hidden" name="email" id="email" value="<?php echo $_REQUEST['email'] ?>" />
                                        <input type="hidden" name="password" id="password" value="<?php echo $_REQUEST['password'] ?>" />
                                    </form>
                                </div>

                            </div>


                        </div>


                    </div>
                    <?php
                endif;
            }
            ?>

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



