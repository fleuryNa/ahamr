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
                            <h3 class="mb-0">Utilisateurs</h3>
                        </div>
                        <div class="col-sm-6">
                        <button type="submit" class="lodge-primary float-end" name="save" value="create" data-bs-toggle="modal" data-bs-target="#staticBackdroppersonnel">Nouveau</button>

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
<div>
<table style="padding-top: 20px;" class="table table-bordered table-striped table-hover" id="listpersonnel">
                                  <thead>
                                    <tr>
                                      <th scope="col">MATRICULE</th>
                                      <th scope="col">NOM</th>
                                      <!-- <th scope="col">SEXE</th>
                                      <th scope="col">AGE</th> -->
                                      <th scope="col">CONTACT</th>
                                      <!-- <th scope="col">RESIDENCE</th> -->
                                      <th scope="col">PROFIL</th>
                                      <th scope="col">ETAT</th>
                                      <th scope="col">ACTION</th>
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
        <div class="modal fade" id="staticBackdroppersonnel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdroppersonnelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdroppersonnelLabel">Ajout d'un utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="chantierForm" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="NOM" class="form-label">Nom</label>
                            <input type="text" name="NOM" id="NOM" class="form-control">
                        </div>

                    </div>
                    <div class="col-md-6">
                    <div class="mb-3">
                    <label for="PRENOM" class="form-label">Prénom</label>
                    <input type="text" name="PRENOM" id="PRENOM" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                        <label for="ID_SEXE" class="form-label">Genre</label>
                        <select name="ID_SEXE" id="ID_SEXE" class="form-select">
                            <option value="">Seléctionner</option>
                            <option value="1">Homme</option>
                            <option value="2">Femme</option>
                        </select>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                        <label for="DATE_NAISSANCE" class="form-label">Date naissance</label>
                        <input type="date" name="DATE_NAISSANCE" id="DATE_NAISSANCE" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label for="TEL" class="form-label">Téléphone</label>
                        <input type="tel" name="TEL" id="TEL" class="form-control" placeholder="Ex.71458089">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label for="EMAIL" class="form-label">Email</label>
                        <input type="email" name="EMAIL" id="EMAIL" class="form-control" placeholder="Ex.julesyuliyusi@gmail.com">
                    </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ID_PROFIL" class="form-label">Profil</label>
                        <select name="ID_PROFIL" id="ID_PROFIL" class="form-select">
                            <option value="" >Seléctionner</option>
                            <?php foreach ($profil as $keyf) {?>
                            <option value="<?php echo $keyf->ID_PROFIL ?>"><?php echo $keyf->PRO_DESCR ?></option>
                            <?php }?>

                        </select>

                    </div>
                    </div>
                </div>
                </form>
                <div id="responseMessage" class="mt-3"></div>



            </div>
            <div class="modal-footer">
                <button type="button" id="btnsb" class="lodge-primary" >Enregistrer</button>
            </div>
            </div>
        </div>
        </div>



        <?php echo view('includes/footer') ?>
        <script type="text/javascript">

        $(document).ready( function () {
            liste()
        } );

        function liste() {
        // body...
            var row_count = "1000000";
            $('#listpersonnel').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
                "oreder": [
                    [2, 'desc']
                ],
                "ajax": {
                    url: "<?php echo base_url('admin/listeuser') ?>",
                    type: "POST",
                    data: {}
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
$("#btnsb").on("click", function (e) {

    e.preventDefault(); // Empêche la soumission traditionnelle
    // Réinitialiser les messages d'erreur
    $(".is-invalid").removeClass("is-invalid");
    $(".invalid-feedback").remove();
    let isValid = true;
    // Vérifier le champ "Nom du chantier"
    let nom = $("#NOM").val();
    if (nom.trim() === "") {
        isValid = false;
        $("#NOM").addClass("is-invalid")
            .after('<div class="invalid-feedback">Le nom est obligatoire.</div>');
    }
    // Vérifier la date de création
    let prenom = $("#PRENOM").val();
    if (prenom === "") {
        isValid = false;
        $("#PRENOM").addClass("is-invalid")
            .after('<div class="invalid-feedback">Le prénom est obligatoire.</div>');
    }
    let ID_SEXE = $("#ID_SEXE").val();
    if (ID_SEXE === "") {
        isValid = false;
        $("#ID_SEXE").addClass("is-invalid")
            .after('<div class="invalid-feedback">Veuillez sélectionner le genre.</div>');
    }

        // Vérifier le téléphone
    let tel = $("#TEL").val();
    let telRegex = /^[0-9]{8,15}$/;
    if (!telRegex.test(tel)) {
        isValid = false;
        $("#TEL").addClass("is-invalid")
            .after('<div class="invalid-feedback">Le téléphone doit contenir entre 8 et 15 chiffres.</div>');
    }

    let DATE_NAISSANCE = $("#DATE_NAISSANCE").val();
    if (DATE_NAISSANCE.trim() === "") {
        isValid = false;
        $("#DATE_NAISSANCE").addClass("is-invalid")
            .after('<div class="invalid-feedback">La date de naissance est obligatoire.</div>');
    }

    let ID_PROFIL = $("#ID_PROFIL").val();
    if (ID_PROFIL === "") {
        isValid = false;
        $("#ID_PROFIL").addClass("is-invalid")
            .after('<div class="invalid-feedback">Veuillez sélectionner un profil.</div>');
    }

    let EMAIL = $("#EMAIL").val();
    if (EMAIL.trim() === "" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(EMAIL)) {

        isValid = false;
        $("#EMAIL").addClass("is-invalid")
            .after('<div class="invalid-feedback">L\'email est obligatoire.</div>');
    }

    const chantierForm = document.getElementById("chantierForm");

    // Si tout est valide, envoyer les données via AJAX
    if (isValid) {
        let formData = new FormData(chantierForm);
        $("#btnsb").prop('disabled', true).text('Envoi en cours...');
        $.ajax({
            url: "<?php echo base_url('admin/createuser') ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function() {
                 // Afficher l'overlay de chargement
                 $('#loadingOverlay').show();
              },
            success: function (response) {
                if (response.success) {
                    $('#responseMessage').html("<div class='alert alert-success'>L'utilisateur enregistré avec succès !</div>").fadeIn();
                    $("form")[0].reset();
                    liste();
                } else {
                    $('#responseMessage').html("<div class='alert alert-danger'>Erreur côté serveur"+ JSON.stringify(response.errors)+"</div>").fadeIn();
                    // alert("Erreur côté serveur : " + JSON.stringify(response.errors));
                }


            },
            error: function (xhr, status, error) {
                $('#responseMessage').html("<div class='alert alert-danger'>Une erreur s'est produite : "+error+"</div>").fadeIn();
            },
            complete:function(){
                $("#btnsb").prop('disabled', false).text('Enregistrer');
                // Cacher l'overlay après la requête
                $('#loadingOverlay').hide();
                setTimeout(() => {
                        $('#responseMessage').fadeOut();
                }, 5000);
            }
        });
    }
});

</script>
<script>
  // Réinitialiser mot de passe
  function resetPassword(userId) {
      if (confirm("Voulez-vous vraiment réinitialiser le mot de passe de cet utilisateur ?")) {
          $.ajax({
              url: "<?php echo base_url('admin/resetPassword') ?>",
              type: "POST",
              data: { user_id: userId },
              dataType: "json",
              success: function (response) {
                  if (response.status === "success") {
                      liste();
                  } else {
                      alert("Erreur : " + response.message);
                  }
              },
              error: function () {
                  alert("Erreur de connexion au serveur !");
              }
          });
      }
  }

  // Activer / désactiver utilisateur
  function toggleUserStatus(userId, action) {
     let act=action
      let message = action === 0
          ? "Voulez-vous activer cet utilisateur ?"
          : "Voulez-vous désactiver cet utilisateur ?";

      if (confirm(message)) {
          $.ajax({
              url: "<?php echo base_url('admin/toggleStatus') ?>",
              type: "POST",
              data: { user_id: userId, action: act },
              dataType: "json",
              success: function (response) {
                  if (response.status === "success") {
                     liste();
                  } else {
                      alert("Erreur : " + response.message);
                  }
              },
              error: function () {
                  alert("Erreur de connexion au serveur !");
              }
          });
      }
  }
</script>
