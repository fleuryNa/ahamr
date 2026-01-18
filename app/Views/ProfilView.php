<?php
    echo view('includes/head');
?>
<?php echo view('includes/sidebar') ?>
    <!--begin::App Main-->
        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Profil</h3>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-end">
                            <!-- Button trigger modal -->
                            <!-- <button type="button" class="btn btn-primary" >
                            Nouveau
                            </button> -->
                            <button class="lodge-primary"  data-bs-toggle="modal" data-bs-target="#modalAddProfil">Nouveau</button>

                            </div>

                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-12"> <!-- Default box -->
                            <div class="card">

                                <div class="card-body">
                                    <div class="m-3">
                                    <table id="profil" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                        <th >PROFIL</th>
                                        <th >ROLE</th>
                                        <th >ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                    </table>
                                    </div>


                                </div> <!-- /.card-body -->
                            </div> <!-- /.card -->
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main> <!--end::App Main--> <!--begin::Footer-->
        <!-- Modal -->
        <div class="modal fade" id="modalAddProfil" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddProfilLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddProfilLabel">Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="addProfilForm">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="PRO_DESCR" class="form-label">Profil</label>
                                <input type="text" class="form-control" name="PRO_DESCR" id="PRO_DESCR">
                                <input type="hidden" class="form-control" name="ID_PROFIL" id="ID_PROFIL">

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row" id="chkbx">
                        <?php foreach ($role as $key) {?>
                            <div class="col-4">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?php echo $key->ID_ROLE ?>" id="ID_ROLE[<?php echo $key->ID_ROLE ?>]" name="ID_ROLE[<?php echo $key->ID_ROLE ?>]" >
                            <label class="form-check-label" for="ID_ROLE[<?php echo $key->ID_ROLE ?>]">
                            <?php echo $key->DESCR_ROLE ?>
                            </label>
                            </div>

                            </div>

                           <?php }?>
                           </div>
                        </div>

                    </div>


                </form>
<div id="responseMessageappel">

</div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnprofadd" class="lodge-primary">Enregistrer</button>
            </div>
            </div>
        </div>
        </div>
        <?php echo view('includes/footer') ?>
<script>
$('#btnprofadd').on('click', function (e) {
    e.preventDefault();
    $(".is-invalid").removeClass("is-invalid");
    $(".invalid-feedback").remove();

    let isValid = true;
    let errorMessage = '';
        // Récupérer les valeurs des checkbox cochées
        let selectedRoles = [];
        $('input.form-check-input:checked').each(function () {
            selectedRoles.push($(this).val());
        });
        let ID_PROFIL = $('#ID_PROFIL').val()
        // Vérifier si aucune checkbox n'est cochée
        if (selectedRoles.length === 0 && ID_PROFIL.trim() ==="" ) {
            $('#responseMessageappel').html("<div class='alert alert-danger'>Veuillez sélectionner au moins un rôle.</div>").fadeIn();
            isValid = false; // Empêcher l'exécution du reste du code
        }
        let PRO_DESCR = $('#PRO_DESCR').val()

        if (PRO_DESCR.trim() === "" ) {
            isValid = false;
            $("#PRO_DESCR").addClass("is-invalid")
                .after('<div class="invalid-feedback">Le profil est obligatoire.</div>');
        }
    const addProfilForm = document.getElementById("addProfilForm");
    let formData = new FormData(addProfilForm);
    const errorDiv = document.querySelector('.validation-error'); // Div pour afficher les erreurs
    if (isValid) {
        $("#responseMessageappel").html('');
        $("#btnprofadd").prop('disabled', true).text('Envoi en cours...');
        $.ajax({
        url: '<?php echo base_url('admin/addprofil') ?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                liste()
                $('#PRO_DESCR').val("")
                $('#ID_PROFIL').val("")
                $('#responseMessageappel').html("<div class='alert alert-success'>Profil enregistrée avec succès !</div>").fadeIn();
                    $("#addProfilForm")[0].reset();
                } else {
                    $('#responseMessageappel').html("<div class='alert alert-danger'>Erreur côté serveur"+ JSON.stringify(response.errors)+"</div>").fadeIn();

                }

        },
        error: function (xhr, status, error) {

            $('#responseMessageappel').html("<div class='alert alert-danger'>Erreur lors de l'enregistrement.<br>"+error+"</div>").fadeIn();

        },complete: function(){
            $("#btnprofadd").prop('disabled', false).text('Enregistrer');
            setTimeout(() => {
                    $('#responseMessageappel').fadeOut();
                    $('#modalAddProfil').modal('hide');
                    liste()
                }, 5000);
        }
    });


    }




});

</script>

<script type="text/javascript">

$(document).ready( function () {
    liste()
} );

function liste() {
  // body...
    var row_count = "1000000";
    $('#profil').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true,
        "oreder": [
            [2, 'desc']
        ],
        "ajax": {
            url: "<?php echo base_url('admin/listeprof') ?>",
            type: "POST",
            data: {'ID_CHANTIER':$('#ID_CHANTIER').val()}
        },
        lengthMenu: [
            [10, 50, 100, row_count],
            [10, 50, 100, "All"]
        ],
        pageLength: 10,
        "columnDefs": [{
            "targets": [],
            "orderable": false
        }],

        dom: 'Bfrtlip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        language: {
            "sProcessing": "Traitement en cours...",
            "sSearch": "Rechercher&nbsp;:",
            "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix": "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst": "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext": "Suivant",
                "sLast": "Dernier"
            },
            "oAria": {
                "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            }
        }

    });

}
</script>
<script>
    function modifier(idprofil) {
        // Envoi AJAX
        $('#modalAddProfil').modal('show')
        $.ajax({
            url: "getrole",
            type: "POST",
            data: { ID_PROFIL: idprofil },
            success: function (response) {

             $('#chkbx').html(response.chbx)
             $('#PRO_DESCR').val(response.PRO_DESCR)
             $('#ID_PROFIL').val(response.ID_PROFIL)
             $("#btnprofadd").html('Modifier')
             $('#modalAddProfil').modal('show')
            },
            error: function (xhr, status, error) {
                alert("Une erreur est survenue !");
                console.error(error);
            }
        });

    }
</script>