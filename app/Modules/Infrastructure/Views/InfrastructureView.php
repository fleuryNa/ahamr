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
                            <h3 class="mb-0">Infrastructure</h3>
                        </div>
                        <div class="col-sm-6 text-end">
                         <button class="lodge-primary"  data-bs-toggle="modal" data-bs-target="#staticInfra">Nouveau</button>
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
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-captage-tab" data-bs-toggle="pill" data-bs-target="#pills-captage" type="button" role="tab" aria-controls="pills-captage" aria-selected="true">Captage</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-chambre-tab" data-bs-toggle="pill" data-bs-target="#pills-chambre" type="button" role="tab" aria-controls="pills-chambre" aria-selected="false">Chambre</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-conduite-tab" data-bs-toggle="pill" data-bs-target="#pills-conduite" type="button" role="tab" aria-controls="pills-conduite" aria-selected="false">Conduite</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-reservoir-tab" data-bs-toggle="pill" data-bs-target="#pills-reservoir" type="button" role="tab" aria-controls="pills-reservoir" aria-selected="false">Réservoir</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-bf-tab" data-bs-toggle="pill" data-bs-target="#pills-bf" type="button" role="tab" aria-controls="pills-bf" aria-selected="false">BF</button>
                                </li>
                                </ul>
                                <div id="pills-captage">
                                    <table class="table table-sm table-bordered table-striped" id="table-captage">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>PROVINCE</th>
                                        <th>COMMUNE</th>
                                        <th>NOM RESEAU</th>
                                        <th>FONCTIONAL</th>
                                        <th>ETAT</th>
                                        <th>DEBIT</th>
                                        <th>CODE</th>
                                        <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    </table>

                                </div>
                                <div id="pills-chambre" class="table-responsive">
                                    <table class="table table-sm table-bordered table-striped" id="table-chambre">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>PROVINCE</th>
                                        <th>COMMUNE</th>
                                        <th class="nowrap-header">NOM RESEAU</th>
                                        <th>FONCTIONAL</th>
                                        <th>ETAT</th>
                                        <th>TYPE</th>
                                        <th>CODE</th>
                                        <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    </table>
                                </div>
                                <div id="pills-conduite" class="table-responsive">
                                    <table class="table table-sm table-bordered table-striped" id="table-conduite">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>PROVINCE</th>
                                        <th>COMMUNE</th>
                                        <th class="nowrap-header">NOM RESEAU</th>
                                        <th>FONCTIONAL</th>
                                        <th>ETAT</th>
                                        <th>DIAMETRE</th>
                                        <th>PN</th>
                                        <th>LONGUEUR</th>
                                        <th>MATERIAU</th>
                                        <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    </table>
                                </div>
                                <div id="pills-reservoir" class="table-responsive">

                                    <table class="table table-sm table-bordered table-striped" id="table-reservoir">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>PROVINCE</th>
                                        <th>COMMUNE</th>
                                        <th class="nowrap-header">NOM RESEAU</th>
                                        <th>FONCTIONAL</th>
                                        <th>ETAT</th>
                                        <th>VOLUME</th>
                                        <th>CODE</th>
                                        <th>ACTION</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    </table>
                                </div>
                                <div id="pills-bf" class="table-responsive">
                                    <table class="table table-sm table-bordered table-striped" id="table-bf">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>PROVINCE</th>
                                        <th>COMMUNE</th>
                                        <th class="nowrap-header">NOM RESEAU</th>
                                        <th>FONCTIONAL</th>
                                        <th>ETAT</th>
                                        <th>NOM</th>
                                        <th >BRANCHEMENT</th>
                                        <th>INSTITUTION</th>
                                        <th>COMPTEUR</th>
                                        <th>CODE</th>
                                        <th>ACTION</th>
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
        <div class="modal fade" id="staticInfra" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticInfraLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticInfraLabel"><strong id="modal-title">Ajouter Infrastructure</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="infra" name="infra">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="PROVINCE" class="form-label"><strong>Province</strong></label>
                                <select name="PROVINCE" id="PROVINCE" class="form-select" onchange="getCommunesByProvince(this.value)">
                                    <option value="">Sélectionner</option>
                                    <?php foreach ($provinces as $prov) {?>
                                        <option value="<?php echo $prov['PROVINCE_ID'] ?>"><?php echo $prov['PROVINCE_NAME'] ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="COMMUNE" class="form-label"><strong>Commune</strong></label>
                                <select name="COMMUNE" id="COMMUNE" class="form-select" onchange="getAepsByCommune(this.value)">
                                    <option value="">Sélectionner</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="AEP" class="form-label"><strong>AEP</strong></label>
                                <select name="AEP" id="AEP" class="form-select" >
                                    <option value="">Sélectionner</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="TYPE_INFRA_ID" class="form-label"><strong>Type Infrastructure</strong></label>
                                <select name="TYPE_INFRA_ID" id="TYPE_INFRA_ID" class="form-select" >
                                    <option value="">Sélectionner</option>
                                    <?php foreach ($type_infrastructure as $type_infra) {?>
                                        <option value="<?php echo $type_infra['TYPE_AEP_ID'] ?>"><?php echo $type_infra['DESCRIPTION'] ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="ETAT_ID" class="form-label"><strong>Etat</strong></label>
                                <select name="ETAT_ID" id="ETAT_ID" class="form-select" >
                                    <option value="1">BON ETAT</option>
                                    <option value="2">MAUVAIS ETAT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="FONCTIONNALITE_ID" class="form-label"><strong>Fonctionnel</strong></label>
                                <select name="FONCTIONNALITE_ID" id="FONCTIONNALITE_ID" class="form-select" >
                                    <option value="1">FONCTIONNEL</option>
                                    <option value="2">NON FONCTIONNEL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                            <label for="NOM" class="form-label"><strong>Nom</strong></label>
                            <input type="text" class="form-control" id="NOM" name="NOM">
                            </div>
                         </div>
                            <div class="col-md-4" id="inputcaptage">
                                <div class="mb-3">
                                <label for="DEBIT" class="form-label"><strong>Débit</strong></label>
                                <input type="number" class="form-control" id="DEBIT" name="DEBIT" min="0" step="any" >
                                </div>
                            </div>
                            <div class="col-md-4" id="inputchambre">
                                <div class="mb-3">
                                    <label for="TYPE_CHAMBRE_ID" class="form-label"><strong>Type Chambre</strong></label>
                                    <select name="TYPE_CHAMBRE_ID" id="TYPE_CHAMBRE_ID" class="form-select" >
                                        <option value="">Sélectionner</option>
                                        <?php foreach ($aep_type_chambre as $type_chambre) {?>
                                            <option value="<?php echo $type_chambre['TYPE_CHAMBRE_ID'] ?>"><?php echo $type_chambre['TYPE_CHAMBRE_DESCR'] ?></option>
                                        <?php }?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" id="inputreservoir">
                                <div class="mb-3">
                                <label for="DEBIT" class="form-label"><strong>Volume</strong></label>
                                <input type="number" class="form-control" id="VOLUME" name="VOLUME" min="0" step="any" >
                                </div>
                            </div>

                   </div>
                   <div id="inputbf">
                      <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="TYPE_BRANCHEMENT_ID" class="form-label"><strong>Type branchement</strong></label>
                                    <select name="TYPE_BRANCHEMENT_ID" id="TYPE_BRANCHEMENT_ID" class="form-select" >
                                        <option value="">Sélectionner</option>
                                        <?php foreach ($aep_type_branchement as $type_branchement) {?>
                                            <option value="<?php echo $type_branchement['TYPE_BRANCHEMENT_ID'] ?>"><?php echo $type_branchement['DESCRIPTION'] ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="BR_TYPE_INSTITUTION_ID" class="form-label"><strong>Type institution</strong></label>
                                    <select name="BR_TYPE_INSTITUTION_ID" id="BR_TYPE_INSTITUTION_ID" class="form-select" >
                                        <option value="">Sélectionner</option>
                                        <?php foreach ($aep_branchement_type_institution as $type_institution) {?>
                                            <option value="<?php echo $type_institution['BR_TYPE_INSTITUTION_ID'] ?>"><?php echo $type_institution['DESCRIPTION'] ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="NOM_INSTITUTION" class="form-label"><strong>Institution</strong></label>
                                    <input type="text" class="form-control" id="NOM_INSTITUTION" name="NOM_INSTITUTION" placeholder="Nom de l'institution" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="NUMERO_COMPTEUR" class="form-label"><strong>Numéro compteur</strong></label>
                                    <input type="text" class="form-control" id="NUMERO_COMPTEUR" name="NUMERO_COMPTEUR" placeholder="Numéro du compteur" >
                                </div>
                            </div>
                        </div>
                   </div>
                <div id="inputconduite">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                            <label for="DIAMETRE" class="form-label"><strong>Diamètre</strong></label>
                            <input type="number" class="form-control" id="DIAMETRE" name="DIAMETRE" step="any" min="0" >
                            </div>
                         </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                            <label for="PN" class="form-label"><strong>PN</strong></label>
                            <input type="number" class="form-control" id="PN" name="PN" step="any" min="0" >
                            </div>
                         </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                            <label for="LONGUEUR" class="form-label"><strong>Longueur</strong></label>
                            <input type="number" class="form-control" id="LONGUEUR" name="LONGUEUR" step="any" min="0" >
                            </div>
                         </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="MATERIEL_TYPE_ID" class="form-label"><strong>Matériau</strong></label>
                                    <select name="MATERIEL_TYPE_ID" id="MATERIEL_TYPE_ID" class="form-select" >
                                        <option value="">Sélectionner</option>
                                        <?php foreach ($aep_type_materiel as $materiel) {?>
                                            <option value="<?php echo $materiel['TYPE_MATERIEL_ID'] ?>"><?php echo $materiel['DESCRIPTION'] ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                    </div>
                    </div>
                     <input type="hidden" name="infra_id" id="infra_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submitForm(event)"><i class="bi bi-save"></i>Enregistrer</button>
            </div>
            </div>
        </div>
        </div>
        <?php echo view('includes/footer') ?>
<script>
// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    //default pill
    loadCaptageData()
    // Sélectionner tous les boutons des pills
    const triggerTabList = document.querySelectorAll('#pills-tab button');

    // Sélectionner tous les divs de contenu
    const contents = document.querySelectorAll('#pills-captage, #pills-chambre, #pills-conduite, #pills-reservoir, #pills-bf');

    // Initialisation : cacher tous les divs sauf le premier
    contents.forEach(content => {
        content.style.display = 'none';
    });
    document.getElementById('pills-captage').style.display = 'block';

    // Ajouter un événement pour chaque bouton
    triggerTabList.forEach(triggerEl => {
        triggerEl.addEventListener('click', function(event) {
            event.preventDefault();

            // Récupérer l'ID de la cible (ex: "#pills-captage")
            const targetId = this.getAttribute('data-bs-target');
            const divId = targetId.replace('#', '');
            const tab = new bootstrap.Tab(this);
            tab.show();

            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');

            // Cacher tous les divs
            contents.forEach(content => {
                content.style.display = 'none';
            });

            // Afficher le div correspondant
            const targetDiv = document.getElementById(divId);
            if (targetDiv) {
                targetDiv.style.display = 'block';
            }

            // Votre code personnalisé ici
            console.log('Onglet activé:', targetId);
            console.log('Div affiché:', divId);

            // Charger des données selon l'onglet
            switch(targetId) {
                case '#pills-captage':
                    loadCaptageData();
                    break;
                case '#pills-chambre':
                    loadChambreData();
                    break;
                case '#pills-conduite':
                    loadConduiteData();
                    break;
                case '#pills-reservoir':
                    loadReservoirData();
                    break;
                case '#pills-bf':
                    loadBfData();
                    break;
            }
        });
    });
});

// Fonctions pour charger les données
function loadCaptageData() {
            // Afficher l'overlay de chargement
            $('#loadingOverlay').show();
            var row_count = "1000000";
            $('#table-captage').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
                "oreder": [
                    [2, 'desc']
                ],
                "ajax": {
                    url: "<?php echo base_url('infrastructure/liste_captage') ?>",
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
                            "url": "<?php echo base_url('assets/js/') ?>French.json"
                         },
                complete: function() {

                        // Cacher l'overlay après la requête

                },
                initComplete: function(settings, json) {
                    // Code to execute after the initial data load and table draw
                    $('#loadingOverlay').hide();

                }


            });
}

function loadChambreData() {
            // Afficher l'overlay de chargement
            $('#loadingOverlay').show();
            var row_count = "1000000";
            $('#table-chambre').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
                "oreder": [
                    [2, 'desc']
                ],
                "ajax": {
                    url: "<?php echo base_url('infrastructure/liste_chambre') ?>",
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
                            "url": "<?php echo base_url('assets/js/') ?>French.json"
                         },
                complete: function() {

                        // Cacher l'overlay après la requête

                },
                initComplete: function(settings, json) {
                    // Code to execute after the initial data load and table draw
                    $('#loadingOverlay').hide();

                }


            });
}

