<!-- Modal Remolques -->
<div class="modal fade" id="modalAddRemolques" tabindex="-1" role="dialog" aria-labelledby="modalAddRemolques" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= lang('remolques.createEdit') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-remolques" class="form-horizontal">
                    <input type="hidden" id="idRemolques" name="idRemolques" value="0">

                    <div class="form-group row">
                        <label for="idEmpresa" class="col-sm-2 col-form-label"><?= lang('remolques.fields.idEmpresa') ?></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>


                                <select class="form-control idEmpresaRemolque form-controlVehiculos" name="idEmpresaRemolque" id="idEmpresaRemolque" style="width:80%;">
                                    <option value="0">Seleccione empresa</option>
                                    <?php
                                    foreach ($empresas as $key => $value) {

                                        echo "<option value='$value[id]'>$value[id] - $value[nombre] </option>  ";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="descripcion" class="col-sm-2 col-form-label"><?= lang('remolques.fields.descripcion') ?></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                                <input type="text" name="descripcionRemolque" id="descripcionRemolque" class="form-control <?= session('error.descripcion') ? 'is-invalid' : '' ?>" value="<?= old('descripcion') ?>" placeholder="<?= lang('remolques.fields.descripcion') ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subTipoRemolque" class="col-sm-2 col-form-label"><?= lang('remolques.fields.subTipoRemolque') ?></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>

                                <select class="form-control subTipoRemolque form-controlVehiculos" name="subTipoRemolque" id="subTipoRemolque" style="width:80%;">
                                    <option value="0">Seleccione Sup Tipo Remolque</option>
                                    <option value="CTR001">CTR001 - Caballete</option>
                                    <option value="CTR002">CTR002 - Caja</option>
                                    <option value="CTR003">CTR003 - Caja Abierta</option>
                                    <option value="CTR004">CTR004 - Caja Cerrada</option>
                                    <option value="CTR005">CTR005 - Caja De Recolección Con Cargador Frontal</option>
                                    <option value="CTR006">CTR006 - Caja Refrigerada</option>
                                    <option value="CTR007">CTR007 - Caja Seca</option>
                                    <option value="CTR008">CTR008 - Caja Transferencia</option>
                                    <option value="CTR009">CTR009 - Cama Baja o Cuello Ganso</option>
                                    <option value="CTR010">CTR010 - Chasis Portacontenedor</option>
                                    <option value="CTR011">CTR011 - Convencional De Chasis</option>
                                    <option value="CTR012">CTR012 - Equipo Especial</option>
                                    <option value="CTR013">CTR013 - Estacas</option>
                                    <option value="CTR014">CTR014 - Góndola Madrina</option>
                                    <option value="CTR015">CTR015 - Grúa Industrial</option>
                                    <option value="CTR016">CTR016 - Grúa</option>
                                    <option value="CTR017">CTR017 - Integral</option>
                                    <option value="CTR018">CTR018 - Jaula</option>
                                    <option value="CTR019">CTR019 - Media Redila</option>
                                    <option value="CTR020">CTR020 - Pallet o Celdillas</option>
                                    <option value="CTR021">CTR021 - Plataforma</option>
                                    <option value="CTR022">CTR022 - Plataforma Con Grúa</option>
                                    <option value="CTR023">CTR023 - Plataforma Encortinada</option>
                                    <option value="CTR024">CTR024 - Redilas</option>
                                    <option value="CTR025">CTR025 - Refrigerador</option>
                                    <option value="CTR026">CTR026 - Revolvedora</option>
                                    <option value="CTR027">CTR027 - Semicaja</option>
                                    <option value="CTR028">CTR028 - Tanque</option>
                                    <option value="CTR029">CTR029 - Tolva</option>
                                    <option value="CTR031">CTR031 - Volteo</option>
                                    <option value="CTR032">CTR032 - Volteo Desmontable</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="placa" class="col-sm-2 col-form-label"><?= lang('remolques.fields.placa') ?></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                                <input type="text" name="placa" id="placa" class="form-control <?= session('error.placa') ? 'is-invalid' : '' ?>" value="<?= old('placa') ?>" placeholder="<?= lang('remolques.fields.placa') ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= lang('boilerplate.global.close') ?></button>
                <button type="button" class="btn btn-primary btn-sm" id="btnSaveRemolques"><?= lang('boilerplate.global.save') ?></button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('js') ?>


<script>

    $(document).on('click', '.btnAddRemolques', function (e) {


        $(".form-control").val("");

        $("#idRemolques").val("0");

        $("#idEmpresaRemolque").val("0");

        $("#idEmpresaRemolque").trigger("change");

        $("#subTipoRemolque").val("0");

        $("#subTipoRemolque").trigger("change");

        $("#btnSaveRemolques").removeAttr("disabled");

    });

    /* 
     * AL hacer click al editar
     */



    $(document).on('click', '.btnEditRemolques', function (e) {


        var idRemolques = $(this).attr("idRemolques");

        //LIMPIAMOS CONTROLES
        $(".form-control").val("");

        $("#idRemolques").val(idRemolques);
        $("#btnGuardarRemolques").removeAttr("disabled");

    });


    $("#idEmpresaRemolque").select2();
    $("#subTipoRemolque").select2();

</script>


<?= $this->endSection() ?>
        