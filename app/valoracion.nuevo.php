<?php
include_once '../lib/ControlAcceso.class.php';

ControlAcceso::requierePermiso(PermisosSistema::PERMISO_OPCIONES_VALORACION);
$servicio = $_POST['idservicio'];        //ya esta trabajando sobre un servicio, por lo que esta definido
$nombreservicio = $_POST['nombreservicio'];
?>
<html>
    <head>
        <title><?php echo Constantes::NOMBRE_SISTEMA; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <noscript>
            <meta http-equiv="refresh" content="0; URL=nojs/index.php">
        </noscript>
        <script src="../lib/datatables/jquery.js"></script>
<!--        <script src="../lib/validador.js" type="text/javascript"></script>-->
        <script src="../lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../lib/bootstrapSwitch/js/bootstrap-switch.min.js"></script>
        <script src="../lib/validator/jquery.validate.min.js"></script>
        <script type="text/javascript" src="../lib/validadorValoracion.js"></script>
        <link href="../lib/bootstrapSwitch/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">
        <link href="../gui/estilo.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <?php include_once '../gui/GUI.class.php';include_once '../gui/GUImenu.php'; ?>
        <section id="main-content">
            <article>
                <div class="content">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>Nueva Valoraci&oacute;n para el servicio <?php echo mb_strtoupper($nombreservicio); ?></h3>
                            <p>Por favor complete los datos a continuaci&oacute;n. Los campos marcados con (*) son obligatorios.</p>
                            <form method="post" class="form-horizontal" role="form"  action="valoracion.nuevo.procesa.php" name="formulario" id="formulario" >
<!--                                <script type="text/javascript" language="javascript">var validador = new Validator("formulario");</script>-->

                                <div class="form-group row">
                                    <label for="nombre" class="col-sm-3 col-form-label">Nombre Valoraci&oacute;n (*)</label>
                                    <div class="col-xs-3">
                                        <input type="text" name="nombre" id="nombre" pattern=".{3,45}" required maxlength="45" class="form-control" title="Nombre de la Valoracion" />
<!--                                        <script>validador.addValidation("nombre", "obligatorio");</script>-->
<!--                                        <script>validador.addValidation("nombre", "solotexto");</script>-->
                                    </div>
                                    <span>(Entre 3 y 45 letras)</span>
                                </div>

                                <div class="form-group row">
                                    <label for="descripcion" class="col-sm-3 col-form-label">Descripci&oacute;n</label>
                                    <div class="col-xs-3">
                                        <textarea name="descripcion" rows="3" minlength="5" maxlength="140" id="descripcion" class="form-control" title="Texto descriptivo"></textarea>
<!--                                        <script>validador.addValidation("descripcion", "obligatorio");</script>
                                        <script>validador.addValidation("descripcion", "solotexto");</script>-->
                                    </div>
                                    <span>(Entre 5 y 140 letras)</span>
                                </div>

                                <div class="form-group row">
                                    <label for="tipo" class="col-sm-3 col-form-label">Tipo de Valores (*)</label>
                                    <div class="col-xs-3">
                                        <select id="tipo" name="tipo" class="form-control" title="Tipo de valoracion">
                                            <?php
                                            /* consulta para obtener los tipos de valoraciones que estan 
                                             * contenido en la definicion del campo enumerado */
                                            $datos = ObjetoDatos::getInstancia()->ejecutarQuery(""
                                                    . "SHOW COLUMNS "
                                                    . "FROM " . Constantes::BD_USERS . ".valoracion_rango LIKE 'tipo_valores';");
                                            if ($datos->num_rows > 0) {
                                                $tipo = $datos->fetch_row();
                                                preg_match_all("/'([\w ]*)'/", $tipo[1], $values);
                                            }
                                            foreach ($values[1] as $opcion) {
                                                ?>
                                                <option value="<?= $opcion; ?>"><?= $opcion; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="recibirNotificacion" class="col-sm-3 col-form-label">Recibir Notificaci&oacute;n por Email</label>
                                    <div class="col-sm-8">
                                        <input id="recibirNotificacion" type="checkbox" name="recibir_notificacion" data-label-width="5"  data-on-text="Si" data-off-text="No" data-size="mini" value="1" checked/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="permite_descripcion" class="col-sm-3 col-form-label">Permite Descripci&oacute;n</label>
                                    <div class="col-sm-8">
                                        <input id="permite_descripcion" type="checkbox" name="permite_descripcion" data-label-width="5"  data-on-text="Si" data-off-text="No" data-size="mini" value="1" checked/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="habilitado" class="col-sm-3 col-form-label">Habilitado</label>
                                    <div class="col-sm-8">
                                        <input id="habilitado" type="checkbox" name="habilitado" data-label-width="5"  data-on-text="Si" data-off-text="No" data-size="mini" value="1" checked/>
                                    </div>
                                </div>

                                <input type="hidden" name="idservicio" value="<?php echo $_POST['idservicio']; ?>" />
                                <input type="hidden" name="nombreservicio" value="<?php echo $nombreservicio; ?>" />

                                <fieldset>
                                    <legend>Opciones</legend>
                                    <input type="submit" class="btn btn-success" value="Guardar" />
                                    <input type="reset" class="btn btn-default" value="Limpiar Campos" />

                                    <input type="button" id="salir" class="btn btn-default" onClick="chgAction();" value="Salir" />

                                </fieldset>
                                <script language="javascript" type="text/javascript">
                                    function chgAction() {
                                        document.getElementById("formulario").action = "valoracion.ver.php";
                                        document.getElementById("formulario").submit();
                                    }
                                </script>

                            </form>
                        </div>
                    </div>
                </div>
            </article>

            <script>
                $(document).ready(function () {
                    $("[name='recibir_notificacion']").bootstrapSwitch();
                    $("[name='permite_descripcion']").bootstrapSwitch();
                    $("[name='habilitado']").bootstrapSwitch();
                });
            </script>

            <?php include_once '../gui/GUIfooter.php'; ?>
        </section>
    </body>
</html>