function loadConduiteData() {
            // Afficher l'overlay de chargement
            $('#loadingOverlay').show();
            var row_count = "1000000";
            $('#table-conduite').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
                "oreder": [
                    [2, 'desc']
                ],
                "ajax": {
                    url: "<?php echo base_url('infrastructure/liste_conduite') ?>",
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
                            "url": "<?php echo base_url('assets/js/') ?>French.json"
                         },
                complete: function() {

                        // Cacher l'overlay après la requête

                },
                initComplete: function(settings, json) {
                    // Code to execute after the initial data load and table draw
                    $('#loadingOverlay').hide();

                }


            });
}

function loadReservoirData() {
            // Afficher l'overlay de chargement
            $('#loadingOverlay').show();
            var row_count = "1000000";
            $('#table-reservoir').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
                "oreder": [
                    [2, 'desc']
                ],
                "ajax": {
                    url: "<?php echo base_url('infrastructure/liste_reservoir') ?>",
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
                            "url": "<?php echo base_url('assets/js/') ?>French.json"
                         },
                complete: function() {

                        // Cacher l'overlay après la requête

                },
                initComplete: function(settings, json) {
                    // Code to execute after the initial data load and table draw
                    $('#loadingOverlay').hide();

                }


            });
}

function loadBfData() {
            // Afficher l'overlay de chargement
            $('#loadingOverlay').show();
            var row_count = "1000000";
            $('#table-bf').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
                "oreder": [
                    [2, 'desc']
                ],
                "ajax": {
                    url: "<?php echo base_url('infrastructure/liste_bf') ?>",
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
                            "url": "<?php echo base_url('assets/js/') ?>French.json"
                         },
                complete: function() {

                        // Cacher l'overlay après la requête

                },
                initComplete: function(settings, json) {
                    // Code to execute after the initial data load and table draw
                    $('#loadingOverlay').hide();

                }


            });
}
</script>
<script>
 function getCommunesByProvince(provinceId, targetSelectId = 'COMMUNE') {
    // Afficher un indicateur de chargement
    const selectElement = document.getElementById(targetSelectId);
    if (selectElement) {
        selectElement.innerHTML = '<option value="">Chargement...</option>';
        selectElement.disabled = true;
    }

    // Faire la requête AJAX
    fetch('<?php echo base_url("infrastructure/get_commune_by_province") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'province_id=' + encodeURIComponent(provinceId)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau');
        }
        return response.json();
    })
    .then(data => {
        // Remplir le select avec les communes
        if (selectElement) {
            selectElement.innerHTML = '<option value="">Sélectionnez une commune</option>';

            data.forEach(commune => {
                const option = document.createElement('option');
                option.value = commune.COMMUNE_ID;
                option.textContent = commune.COMMUNE_NAME;
                selectElement.appendChild(option);
            });

            selectElement.disabled = false;
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        if (selectElement) {
            selectElement.innerHTML = '<option value="">Erreur de chargement</option>';
            selectElement.disabled = false;
        }
        alert('Une erreur est survenue lors du chargement des communes');
    });
}

 function getAepsByCommune(communeId, targetSelectId = 'AEP') {
    // Afficher un indicateur de chargement
    const selectElement = document.getElementById(targetSelectId);
    if (selectElement) {
        selectElement.innerHTML = '<option value="">Chargement...</option>';
        selectElement.disabled = true;
    }

    // Faire la requête AJAX
    fetch('<?php echo base_url("infrastructure/get_aep_by_commune") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'commune_id=' + encodeURIComponent(communeId)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau');
        }
        return response.json();
    })
    .then(data => {
        // Remplir le select avec les aeps
        if (selectElement) {
            selectElement.innerHTML = '<option value="">Sélectionnez un aep</option>';

            data.forEach(aep => {
                const option = document.createElement('option');
                option.value = aep.AEP_ID;
                option.textContent = aep.NOM;
                selectElement.appendChild(option);
            });

            selectElement.disabled = false;
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        if (selectElement) {
            selectElement.innerHTML = '<option value="">Erreur de chargement</option>';
            selectElement.disabled = false;
        }
        alert('Une erreur est survenue lors du chargement des aeps');
    });
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cacher tous les champs spécifiques au départ
    hideAllSpecificFields();

    // Écouter le changement du type d'infrastructure
    const typeInfraSelect = document.getElementById('TYPE_INFRA_ID');
    typeInfraSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        showFieldsByInfraType(selectedValue);
    });

    // Écouter la soumission du formulaire
    const form = document.getElementById('infra');
    form.addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault();
            return false;
        }
    });
});

