<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TechAmbits - Fecolsa</title>
        <link rel="icon" type="image/png" href="public/images/logos/favicon.png" />
        <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="public/css/jumbotron-narrow.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <script src="public/jquery/js/jquery-3.1.1.min.js"></script>
        <script src="public/bootstrap/js/bootstrap.min.js"></script>
        <script src="public/js/fecolsa.js"></script>
    </head>

    <body onload="$('#email').focus()">

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
                <div class="col-md-6">
                    <h4>Acceso</h4>
                    <div class="login">
                        <form class="form-horizontal" method="post" action="dashboard.php" id="formLogin" onkeypress="return checkSubmit(event, this)">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">E-mail</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                        <span class="input-group-addon">@</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">Contraseña</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña">
                                        <span class="input-group-addon">@</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="button" class="btn btn-default" onclick="submitLogin()">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <h4>Registro - Líder de Grupo</h4>
                    <div class="registro">
                        <form class="form-horizontal" method="post" action="registro.php" id="formRegistro" onkeypress="return checkSubmit(event, this)">
                            <input type="hidden" name="v_usuarclave" id="v_usuarclave">
                            <div class="form-group">
                                <label for="v_usuarnombr" class="col-sm-4 control-label">Nombres:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="v_usuarnombr" id="v_usuarnombr" placeholder="Nombres del líder" maxlength="50">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="v_usuarapell" class="col-sm-4 control-label">Apellidos:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="v_usuarapell" id="v_usuarapell" placeholder="Apellidos del líder" maxlength="50">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="v_usuarcedul" class="col-sm-4 control-label">Cédula:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="v_usuarcedul" id="v_usuarcedul" placeholder="Cédula del líder" onkeypress="return isNumeric(event)" maxlength="15">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="v_usuarcargo" class="col-sm-4 control-label">Cargo:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="v_usuarcargo" id="v_usuarcargo" placeholder="Cargo del líder" maxlength="50">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="v_usuaremail" class="col-sm-4 control-label">E-mail:</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" name="v_usuaremail" id="v_usuaremail" placeholder="E-mail del líder" maxlength="50">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="v_usuardirec" class="col-sm-4 control-label">Dir. Regreso:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="v_usuardirec" id="v_usuardirec" placeholder="Dirección de Regreso" maxlength="100">
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
                                <label for="v_usuarcelul" class="col-sm-4 control-label">Celular Líder:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="v_usuarcelul" id="v_usuarcelul" placeholder="Celular del Líder" onkeypress="return isNumeric(event)" maxlength="10">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="button" class="btn btn-default" onclick="submitRegistro()">Registrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
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

