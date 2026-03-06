<?php
    echo view('includes/head');
?>

 <style>
.modal-header.bg-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.detail-label {
    font-weight: 600;
    color: #495057;
    width: 140px;
}

.detail-value {
    color: #212529;
}

.card {
    border: 1px solid rgba(0,0,0,.125);
    box-shadow: 0 2px 4px rgba(0,0,0,.05);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0,0,0,.125);
    font-weight: 500;
}

.table-borderless th {
    width: 140px;
    color: #6c757d;
    font-weight: 500;
}

.badge {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}
</style>

<?php echo view('includes/sidebar') ?>
    <!--begin::App Main-->
        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Maintenance</h3>
                        </div>
                        <div class="col-sm-6">

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

                    <div class="row">
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="COMMUNE" class="form-label"><strong>Commune</strong></label>
                                <select name="COMMUNE" id="COMMUNE" class="form-select" onchange="getAepsByCommune(this.value)">
                                    <option value="">Sélectionner</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="AEP" class="form-label"><strong>AEP</strong></label>
                                <select name="AEP" id="AEP" class="form-select"  onchange="loadMaintenanceData()">
                                    <option value="">Sélectionner</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="STATUT_ID" class="form-label"><strong>Statut</strong></label>
                                <select name="STATUT_ID" id="STATUT_ID" class="form-select" onchange="loadMaintenanceData()" >
                                    <option value="0">Validation en attente</option>
                                    <option value="1">Validation approuvée</option>
                                </select>
                            </div>
                        </div>
                    </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success" onclick="validerSelection()" id="btnValider">
                                            <i class="bi bi-check-all"></i> Valider la sélection
                                        </button>
                                        <button type="button" class="btn btn-secondary" onclick="selectAll()">
                                            <i class="bi bi-check-square"></i> Tout sélectionner
                                        </button>
                                        <button type="button" class="btn btn-light" onclick="deselectAll()">
                                            <i class="bi bi-square"></i> Tout désélectionner
                                        </button>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <span id="selectedCount" class="badge bg-primary">0 sélectionné(s)</span>
                                    </div>
                                </div>
                                    <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-striped" id="table-maintenance">
                                    <thead>
                                        <tr>
                                        <th></th>
                                        <th>TYPE</th>
                                        <th>CODE</th>
                                        <th>NOM</th>
                                        <th class="nowrap-header">DATE MAINTENANCE</th>
                                        <th class="nowrap-header">Obs. AU TERRAIN</th>
                                        <th class="nowrap-header">Obs.VALIDATION</th>
                                        <th>UTILISATEUR</th>
                                        <th>VALIDATEUR</th>
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
<!-- Modal de validation groupée -->
<div class="modal fade" id="validationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle"></i>
                    Valider <span id="modalSelectedCount">0</span> maintenance(s)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="modalObservation" class="form-label">
                        <strong>Observation de validation</strong>
                    </label>
                    <textarea class="form-control" id="modalObservation" rows="4"
                              placeholder="Saisissez vos observations..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Annuler
                </button>
                <button type="button" class="btn btn-success" onclick="submitValidation()">
                    <i class="bi bi-check-all"></i> Valider
                </button>
            </div>
        </div>
    </div>
</div>



        <?php echo view('includes/footer') ?>
        <script>
// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    //default pill
    loadMaintenanceData()
});

function loadMaintenanceData() {
            // Afficher l'overlay de chargement
            var statutId = document.getElementById('STATUT_ID').value;
            var aepId = document.getElementById('AEP').value;
            $('#loadingOverlay').show();
            var row_count = "1000000";
            $('#table-maintenance').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
                "oreder": [
                    [2, 'desc']
                ],
                "ajax": {
                    url: "<?php echo base_url('infrastructure/liste_maintenance') ?>",
                    type: "POST",
                    data: {STATUT_ID:statutId, AEP_ID:aepId}
                },
                lengthMenu: [
                    [10, 50, 100, row_count],
                    [10, 50, 100, "All"]
                ],
                pageLength: 10,
                "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                }],

                // dom: 'Bfrtlip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ],
                language: {
                            "url": "<?php echo base_url('assets/js/') ?>French.json"
                         },
                complete: function() {

                        // Cacher l'overlay après la requête

                },
                initComplete: function(settings, json) {
                    // Code to execute after the initial data load and table draw
                    $('#loadingOverlay').hide();

                },
                    "drawCallback": function(settings) {
                        // Réinitialiser la sélection après chaque rafraîchissement
                        deselectAll();
                    }


            });
}
        </script>
<script>
let selectedIds = [];

function modifier(id) {
    // Votre fonction existante pour voir les détails
}

function selectAll() {
    document.querySelectorAll('.select-row').forEach(checkbox => {
        checkbox.checked = true;
    });
    updateSelectedIds();
}

function deselectAll() {
    document.querySelectorAll('.select-row').forEach(checkbox => {
        checkbox.checked = false;
    });
    updateSelectedIds();
}

function updateSelectedIds() {
    selectedIds = [];
    document.querySelectorAll('.select-row:checked').forEach(checkbox => {
        selectedIds.push(checkbox.value);
    });

    // Mettre à jour le compteur
    document.getElementById('selectedCount').textContent = selectedIds.length + ' sélectionné(s)';

    // Activer/désactiver le bouton de validation
    document.getElementById('btnValider').disabled = selectedIds.length === 0;
}