// Fonction pour cacher tous les champs spécifiques
function hideAllSpecificFields() {
    document.getElementById('inputcaptage').style.display = 'none';
    document.getElementById('inputchambre').style.display = 'none';
    document.getElementById('inputreservoir').style.display = 'none';
    document.getElementById('inputbf').style.display = 'none';
    document.getElementById('inputconduite').style.display = 'none';

    // Désactiver les champs pour éviter leur soumission
    disableFields('inputcaptage', true);
    disableFields('inputchambre', true);
    disableFields('inputreservoir', true);
    disableFields('inputbf', true);
    disableFields('inputconduite', true);
}

// Fonction pour activer/désactiver les champs d'un div
function disableFields(divId, disable) {
    const div = document.getElementById(divId);
    if (div) {
        const inputs = div.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.disabled = disable;
            if (!disable) {
                // Supprimer l'attribut disabled au lieu de le mettre à false
                input.removeAttribute('disabled');
            } else {
                input.setAttribute('disabled', 'disabled');
            }
        });
    }
}

// Fonction pour afficher les champs selon le type d'infrastructure
function showFieldsByInfraType(typeId) {
    // Cacher d'abord tous les champs spécifiques
    hideAllSpecificFields();

    // Afficher les champs correspondant au type sélectionné
    switch(typeId) {
        case '1': // Captage
            document.getElementById('inputcaptage').style.display = 'block';
            disableFields('inputcaptage', false);
            break;
        case '2': // Chambre
            document.getElementById('inputchambre').style.display = 'block';
            disableFields('inputchambre', false);
            break;
        case '3': // Conduite
            document.getElementById('inputconduite').style.display = 'block';
            disableFields('inputconduite', false);
            break;
        case '4': // Réservoir
            document.getElementById('inputreservoir').style.display = 'block';
            disableFields('inputreservoir', false);
            break;
        case '5': // Branchement (BF)
            document.getElementById('inputbf').style.display = 'block';
            disableFields('inputbf', false);
            break;
        default:
            // Si aucun type sélectionné, tout est caché
            break;
    }
}

