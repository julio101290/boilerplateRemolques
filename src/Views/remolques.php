<?= $this->include('julio101290\boilerplate\Views\load\select2') ?>
<?= $this->include('julio101290\boilerplate\Views\load\datatables') ?>
<?= $this->include('julio101290\boilerplate\Views\load\nestable') ?>
<!-- Extend from layout index -->
<?= $this->extend('julio101290\boilerplate\Views\layout\index') ?>

<!-- Section content -->
<?= $this->section('content') ?>

<?= $this->include('julio101290\boilerplateremolques\Views\modulesRemolques/modalCaptureRemolques') ?>

<!-- SELECT2 EXAMPLE -->
<div class="card card-default">
    <div class="card-header">
        <div class="float-right">
            <div class="btn-group">

                <button class="btn btn-primary btnAddRemolques" data-toggle="modal" data-target="#modalAddRemolques"><i class="fa fa-plus"></i>

                    <?= lang('remolques.add') ?>

                </button>

            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="tableRemolques" class="table table-striped table-hover va-middle tableRemolques">
                        <thead>
                            <tr>

                                <th>#</th>
                                <th><?= lang('remolques.fields.idEmpresa') ?></th>
                                <th><?= lang('remolques.fields.descripcion') ?></th>
                                <th><?= lang('remolques.fields.subTipoRemolque') ?></th>
                                <th><?= lang('remolques.fields.placa') ?></th>
                                <th><?= lang('remolques.fields.updated_at') ?></th>
                                <th><?= lang('remolques.fields.deleted_at') ?></th>
                                <th><?= lang('remolques.fields.created_at') ?></th>

                                <th><?= lang('remolques.fields.actions') ?> </th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>

    /**
     * Cargamos la tabla
     */

    var tableRemolques = $('#tableRemolques').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        order: [[1, 'asc']],

        ajax: {
            url: '<?= base_url('admin/remolques') ?>',
            method: 'GET',
            dataType: "json"
        },
        columnDefs: [{
                orderable: false,
                targets: [8],
                searchable: false,
                targets: [8]

            }],
        columns: [{
                'data': 'id'
            },

            {
                'data': 'idEmpresa'
            },

            {
                'data': 'descripcion'
            },

            {
                'data': 'subTipoRemolque'
            },

            {
                'data': 'placa'
            },

            {
                'data': 'updated_at'
            },

            {
                'data': 'deleted_at'
            },

            {
                'data': 'created_at'
            },

            {
                "data": function (data) {
                    return `<td class="text-right py-0 align-middle">
                         <div class="btn-group btn-group-sm">
                             <button class="btn btn-warning btnEditRemolques" data-toggle="modal" idRemolques="${data.id}" data-target="#modalAddRemolques">  <i class=" fa fa-edit"></i></button>
                             <button class="btn btn-danger btn-delete" data-id="${data.id}"><i class="fas fa-trash"></i></button>
                         </div>
                         </td>`
                }
            }
        ]
    });



    $(document).on('click', '#btnSaveRemolques', function (e) {


        var idRemolques = $("#idRemolques").val();
        var idEmpresa = $("#idEmpresaRemolque").val();
        var descripcion = $("#descripcionRemolque").val();
        var subTipoRemolque = $("#subTipoRemolque").val();
        var placa = $("#placa").val();

        $("#btnSaveRemolques").attr("disabled", true);

        var datos = new FormData();
        datos.append("idRemolques", idRemolques);
        datos.append("idEmpresa", idEmpresa);
        datos.append("descripcion", descripcion);
        datos.append("subTipoRemolque", subTipoRemolque);
        datos.append("placa", placa);


        $.ajax({

            url: "<?= base_url('admin/remolques/save') ?>",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta.match(/Correctamente.*/)) {

                    Toast.fire({
                        icon: 'success',
                        title: "Guardado Correctamente"
                    });

                    tableRemolques.ajax.reload();
                    $("#btnSaveRemolques").removeAttr("disabled");


                    $('#modalAddRemolques').modal('hide');
                } else {

                    Toast.fire({
                        icon: 'error',
                        title: respuesta
                    });

                    $("#btnSaveRemolques").removeAttr("disabled");


                }

            }

        }

        )

    });



    /**
     * Carga datos actualizar
     */


    /*=============================================
     EDITAR Remolques
     =============================================*/
    $(".tableRemolques").on("click", ".btnEditRemolques", function () {

        var idRemolques = $(this).attr("idRemolques");

        var datos = new FormData();
        datos.append("idRemolques", idRemolques);

        $.ajax({

            url: "<?= base_url('admin/remolques/getRemolques') ?>",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
                $("#idRemolques").val(respuesta["id"]);

                $("#idEmpresa").val(respuesta["idEmpresa"]);
                $("#idEmpresa").trigger("change");
                $("#descripcion").val(respuesta["descripcion"]);
                $("#subTipoRemolque").val(respuesta["subTipoRemolque"]);
                $("#subTipoRemolque").trigger("change");
                $("#placa").val(respuesta["placa"]);


            }

        })

    })


    /*=============================================
     ELIMINAR remolques
     =============================================*/
    $(".tableRemolques").on("click", ".btn-delete", function () {

        var idRemolques = $(this).attr("data-id");

        Swal.fire({
            title: '<?= lang('boilerplate.global.sweet.title') ?>',
            text: "<?= lang('boilerplate.global.sweet.text') ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= lang('boilerplate.global.sweet.confirm_delete') ?>'
        })
                .then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: `<?= base_url('admin/remolques') ?>/` + idRemolques,
                            method: 'DELETE',
                        }).done((data, textStatus, jqXHR) => {
                            Toast.fire({
                                icon: 'success',
                                title: jqXHR.statusText,
                            });


                            tableRemolques.ajax.reload();
                        }).fail((error) => {
                            Toast.fire({
                                icon: 'error',
                                title: error.responseJSON.messages.error,
                            });
                        })
                    }
                })
    })

    $(function () {
        $("#modalAddRemolques").draggable();

    });


</script>
<?= $this->endSection() ?>
        