function validerSelection() {
    if (selectedIds.length === 0) {
        alert('Veuillez sélectionner au moins une maintenance');
        return;
    }

    // Ouvrir le modal de validation
    const modal = new bootstrap.Modal(document.getElementById('validationModal'));

    // Mettre à jour le compteur dans le modal
    document.getElementById('modalSelectedCount').textContent = selectedIds.length;

    // Vider le champ d'observation
    document.getElementById('modalObservation').value = '';

    modal.show();
}

// Fonction pour soumettre la validation groupée
function submitValidation() {
    const observation = document.getElementById('modalObservation').value.trim();

    if (!observation) {
        // alert('Veuillez saisir une observation');
        showNotification('danger', 'Veuillez saisir une observation');
        return;
    }

    showLoading(true);

    fetch('<?php echo base_url("infrastructure/validerMdata") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            ids: selectedIds,
            observation: observation
        })
    })
    .then(response => response.json())
    .then(data => {
        showLoading(false);

        if (data.success) {
            // Fermer le modal
            bootstrap.Modal.getInstance(document.getElementById('validationModal')).hide();

            // Afficher le message de succès
            // alert(data.message);
            showNotification('success', data.message);

            // Rafraîchir le DataTable
            $('#table-maintenance').DataTable().ajax.reload();

            // Réinitialiser la sélection
            deselectAll();
        } else {
            // alert(data.message || 'Erreur lors de la validation');
            showNotification('danger', data.message || 'Erreur lors de la validation');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showLoading(false);
        // alert('Erreur de connexion au serveur');
        showNotification('danger', 'Erreur de connexion au serveur');
    });
}

// Initialisation au chargement du DataTable
$(document).ready(function() {
    // Désactiver le bouton de validation au départ
    document.getElementById('btnValider').disabled = true;

    // Surveiller les changements des cases à cocher
    $(document).on('change', '.select-row', function() {
        updateSelectedIds();
    });
});

function showLoading(show) {
    if (show) {
        $('#loadingOverlay').show();
    } else {
        $('#loadingOverlay').hide();
    }
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
</script>
<script>
function voirDetails(id) {
    showLoading(true);

    fetch('<?php echo base_url("infrastructure/getDetailsMaintenance") ?>/' + id, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        showLoading(false);

        if (data.success) {
            afficherDetails(data.data);
        } else {
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => {
        showLoading(false);
        console.error('Erreur:', error);
        alert('Erreur de connexion');
    });
}

function afficherDetails(m) {
    // Créer le contenu du modal
    const photoHtml = m.PHOTO ?
        `<img src="<?php echo base_url('uploads/maintenance/') ?>${m.PHOTO}" class="img-fluid" style="max-height: 300px;">` :
        '<p class="text-muted">Aucune photo disponible</p>';

    const statutBadge = m.STATUT_ID == 1 ?
        '<span class="badge bg-success">Validé</span>' :
        '<span class="badge bg-warning">En attente</span>';

    const content = `
        <div class="modal fade" id="detailsModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-clipboard-data"></i>
                            Détails de la maintenance #${m.CODE}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <strong><i class="bi bi-info-circle"></i> Informations générales</strong>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <th>Statut:</th>
                                                <td>${statutBadge}</td>
                                            </tr>
                                            <tr>
                                                <th>Code infrastructure:</th>
                                                <td><strong>${m.CODE}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Nom infrastructure:</th>
                                                <td>${m.NOM}</td>
                                            </tr>
                                            <tr>
                                                <th>AEP:</th>
                                                <td>${m.AEP}</td>
                                            </tr>
                                            <tr>
                                                <th>Type:</th>
                                                <td>${m.TYPE}</td>
                                            </tr>
                                            <tr>
                                                <th>Province:</th>
                                                <td>${m.PROVINCE_NAME}</td>
                                            </tr>
                                            <tr>
                                                <th>Commune:</th>
                                                <td>${m.COMMUNE_NAME}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <strong><i class="bi bi-calendar"></i> Dates et intervenants</strong>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <th>Date maintenance:</th>
                                                <td>${m.DATE_MAINTENANCE}</td>
                                            </tr>
                                            <tr>
                                                <th>Date enregistrement:</th>
                                                <td>${m.DATE_ENREGISTREMENT}</td>
                                            </tr>
                                            <tr>
                                                <th>Date validation:</th>
                                                <td>${m.DATE_MODIFICATION}</td>
                                            </tr>

                                            <tr>
                                                <th>Collecteur:</th>
                                                <td><i class="bi bi-person"></i> ${m.COLLECTEUR}</td>
                                            </tr>
                                            <tr>
                                                <th>Validateur:</th>
                                                <td><i class="bi bi-person-check"></i> ${m.VALIDATEUR || '-'}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <strong><i class="bi bi-chat"></i> Commentaires</strong>
                                    </div>
                                    <div class="card-body">
                                        <p>${m.COMMENTAIRE || '<em class="text-muted">Aucun commentaire</em>'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <strong><i class="bi bi-check-circle"></i> Validation</strong>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Observation:</strong> ${m.OBSERVATION_VALIDATION || '<em class="text-muted">Aucune observation</em>'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <strong><i class="bi bi-image"></i> Photo</strong>
                                    </div>
                                    <div class="card-body text-center">
                                        ${photoHtml}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x"></i> Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Supprimer l'ancien modal s'il existe
    const oldModal = document.getElementById('detailsModal');
    if (oldModal) oldModal.remove();

    // Ajouter le nouveau modal
    document.body.insertAdjacentHTML('beforeend', content);

    // Afficher le modal
    const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
    modal.show();
}
</script>