// Fonction de validation du formulaire
function validateForm() {
    let isValid = true;
    let errorMessages = [];

    // Réinitialiser les styles d'erreur
    removeErrorStyles();

    // Validation de la province
    const province = document.getElementById('PROVINCE');
    if (!province.value) {
        addErrorStyle(province);
        errorMessages.push('Veuillez sélectionner une province');
        isValid = false;
    }

    // Validation de la commune
    const commune = document.getElementById('COMMUNE');
    if (!commune.value) {
        addErrorStyle(commune);
        errorMessages.push('Veuillez sélectionner une commune');
        isValid = false;
    }

    // Validation de l'AEP
    const aep = document.getElementById('AEP');
    if (!aep.value) {
        addErrorStyle(aep);
        errorMessages.push('Veuillez sélectionner une AEP');
        isValid = false;
    }

    // Validation du type d'infrastructure
    const typeInfra = document.getElementById('TYPE_INFRA_ID');
    if (!typeInfra.value) {
        addErrorStyle(typeInfra);
        errorMessages.push('Veuillez sélectionner un type d\'infrastructure');
        isValid = false;
    }

    // Validation de l'état
    const etat = document.getElementById('ETAT_ID');
    if (!etat.value) {
        addErrorStyle(etat);
        errorMessages.push('Veuillez sélectionner un état');
        isValid = false;
    }

    // Validation de la fonctionnalité
    const fonctionnalite = document.getElementById('FONCTIONNALITE_ID');
    if (!fonctionnalite.value) {
        addErrorStyle(fonctionnalite);
        errorMessages.push('Veuillez sélectionner une fonctionnalité');
        isValid = false;
    }

    // Validation du nom
    const nom = document.getElementById('NOM');
    if (!nom.value.trim()) {
        addErrorStyle(nom);
        errorMessages.push('Veuillez saisir un nom');
        isValid = false;
    }

    // Validations spécifiques selon le type d'infrastructure
    const typeId = typeInfra.value;

    if (typeId === '1') { // Captage
        const debit = document.getElementById('DEBIT');
        if (!debit.value || parseFloat(debit.value) <= 0) {
            addErrorStyle(debit);
            errorMessages.push('Veuillez saisir un débit valide (supérieur à 0)');
            isValid = false;
        }
    }
    else if (typeId === '2') { // Chambre
        const typeChambre = document.getElementById('TYPE_CHAMBRE_ID');
        if (!typeChambre.value) {
            addErrorStyle(typeChambre);
            errorMessages.push('Veuillez sélectionner un type de chambre');
            isValid = false;
        }
    }
    else if (typeId === '3') { // Conduite
        const diametre = document.getElementById('DIAMETRE');
        const pn = document.getElementById('PN');
        const longueur = document.getElementById('LONGUEUR');
        const materiau = document.getElementById('MATERIEL_TYPE_ID');

        if (!diametre.value || parseFloat(diametre.value) <= 0) {
            addErrorStyle(diametre);
            errorMessages.push('Veuillez saisir un diamètre valide');
            isValid = false;
        }

        if (!pn.value || parseFloat(pn.value) <= 0) {
            addErrorStyle(pn);
            errorMessages.push('Veuillez saisir un PN valide');
            isValid = false;
        }

        if (!longueur.value || parseFloat(longueur.value) <= 0) {
            addErrorStyle(longueur);
            errorMessages.push('Veuillez saisir une longueur valide');
            isValid = false;
        }

        if (!materiau.value) {
            addErrorStyle(materiau);
            errorMessages.push('Veuillez sélectionner un matériau');
            isValid = false;
        }
    }
    else if (typeId === '4') { // Réservoir
        const volume = document.getElementById('VOLUME');
        if (!volume.value || parseFloat(volume.value) <= 0) {
            addErrorStyle(volume);
            errorMessages.push('Veuillez saisir un volume valide');
            isValid = false;
        }
    }
    else if (typeId === '5') { // Branchement
        const typeBranchement = document.getElementById('TYPE_BRANCHEMENT_ID');
        const nominstitution = document.getElementById('NOM_INSTITUTION');
        const typeinstitution = document.getElementById('BR_TYPE_INSTITUTION_ID');
        if (!typeBranchement.value) {
            addErrorStyle(typeBranchement);
            errorMessages.push('Veuillez sélectionner un type de branchement');
            isValid = false;
        }
       // Si le type de branchement est "privé", alors les champs liés à l'institution deviennent obligatoires
        if(typeBranchement.value && typeBranchement.value == '1') {

                if (!nominstitution.value.trim()) {
                    addErrorStyle(nominstitution);
                    errorMessages.push('Veuillez saisir le nom de l\'institution');
                    isValid = false;
                }
                if (!typeinstitution.value) {
                    addErrorStyle(typeinstitution);
                    errorMessages.push('Veuillez sélectionner un type d\'institution');
                    isValid = false;
                }
        }
    }

    // Afficher les messages d'erreur si nécessaire
    if (!isValid) {
        showErrorMessages(errorMessages);
    }

    return isValid;
}

// Fonction pour ajouter le style d'erreur
function addErrorStyle(element) {
    element.classList.add('is-invalid');

    // Créer ou mettre à jour le message d'erreur
    let feedback = element.nextElementSibling;
    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
        feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        element.parentNode.insertBefore(feedback, element.nextSibling);
    }
}

// Fonction pour retirer les styles d'erreur
function removeErrorStyles() {
    document.querySelectorAll('.is-invalid').forEach(element => {
        element.classList.remove('is-invalid');
    });

    document.querySelectorAll('.invalid-feedback').forEach(element => {
        element.remove();
    });
}

// Fonction pour afficher les messages d'erreur
function showErrorMessages(messages) {
    // Créer une alerte en haut du formulaire
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
    alertDiv.setAttribute('role', 'alert');

    const title = document.createElement('strong');
    title.textContent = 'Erreur de validation :';
    alertDiv.appendChild(title);

    const list = document.createElement('ul');
    list.className = 'mb-0 mt-2';

    messages.forEach(message => {
        const item = document.createElement('li');
        item.textContent = message;
        list.appendChild(item);
    });

    alertDiv.appendChild(list);

    // Bouton de fermeture
    const closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.className = 'btn-close';
    closeBtn.setAttribute('data-bs-dismiss', 'alert');
    closeBtn.setAttribute('aria-label', 'Close');
    alertDiv.appendChild(closeBtn);

    // Insérer l'alerte en haut du formulaire
    const form = document.getElementById('infra');
    form.insertBefore(alertDiv, form.firstChild);

    // Auto-fermeture après 5 secondes
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

</script>
<script>
// Fonction pour soumettre le formulaire en AJAX
function submitForm(event) {
    event.preventDefault();

    // Valider d'abord le formulaire
    if (!validateForm()) {
        return false;
    }

    // Afficher un indicateur de chargement
    showLoading(true);

    // Récupérer le formulaire
    const form = document.getElementById('infra');
    const formData = new FormData(form);

    // Envoyer les données
    fetch('<?php echo base_url("infrastructure/enregistrer_infra") ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau');
        }
        return response.json();
    })
    .then(data => {
        // Cacher le chargement
        showLoading(false);

        // Traiter la réponse
        if (data.success) {
            // Succès
            showNotification('success', data.message || 'Enregistrement réussi !');
            form.reset(); // Réinitialiser le formulaire
            hideAllSpecificFields(); // Cacher les champs spécifiques

            // Rediriger ou mettre à jour la liste
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            } else {
                // Recharger le tableau ou mettre à jour l'affichage
                refreshDataTable();
            }
        } else {
            // Erreur de validation
            if (data.errors) {
                displayValidationErrors(data.errors);
            } else {
                showNotification('error', data.message || 'Erreur lors de l\'enregistrement');
            }
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showLoading(false);
        showNotification('error', 'Une erreur est survenue. Veuillez réessayer.');
    });

    return false;
}
//ovarlay de chargement
function showLoading(show) {
    const loadingIndicator = document.getElementById('loadingOverlay');
    if (show) {
        loadingIndicator.style.display = 'block';
    } else {
        loadingIndicator.style.display = 'none';
    }
}

// Afficher une notification
function showNotification(type, message) {
    // Supprimer les anciennes notifications
    const oldAlerts = document.querySelectorAll('.alert-notification');
    oldAlerts.forEach(alert => alert.remove());

    // Créer la nouvelle notification
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show alert-notification`;
    notification.setAttribute('role', 'alert');
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';

    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    document.body.appendChild(notification);

    // Auto-fermeture après 5 secondes
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Rafraîchir le DataTable après soumission
function refreshDataTable() {
    // Déterminer quel DataTable rafraîchir selon l'onglet actif
    const activeTab = document.querySelector('#pills-tab button.active');
    if (activeTab) {
        const targetId = activeTab.getAttribute('data-bs-target').replace('#pills-', '');

        // Rafraîchir le DataTable correspondant
        switch(targetId) {
            case 'captage':
                if ($.fn.DataTable.isDataTable('#table-captage')) {
                    $('#table-captage').DataTable().ajax.reload();
                }
                break;
            case 'chambre':
                if ($.fn.DataTable.isDataTable('#table-chambre')) {
                    $('#table-chambre').DataTable().ajax.reload();
                }
                break;
            case 'conduite':
                if ($.fn.DataTable.isDataTable('#table-conduite')) {
                    $('#table-conduite').DataTable().ajax.reload();
                }
                break;
            case 'reservoir':
                if ($.fn.DataTable.isDataTable('#table-reservoir')) {
                    $('#table-reservoir').DataTable().ajax.reload();
                }
                break;
            case 'bf':
                if ($.fn.DataTable.isDataTable('#table-bf')) {
                    $('#table-bf').DataTable().ajax.reload();
                }
                break;
        }
    }
}
</script>
<script>

// Fonction pour ouvrir le formulaire en mode édition
function modifier(infraId) {
    // Afficher un loader
    showLoading(true);

    // Réinitialiser le formulaire
    // resetForm();

    // Récupérer les données de l'infrastructure
    fetch('<?php echo base_url("infrastructure/get") ?>/' + infraId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remplir le formulaire avec les données
            fillFormData(data.data);

            // Stocker l'ID en modification
            // editingId = infraId;
            // document.getElementById('infra_id').dataset.infraId = infraId;

            // Changer le titre
            document.getElementById('modal-title').innerHTML = 'Modifier infrastructure';

            // Afficher le modal
            const modal = new bootstrap.Modal(document.getElementById('staticInfra'));
            modal.show();
        } else {
            showNotification('error', data.message || 'Erreur lors du chargement des données');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('error', 'Erreur de chargement des données');
    })
    .finally(() => {
        showLoading(false);
    });
}

// Fonction pour remplir le formulaire avec les données
function fillFormData(data) {
    // console.log('Données à remplir:', data);

    // Remplir les champs de base
    setSelectValue('PROVINCE', data.PROVINCE_ID);

    // Charger les communes puis sélectionner
    if (data.PROVINCE_ID) {
        loadCommunesAndSelect(data.PROVINCE_ID, data.COMMUNE_ID);
    }

    // Charger les AEP puis sélectionner
    if (data.COMMUNE_ID) {
        loadAepsAndSelect(data.COMMUNE_ID, data.AEP_ID);
    }

    setSelectValue('TYPE_INFRA_ID', data.TYPE_INFRA_ID);
    setSelectValue('ETAT_ID', data.ETAT_ID);
    setSelectValue('FONCTIONNALITE_ID', data.FONCTIONNALITE_ID);
    setSelectValue('BR_TYPE_INSTITUTION_ID', data.BR_TYPE_INSTITUTION_ID);

    document.getElementById('NOM').value = data.NOM || '';
    document.getElementById('NOM_INSTITUTION').value = data.NOM_INSTITUTION || '';
    document.getElementById('NUMERO_COMPTEUR').value = data.NUMERO_COMPTEUR || '';
    document.getElementById('infra_id').value = data.INFRA_ID || 0;

    // Afficher les champs spécifiques selon le type
    showFieldsByInfraType(data.TYPE_INFRA_ID);

    // Remplir les champs spécifiques
    if (data.TYPE_INFRA_ID == 1) { // Captage
        document.getElementById('DEBIT').value = data.DEBIT || '';
    }
    else if (data.TYPE_INFRA_ID == 2) { // Chambre
        setSelectValue('TYPE_CHAMBRE_ID', data.TYPE_CHAMBRE_ID);
    }
    else if (data.TYPE_INFRA_ID == 3) { // Conduite
        document.getElementById('DIAMETRE').value = data.DIAMETRE || '';
        document.getElementById('PN').value = data.PN || '';
        document.getElementById('LONGUEUR').value = data.LONGUEUR || '';
        setSelectValue('MATERIEL_TYPE_ID', data.MATERIEL_TYPE_ID);
    }
    else if (data.TYPE_INFRA_ID == 4) { // Réservoir
        document.getElementById('VOLUME').value = data.VOLUME || '';
    }
    else if (data.TYPE_INFRA_ID == 5) { // Branchement
        setSelectValue('TYPE_BRANCHEMENT_ID', data.TYPE_BRANCHEMENT_ID);
    }
}

// Fonction utilitaire pour sélectionner une valeur dans un select
function setSelectValue(selectId, value) {
    const select = document.getElementById(selectId);
    if (select && value) {
        select.value = value;
    }
}


// Fonction pour charger les communes et sélectionner une valeur
function loadCommunesAndSelect(provinceId, communeId) {
    const communeSelect = document.getElementById('COMMUNE');

    if (!provinceId) return;

    fetch('<?php echo base_url("infrastructure/get_commune_by_province") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'province_id=' + encodeURIComponent(provinceId)
    })
    .then(response => response.json())
    .then(data => {
        communeSelect.innerHTML = '<option value="">Sélectionnez une commune</option>';

        data.forEach(commune => {
            const option = document.createElement('option');
            option.value = commune.COMMUNE_ID;
            option.textContent = commune.COMMUNE_NAME;
            if (commune.COMMUNE_ID == communeId) {
                option.selected = true;
            }
            communeSelect.appendChild(option);
        });

        communeSelect.disabled = false;
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}

// Fonction pour charger les AEP et sélectionner une valeur
function loadAepsAndSelect(communeId, aepId) {
    const aepSelect = document.getElementById('AEP');

    if (!communeId) return;

    fetch('<?php echo base_url("infrastructure/get_aep_by_commune") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'commune_id=' + encodeURIComponent(communeId)
    })
    .then(response => response.json())
    .then(data => {
        aepSelect.innerHTML = '<option value="">Sélectionnez une AEP</option>';

        data.forEach(aep => {
            const option = document.createElement('option');
            option.value = aep.AEP_ID;
            option.textContent = aep.NOM;
            if (aep.AEP_ID == aepId) {
                option.selected = true;
            }
            aepSelect.appendChild(option);
        });

        aepSelect.disabled = false;
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}
</script>