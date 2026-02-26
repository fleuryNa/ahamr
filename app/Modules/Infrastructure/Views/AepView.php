<?php
    echo view('includes/head');
?>
<?php echo view('includes/sidebar') ?>
<style>
.upload-area {
    border: 2px dashed #ccc;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.upload-area:hover, .upload-area.dragover {
    border-color: #007bff;
    background-color: #f1f8ff;
}

.upload-area input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.upload-area .upload-icon {
    font-size: 48px;
    color: #007bff;
    margin-bottom: 10px;
}

.upload-area .upload-text {
    font-size: 16px;
    color: #666;
}

.upload-area .upload-hint {
    font-size: 12px;
    color: #999;
    margin-top: 5px;
}

/* Liste des fichiers sélectionnés */
.selected-files {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    max-height: 200px;
    overflow-y: auto;
}

.files-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.file-item {
    display: flex;
    align-items: center;
    padding: 8px;
    border-bottom: 1px solid #eee;
    animation: fadeIn 0.3s ease;
}

.file-item:last-child {
    border-bottom: none;
}

.file-item .file-icon {
    margin-right: 10px;
    font-size: 20px;
}

.file-item .file-icon.pdf { color: #dc3545; }
.file-item .file-icon.doc { color: #2b5797; }
.file-item .file-icon.xls { color: #1e7145; }
.file-item .file-icon.jpg, .file-item .file-icon.png { color: #f4b400; }
.file-item .file-icon.txt { color: #6c757d; }

.file-item .file-info {
    flex-grow: 1;
}

.file-item .file-name {
    font-weight: 500;
}

.file-item .file-size {
    font-size: 12px;
    color: #666;
    margin-left: 10px;
}

.file-item .file-remove {
    color: #dc3545;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.file-item .file-remove:hover {
    background-color: #dc3545;
    color: white;
}

/* Barre de progression */
.upload-progress {
    margin-top: 15px;
    display: none;
}

.upload-progress.show {
    display: block;
}

.progress {
    height: 25px;
    border-radius: 5px;
}

.progress-bar {
    background-color: #28a745;
    transition: width 0.3s ease;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Badge pour le compteur */
.files-counter {
    background-color: #007bff;
    color: white;
    border-radius: 20px;
    padding: 2px 10px;
    font-size: 12px;
    margin-left: 10px;
}
</style>
    <!--begin::App Main-->
        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">AEP</h3>
                        </div>
                        <div class="col-sm-6 text-end">
                            <div id="pills-aep-btn">
                            <button  class="lodge-primary"  data-bs-toggle="modal" data-bs-target="#staticAep" onclick="openAddAepForm()">Nouveau</button>
                            </div>
                            <div id="pills-gestion-btn">
                              <button  class="lodge-primary"  data-bs-toggle="modal" data-bs-target="#staticGestion">Nouveau</button>
                            </div>
                            <div id="pills-archivage-btn">
                              <button  class="lodge-primary"  data-bs-toggle="modal" data-bs-target="#staticArchivage">Nouveau</button>
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
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-aep-tab" data-bs-toggle="pill" data-bs-target="#pills-aep" type="button" role="tab" aria-controls="pills-aep" aria-selected="true">AEP</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-gestion-tab" data-bs-toggle="pill" data-bs-target="#pills-gestion" type="button" role="tab" aria-controls="pills-gestion" aria-selected="false">Gestion et exploitation du service</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-archivage-tab" data-bs-toggle="pill" data-bs-target="#pills-archivage" type="button" role="tab" aria-controls="pills-archivage" aria-selected="false">Archivage des rapports</button>
                                    </li>
                                </ul>
                                <div id="pills-aep" class="table-responsive">
                                    <table class="table table-sm table-bordered table-striped" id="table-aep">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>LOCALITE</th>
                                        <th class="nowrap-header">NOM RESEAU</th>
                                        <th>CODE</th>
                                        <th class="nowrap-header">ANNE MISE EN SERVICE</th>
                                        <th class="nowrap-header">LINEAIRE DU RESEAU</th>
                                        <th>EXECUTANT</th>
                                        <th class="nowrap-header">MAITRE D'OEUVRE</th>
                                        <th class="nowrap-header">P.COMMUNE (INITIALE)</th>
                                        <th class="nowrap-header">P.DESSERVIE PAR LE RESEAU</th>
                                        <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    </table>
                                </div>
                               <div id="pills-gestion" class="table-responsive">
                                    <table class="table table-sm table-bordered table-striped" id="table-gestion">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>AEP</th>
                                        <th>TYPE</th>
                                        <th>NOM</th>
                                        <th>CONTACT</th>
                                        <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    </table>
                                </div>
                               <div id="pills-archivage" class="table-responsive">
                                    <table class="table table-sm table-bordered table-striped" id="table-archivage">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>AEP</th>
                                        <th class="nowrap-header">TYPE DOCUMENT</th>
                                        <th>DOCUMENT</th>
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
        <div class="modal fade" id="staticAep" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticAepLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticAepLabel"><strong>Ajout AEP</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="formAEP" name="formAEP">
                    <!-- Ligne 1: Informations de base -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="NOM" class="form-label">
                                    <strong>Nom de l'AEP</strong>
                                </label>
                                <input type="text" class="form-control" id="NOM" name="NOM"
                                     maxlength="255" required>
                                <div class="invalid-feedback">Le nom est requis</div>
                            </div>
                        </div>
                    </div>

                    <!-- Ligne 2: Localisation géographique -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="PROVINCE_ID" class="form-label">
                                    <strong>Province</strong>
                                </label>
                                <select name="PROVINCE_ID" id="PROVINCE_ID" class="form-select" required>
                                    <option value="">Sélectionner</option>
                                    <?php foreach ($provinces as $province): ?>
                                        <option value="<?php echo $province['PROVINCE_ID'] ?>">
                                            <?php echo $province['PROVINCE_NAME'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Veuillez sélectionner une province</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="COMMUNE_ID" class="form-label">
                                    <strong>Commune</strong>
                                </label>
                                <select name="COMMUNE_ID" id="COMMUNE_ID" class="form-select" required>
                                    <option value="">Sélectionner</option>
                                </select>
                                <div class="invalid-feedback">Veuillez sélectionner une commune</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="ZONE_ID" class="form-label">
                                    <strong>Zone</strong>
                                </label>
                                <select name="ZONE_ID" id="ZONE_ID" class="form-select">
                                    <option value="">Sélectionner</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Ligne 3: Localisation détaillée -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="COLLINE_ID" class="form-label">
                                    <strong>Colline</strong>
                                </label>
                                <select name="COLLINE_ID" id="COLLINE_ID" class="form-select">
                                    <option value="">Sélectionner</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="SOUS_COLLINE" class="form-label">
                                    <strong>Sous-colline / Quartier</strong>
                                </label>
                                <input type="text" class="form-control" id="SOUS_COLLINE" name="SOUS_COLLINE"
                                     maxlength="255">
                            </div>
                        </div>
                    </div>

                    <!-- Ligne 4: Informations techniques -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="ANNEE_MISE_EN_SERVICE" class="form-label">
                                    <strong>Année de mise en service</strong>
                                </label>
                                <input type="number" class="form-control" id="ANNEE_MISE_EN_SERVICE"
                                    name="ANNEE_MISE_EN_SERVICE" min="1900" max="2099"
                                    placeholder="Ex: 2020" step="1">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="LINEAIRE_RESEAU" class="form-label">
                                    <strong>Linéaire du réseau</strong>
                                </label>
                                <input type="number" class="form-control" id="LINEAIRE_RESEAU"
                                    name="LINEAIRE_RESEAU" min="0" step="any"
                                    >
                            </div>
                        </div>
                    </div>

                    <!-- Ligne 5: Informations sur les responsables -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="EXECUTANT" class="form-label">
                                    <strong>Exécutant / Constructeur</strong>
                                </label>
                                <input type="text" class="form-control" id="EXECUTANT" name="EXECUTANT" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="MAITRE_OEUVRE" class="form-label">
                                    <strong>Maître d'œuvre</strong>
                                </label>
                                <input type="text" class="form-control" id="MAITRE_OEUVRE" name="MAITRE_OEUVRE"
                                     maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="row">


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="POPULATION_COMMUNE_INITIAL" class="form-label">
                                    <strong>Population commune (initiale)</strong>
                                </label>
                                <input type="number" class="form-control" id="POPULATION_COMMUNE_INITIAL" name="POPULATION_COMMUNE_INITIAL">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="POPULATION_DESSERVIE" class="form-label">
                                    <strong>Population desservie par le reseau</strong>
                                </label>
                                <input type="number" class="form-control" id="POPULATION_DESSERVIE" name="POPULATION_DESSERVIE"
                                     >
                            </div>
                        </div>
                    </div>
                    <!-- Champ caché pour l'ID (en mode modification) -->
                    <input type="hidden" name="AEP_ID" id="AEP_ID">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submitForm(event)"><i class="bi bi-save"></i>Enregistrer</button>
            </div>
            </div>
        </div>
        </div>


<!-- Modal Situation gestion et exploitation du service -->
<div class="modal fade" id="staticGestion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticGestionLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticGestionLabel"><strong>Gestion et Exploitation du service</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form action="" method="post" id="formExploitant" name="formExploitant">
    <!-- Ligne 1: Informations personnelles -->
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="ENOM" class="form-label">
                    <strong>Nom</strong>
                </label>
                <input type="text" class="form-control" id="ENOM" name="ENOM"
                       placeholder="Nom" maxlength="100" required>
                <div class="invalid-feedback">Le nom est requis</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="PRENOM" class="form-label">
                    <strong>Prénom</strong>
                </label>
                <input type="text" class="form-control" id="PRENOM" name="PRENOM"
                       placeholder="Prénom" maxlength="100" required>
                <div class="invalid-feedback">Le prénom est requis</div>
            </div>
        </div>
    </div>

    <!-- Ligne 2: Type et Point focal -->
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="TYPE_EXPLOITANT" class="form-label">
                    <strong>Type d'exploitant</strong>
                </label>
                <select name="TYPE_EXPLOITANT" id="TYPE_EXPLOITANT" class="form-select">
                    <option value="">Sélectionner</option>
                    <option value="1">Gestionnaire</option>
                    <option value="2">ACSPE</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="IS_POINT_FOCAL" class="form-label">
                    <strong>Point focal</strong>
                </label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="IS_POINT_FOCAL"
                               id="pointFocalOui" value="1" required>
                        <label class="form-check-label" for="pointFocalOui">Oui</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="IS_POINT_FOCAL"
                               id="pointFocalNon" value="0" required>
                        <label class="form-check-label" for="pointFocalNon">Non</label>
                    </div>
                </div>
                <div class="invalid-feedback">Veuillez indiquer s'il s'agit d'un point focal</div>
            </div>
        </div>
    </div>

    <!-- Ligne 3: AEP associée -->
    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="EPROVINCE" class="form-label"><strong>Province</strong></label>
                                <select name="EPROVINCE" id="EPROVINCE" class="form-select" onchange="loadCommunes(this.value, null, 'ECOMMUNE')">
                                    <option value="">Sélectionner</option>
                                    <?php foreach ($provinces as $prov) {?>
                                        <option value="<?php echo $prov['PROVINCE_ID'] ?>"><?php echo $prov['PROVINCE_NAME'] ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="ECOMMUNE" class="form-label"><strong>Commune</strong></label>
                                <select name="ECOMMUNE" id="ECOMMUNE" class="form-select" onchange="loadAep(this.value, null, 'EAEP_ID')">
                                    <option value="">Sélectionner</option>
                                </select>
                            </div>
                        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="EAEP_ID" class="form-label">
                    <strong>AEP</strong>
                </label>
                <select name="EAEP_ID" id="EAEP_ID" class="form-select" required>
                    <option value="">Sélectionner</option>

                </select>
                <div class="invalid-feedback">Veuillez sélectionner une AEP</div>
            </div>
        </div>
    </div>

    <!-- Ligne 4: Contact -->
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="TEL" class="form-label">
                    <strong>Téléphone</strong>
                </label>
                <input type="tel" class="form-control" id="TEL" name="TEL"
                       placeholder="Ex: +257 00 00 00 00" maxlength="30" required>
                <div class="invalid-feedback">Le numéro de téléphone est requis</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="EMAIL" class="form-label">
                    <strong>Email</strong>
                </label>
                <input type="email" class="form-control" id="EMAIL" name="EMAIL"
                       placeholder="exemple@domaine.com" maxlength="100">
                <div class="invalid-feedback">Veuillez entrer un email valide</div>
            </div>
        </div>
    </div>

    <!-- Ligne 5: Dates (optionnel, généralement générées automatiquement) -->
    <div class="row" style="display: none;">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="DATE_ENREGISTREMENT" class="form-label">Date d'enregistrement</label>
                <input type="datetime-local" class="form-control" id="DATE_ENREGISTREMENT" name="DATE_ENREGISTREMENT">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="DATE_MODIFICATION" class="form-label">Date modification</label>
                <input type="datetime-local" class="form-control" id="DATE_MODIFICATION" name="DATE_MODIFICATION">
            </div>
        </div>
    </div>

    <!-- Champ caché pour l'ID (en mode modification) -->
    <input type="hidden" name="ID_EXPLOITANT" id="ID_EXPLOITANT">


</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="submitFormExploitant(event)"><i class="bi bi-save"></i>Enregistrer</button>
      </div>
    </div>
  </div>
</div>
<!-- Archivage des rapports -->
<div class="modal fade" id="staticArchivage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticArchivageLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticArchivageLabel"><strong>Archivage des rapports</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form action="" method="post" id="formArchive" name="formArchive" enctype="multipart/form-data">
    <!-- Ligne 1: Type de document -->
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="TYPE_DOCUMENT_ID" class="form-label">
                    <strong>Type de document</strong>
                </label>
                <select name="TYPE_DOCUMENT_ID" id="TYPE_DOCUMENT_ID" class="form-select" required>
                    <option value="">Sélectionner</option>
                    <?php foreach ($typesDocuments as $type): ?>
                        <option value="<?php echo $type['TYPE_DOCUMENT_ID'] ?>">
                            <?php echo $type['TYPE_DOCUMENT_DESCR'] ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="0">Autre</option>
                </select>
                <div class="invalid-feedback">Le type de document est requis</div>
            </div>
        </div>
    </div>

    <!-- Ligne 2: Localisation géographique -->
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="APROVINCE" class="form-label">
                    <strong>Province</strong>
                </label>
                <select name="PROVINCE_ID" id="APROVINCE" class="form-select" required onchange="loadCommunes(this.value, null, 'ACOMMUNE')">
                    <option value="">Sélectionner</option>
                    <?php foreach ($provinces as $prov): ?>
                        <option value="<?php echo $prov['PROVINCE_ID'] ?>">
                            <?php echo $prov['PROVINCE_NAME'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">La province est requise</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="ACOMMUNE" class="form-label">
                    <strong>Commune</strong>
                </label>
                <select name="COMMUNE_ID" id="ACOMMUNE" class="form-select" required onchange="loadAep(this.value, null, 'AAEP_ID')">
                    <option value="">Sélectionner d'abord une province</option>
                </select>
                <div class="invalid-feedback">La commune est requise</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="AAEP_ID" class="form-label">
                    <strong>AEP</strong>
                </label>
                <select name="AEP_ID" id="AAEP_ID" class="form-select">
                    <option value="">Sélectionner</option>
                </select>
                <small class="text-muted">Laissez vide si le document concerne toute la zone</small>
            </div>
        </div>
    </div>

    <!-- Ligne 3: Upload de fichiers multiples -->
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="DOCUMENTS" class="form-label">
                    <strong>Documents à archiver</strong>
                </label>
                <div class="upload-area" id="uploadArea">
                    <input type="file" class="form-control" id="DOCUMENTS"
                           name="DOCUMENTS[]" multiple required
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.txt">
                    <small class="text-muted">
                        Formats acceptés: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF, TXT (Max: 10 fichiers, 5MB par fichier)
                    </small>
                </div>
                <div class="invalid-feedback">Veuillez sélectionner au moins un document</div>
            </div>

            <!-- Prévisualisation des fichiers sélectionnés -->
            <div class="selected-files mt-2" id="selectedFiles">
                <div class="files-list"></div>
            </div>
        </div>
    </div>

    <!-- Ligne 4: Informations supplémentaires (optionnelles) -->
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="DESCRIPTION" class="form-label">
                    <strong>Description</strong>
                </label>
                <textarea class="form-control" id="DESCRIPTION" name="DESCRIPTION"
                          rows="3" placeholder="Description du document (optionnel)"></textarea>
            </div>
        </div>
    </div>
</form>
    <!-- Ajouter après le bouton submit -->
    <div class="upload-progress" id="uploadProgress">
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated"
                role="progressbar" style="width: 0%">0%</div>
        </div>
        <p class="text-center mt-2" id="progressMessage">Préparation de l'upload...</p>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="submitFormArchive(event)" ><i class="bi bi-save"></i>Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal pour nouveau type de document -->
<div class="modal fade" id="newTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-file-earmark-plus"></i>
                    Nouveau type de document
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="newTypeDescr" class="form-label">
                        Description du type
                    </label>
                    <input type="text" class="form-control" id="newTypeDescr"
                           placeholder="Ex: Rapport technique, Étude, ..." maxlength="100">
                    <div class="invalid-feedback" style="display: none;">
                        La description est requise
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Annuler
                </button>
                <button type="button" class="btn btn-primary" id="saveNewTypeBtn" onclick="saveNewType()">
                    <i class="bi bi-check"></i> Enregistrer
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
    loadAepData()
    // Sélectionner tous les boutons des pills
    const triggerTabList = document.querySelectorAll('#pills-tab button');

    // Sélectionner tous les divs de contenu
    const contents = document.querySelectorAll('#pills-aep, #pills-gestion, #pills-archivage,#pills-aep-btn, #pills-gestion-btn, #pills-archivage-btn');
    // Initialisation : cacher tous les divs sauf le premier
    contents.forEach(content => {
        content.style.display = 'none';
    });

    document.getElementById('pills-aep').style.display = 'block';
    document.getElementById('pills-aep-btn').style.display = 'block';

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
            const targetDivbtn = document.getElementById(divId + '-btn');
            if (targetDiv) {
                targetDiv.style.display = 'block';
            }
            if (targetDivbtn) {
                targetDivbtn.style.display = 'block';
            }

            // Votre code personnalisé ici
            console.log('Onglet activé:', targetId);
            console.log('Div affiché:', divId);

            // Charger des données selon l'onglet
            switch(targetId) {
                case '#pills-aep':
                    loadAepData();
                    break;
                case '#pills-gestion':
                    loadGestionData();
                    break;
                case '#pills-archivage':
                    loadArchivageData();
                    break;
            }
        });
    });

});

// Fonctions pour charger les données
function loadAepData() {
            // Afficher l'overlay de chargement
             $('#loadingOverlay').show();
            var row_count = "1000000";
            $('#table-aep').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
                "oreder": [
                    [2, 'desc']
                ],
                "ajax": {
                    url: "<?php echo base_url('infrastructure/liste_aep') ?>",
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

function loadGestionData() {
            // Afficher l'overlay de chargement
              $('#loadingOverlay').show();
            var row_count = "1000000";
            $('#table-gestion').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
                "oreder": [
                    [2, 'desc']
                ],
                "ajax": {
                    url: "<?php echo base_url('infrastructure/liste_exploitant') ?>",
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

function loadArchivageData() {
            // Afficher l'overlay de chargement
             $('#loadingOverlay').show();
            var row_count = "1000000";
            $('#table-archivage').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
                "oreder": [
                    [2, 'desc']
                ],
                "ajax": {
                    url: "<?php echo base_url('infrastructure/liste_archives') ?>",
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
// Variable globale pour stocker l'ID en cours de modification
let editingAepId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des écouteurs d'événements
    initEventListeners();
});

function initEventListeners() {
    // Écouter le changement de province pour charger les communes
    const provinceSelect = document.getElementById('PROVINCE_ID');
    if (provinceSelect) {
        provinceSelect.addEventListener('change', function() {
            const provinceId = this.value;
            loadCommunes(provinceId);
            // Réinitialiser les selects dépendants
            resetDependentSelects(['COMMUNE_ID', 'ZONE_ID', 'COLLINE_ID']);
        });
    }

    // Écouter le changement de commune pour charger les zones
    const communeSelect = document.getElementById('COMMUNE_ID');
    if (communeSelect) {
        communeSelect.addEventListener('change', function() {
            const communeId = this.value;
            loadZones(communeId);
            loadCollines(communeId);
        });
    }
    // Écouter le changement de commune pour charger les collines
    const zoneSelect = document.getElementById('ZONE_ID');
    if (zoneSelect) {
        zoneSelect.addEventListener('change', function() {
            const zoneId = this.value;
            loadCollines(zoneId);
        });
    }
    // Écouter la soumission du formulaire
    const form = document.getElementById('formAEP');
    if (form) {
        form.addEventListener('submit', submitForm);
    }
}

// ===========================================
// FONCTIONS DE CHARGEMENT DES DONNÉES
// ===========================================

// Charger les communes par province
function loadCommunes(provinceId, selectedCommuneId = null, idField = 'COMMUNE_ID') {
    const communeSelect = document.getElementById(idField);

    if (!communeSelect) return;

    // Réinitialiser et désactiver
    communeSelect.innerHTML = '<option value="">Chargement...</option>';
    communeSelect.disabled = true;

    if (!provinceId) {
        communeSelect.innerHTML = '<option value="">Sélectionner</option>';
        communeSelect.disabled = false;
        return;
    }

    // Requête AJAX
    fetch('<?php echo base_url("infrastructure/get_commune_by_province") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'province_id=' + encodeURIComponent(provinceId)
    })
    .then(response => {
        if (!response.ok) throw new Error('Erreur réseau');
        return response.json();
    })
    .then(data => {
        communeSelect.innerHTML = '<option value="">Sélectionner</option>';

        if (data && data.length > 0) {
            data.forEach(commune => {
                const option = document.createElement('option');
                option.value = commune.COMMUNE_ID;
                option.textContent = commune.COMMUNE_NAME;
                if (selectedCommuneId && commune.COMMUNE_ID == selectedCommuneId) {
                    option.selected = true;
                }
                communeSelect.appendChild(option);
            });
        } else {
            communeSelect.innerHTML = '<option value="">Aucune commune trouvée</option>';
        }

        communeSelect.disabled = false;
    })
    .catch(error => {
        // console.error('Erreur chargement communes:', error);
        communeSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        communeSelect.disabled = false;
    });
}

// Charger les zones par commune
function loadZones(communeId, selectedZoneId = null) {
    const zoneSelect = document.getElementById('ZONE_ID');

    if (!zoneSelect) return;

    zoneSelect.innerHTML = '<option value="">Chargement...</option>';
    zoneSelect.disabled = true;

    if (!communeId) {
        zoneSelect.innerHTML = '<option value="">Sélectionner</option>';
        zoneSelect.disabled = false;
        return;
    }

    fetch('<?php echo base_url("infrastructure/get_zone_by_commune") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'commune_id=' + encodeURIComponent(communeId)
    })
    .then(response => response.json())
    .then(data => {
        zoneSelect.innerHTML = '<option value="">Sélectionner</option>';

        if (data && data.length > 0) {
            data.forEach(zone => {
                const option = document.createElement('option');
                option.value = zone.ZONE_ID;
                option.textContent = zone.ZONE_NAME;
                if (selectedZoneId && zone.ZONE_ID == selectedZoneId) {
                    option.selected = true;
                }
                zoneSelect.appendChild(option);
            });
        }

        zoneSelect.disabled = false;
    })
    .catch(error => {
        // console.error('Erreur chargement zones:', error);
        zoneSelect.innerHTML = '<option value="">Sélectionner</option>';
        zoneSelect.disabled = false;
    });
}

// Charger les collines par commune
function loadCollines(zoneId, selectedCollineId = null) {
    const collineSelect = document.getElementById('COLLINE_ID');

    if (!collineSelect) return;

    collineSelect.innerHTML = '<option value="">Chargement...</option>';
    collineSelect.disabled = true;

    if (!zoneId) {
        collineSelect.innerHTML = '<option value="">Sélectionner</option>';
        collineSelect.disabled = false;
        return;
    }

    fetch('<?php echo base_url("infrastructure/get_colline_by_zone") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'zone_id=' + encodeURIComponent(zoneId)
    })
    .then(response => response.json())
    .then(data => {
        collineSelect.innerHTML = '<option value="">Sélectionner</option>';

        if (data && data.length > 0) {
            data.forEach(colline => {
                const option = document.createElement('option');
                option.value = colline.COLLINE_ID;
                option.textContent = colline.COLLINE_NAME;
                if (selectedCollineId && colline.COLLINE_ID == selectedCollineId) {
                    option.selected = true;
                }
                collineSelect.appendChild(option);
            });
        }

        collineSelect.disabled = false;
    })
    .catch(error => {
        // console.error('Erreur chargement collines:', error);
        collineSelect.innerHTML = '<option value="">Sélectionner</option>';
        collineSelect.disabled = false;
    });
}

// ===========================================
// FONCTIONS DE VALIDATION
// ===========================================

function validateForm() {
    let isValid = true;
    const errors = [];

    // Réinitialiser les erreurs
    removeErrorStyles();

    // Validation du nom (requis)
    const nom = document.getElementById('NOM');
    if (!nom.value.trim()) {
        addErrorStyle(nom, 'Le nom est requis');
        errors.push('Le nom est requis');
        isValid = false;
    }

    // Validation de la province (requis)
    const province = document.getElementById('PROVINCE_ID');
    if (!province.value) {
        addErrorStyle(province, 'Veuillez sélectionner une province');
        errors.push('La province est requise');
        isValid = false;
    }

    // Validation de la commune (requis)
    const commune = document.getElementById('COMMUNE_ID');
    if (!commune.value) {
        addErrorStyle(commune, 'Veuillez sélectionner une commune');
        errors.push('La commune est requise');
        isValid = false;
    }
    // Validation de la zone (requis)
    const zone = document.getElementById('ZONE_ID');
    if (!zone.value) {
        addErrorStyle(zone, 'Veuillez sélectionner une zone');
        errors.push('La zone est requise');
        isValid = false;
    }
    // Validation de la colline (requis)
    const colline = document.getElementById('COLLINE_ID');
    if (!colline.value) {
        addErrorStyle(colline, 'Veuillez sélectionner une colline');
        errors.push('La colline est requise');
        isValid = false;
    }
    // Validation du sous colline (requis)
    const SOUS_COLLINE = document.getElementById('SOUS_COLLINE');
    if (!SOUS_COLLINE.value.trim()) {
        addErrorStyle(SOUS_COLLINE, 'Le sous colline /quartier est requis');
        errors.push('Le sous colline /quartier est requis');
        isValid = false;
    }
    // Validation de l'année (si fournie)
    const annee = document.getElementById('ANNEE_MISE_EN_SERVICE');
    if(!annee.value) {
        addErrorStyle(annee, 'L\'année de mise en service est requise');
        errors.push('L\'année de mise en service est requise');
        isValid = false;
    }
    if (annee.value) {
        const anneeNum = parseInt(annee.value);
        const currentYear = new Date().getFullYear();
        if (anneeNum < 1900 || anneeNum > currentYear + 5) {
            addErrorStyle(annee, `L'année doit être entre 1900 et ${currentYear + 5}`);
            errors.push('Année invalide');
            isValid = false;
        }
    }

    // Validation du linéaire (si fourni)
    const lineaire = document.getElementById('LINEAIRE_RESEAU');
    if ((lineaire.value && parseFloat(lineaire.value) < 0)||!lineaire.value) {
        addErrorStyle(lineaire, 'Le linéaire doit être positif');
        errors.push('Linéaire invalide');
        isValid = false;
    }

    // Validation des populations
    const popInitial = document.getElementById('POPULATION_COMMUNE_INITIAL');
    if ((popInitial.value && parseInt(popInitial.value) < 0)||!popInitial.value) {
        addErrorStyle(popInitial, 'La population doit être positive');
        errors.push('Population initiale invalide');
        isValid = false;
    }

    const popDesservie = document.getElementById('POPULATION_DESSERVIE');
    if ((popDesservie.value && parseInt(popDesservie.value) < 0) || !popDesservie.value) {
        addErrorStyle(popDesservie, 'La population doit être positive');
        errors.push('Population desservie invalide');
        isValid = false;
    }
    // Validation du executant (requis)
    const EXECUTANT = document.getElementById('EXECUTANT');
    if (!EXECUTANT.value.trim()) {
        addErrorStyle(EXECUTANT, 'Le nom de l\'exécutant est requis');
        errors.push('Le nom de l\'exécutant est requis');
        isValid = false;
    }
    // Validation du maitre d\'oeuvre (requis)
    const MAITRE_OEUVRE = document.getElementById('MAITRE_OEUVRE');
    if (!MAITRE_OEUVRE.value.trim()) {
        addErrorStyle(MAITRE_OEUVRE, 'Le maitre d\'oeuvre est requis');
        errors.push('Le nom du maitre d\'oeuvre est requis');
        isValid = false;
    }
    // Afficher le résumé des erreurs si nécessaire
    if (!isValid) {
        showErrorSummary(errors);
    }

    return isValid;
}

function addErrorStyle(element, message) {
    element.classList.add('is-invalid');

    // Chercher ou créer le message d'erreur
    let feedback = element.nextElementSibling;
    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
        feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        element.parentNode.insertBefore(feedback, element.nextSibling);
    }
    feedback.textContent = message;
}

function removeErrorStyles() {
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
}

function showErrorSummary(errors) {
    // Supprimer l'ancienne alerte
    const oldAlert = document.querySelector('.alert-error-summary');
    if (oldAlert) oldAlert.remove();

    // Créer la nouvelle alerte
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show alert-error-summary';
    alertDiv.setAttribute('role', 'alert');

    let html = '<strong>Erreurs de validation :</strong><ul>';
    errors.forEach(error => {
        html += `<li>${error}</li>`;
    });
    html += '</ul>';
    html += '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';

    alertDiv.innerHTML = html;

    // Insérer en haut du formulaire
    const form = document.getElementById('formAEP');
    form.insertBefore(alertDiv, form.firstChild);

    // Auto-destruction après 5 secondes
    setTimeout(() => alertDiv.remove(), 5000);
}

// ===========================================
// FONCTION DE SOUMISSION
// ===========================================

async function submitForm(event) {
    event.preventDefault();

    // Valider le formulaire
    if (!validateForm()) {
        return false;
    }

    // Afficher le loader
    showLoading(true);

    try {
        const form = document.getElementById('formAEP');
        const formData = new FormData(form);

        // Ajouter l'ID si en mode édition
        if (editingAepId) {
            formData.append('aep_id', editingAepId);
        }

        const response = await fetch('<?php echo base_url("infrastructure/enregistrer_aep") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        showLoading(false);

        if (data.success) {
            // Succès
            showNotification('success', data.message || 'AEP enregistrée avec succès');

            // Fermer le modal si utilisé
            const modal = bootstrap.Modal.getInstance(document.getElementById('aepModal'));
            if (modal) modal.hide();

            // Réinitialiser le formulaire
            resetForm();

            // Rafraîchir le DataTable
            if (typeof refreshAEPDataTable === 'function') {
                refreshAEPDataTable();
            } else {
                location.reload(); // Fallback
            }
        } else {
            // Erreur de validation serveur
            if (data.errors) {
                displayServerErrors(data.errors);
            }
            showNotification('error', data.message || 'Erreur lors de l\'enregistrement');
        }
    } catch (error) {
        // console.error('Erreur:', error);
        showLoading(false);
        showNotification('error', 'Erreur de connexion au serveur');
    }

    return false;
}

// Afficher les erreurs retournées par le serveur
function displayServerErrors(errors) {
    removeErrorStyles();

    for (const field in errors) {
        const input = document.getElementById(field);
        if (input) {
            addErrorStyle(input, errors[field]);
        }
    }
}

// ===========================================
// FONCTIONS POUR LA MODIFICATION
// ===========================================

// Ouvrir le formulaire en mode ajout
function openAddAepForm() {
    resetForm();
    editingAepId = null;
    // Mettre à jour le titre
    // const title = document.getElementById('modalTitle');
    // if (title) title.textContent = 'Ajouter une AEP';

    // // Ouvrir le modal
    // const modal = new bootstrap.Modal(document.getElementById('aepModal'));
    // modal.show();
}

// Ouvrir le formulaire en mode édition
function modifier(aepId) {
    showLoading(true);

    fetch('<?php echo base_url("infrastructure/getaep") ?>/' + aepId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fillFormData(data.data);
            editingAepId = aepId;

            // Mettre à jour le titre
            const title = document.getElementById('modalTitle');
            if (title) title.textContent = 'Modifier AEP';

            // Ouvrir le modal
            const modal = new bootstrap.Modal(document.getElementById('staticAep'));
            modal.show();
        } else {
            showNotification('error', data.message || 'Erreur de chargement');
        }
    })
    .catch(error => {
        // console.error('Erreur:', error);
        showNotification('error', 'Erreur de chargement des données');
    })
    .finally(() => {
        showLoading(false);
    });
}

// Remplir le formulaire avec les données
function fillFormData(data) {
    // console.log('Données à remplir:', data);
    // Champs simples
    document.getElementById('NOM').value = data.NOM || '';
    document.getElementById('SOUS_COLLINE').value = data.SOUS_COLLINE || '';
    document.getElementById('ANNEE_MISE_EN_SERVICE').value = data.ANNEE_MISE_EN_SERVICE || '';
    document.getElementById('LINEAIRE_RESEAU').value = data.LINEAIRE_RESEAU || '';
    document.getElementById('EXECUTANT').value = data.EXECUTANT || '';
    document.getElementById('MAITRE_OEUVRE').value = data.MAITRE_OEUVRE || '';
    document.getElementById('POPULATION_COMMUNE_INITIAL').value = data.POPULATION_COMMUNE_INITIAL || '';
    document.getElementById('POPULATION_DESSERVIE').value = data.POPULATION_DESSERVIE || '';
    document.getElementById('AEP_ID').value = data.AEP_ID || '';

    // Sélectionner la province

        document.getElementById('PROVINCE_ID').value = data.PROVINCE_ID;

        // Charger les communes et sélectionner celle correspondante
        loadCommunes(data.PROVINCE_ID, data.COMMUNE_ID)
        // Une fois les communes chargées, charger les zones et collines
        loadZones(data.COMMUNE_ID, data.ZONE_ID);
        loadCollines(data.ZONE_ID, data.COLLINE_ID);



}

// ===========================================
// FONCTIONS UTILITAIRES
// ===========================================

// Réinitialiser le formulaire
function resetForm() {
    const form = document.getElementById('formAEP');
    form.reset();

    // Réinitialiser les selects
    resetDependentSelects(['COMMUNE_ID', 'ZONE_ID', 'COLLINE_ID']);

    // Supprimer les erreurs
    removeErrorStyles();

    // Réinitialiser la variable d'édition
    editingAepId = null;
    document.getElementById('AEP_ID').value = '';
}

// Réinitialiser des selects spécifiques
function resetDependentSelects(selectIds) {
    selectIds.forEach(id => {
        const select = document.getElementById(id);
        if (select) {
            select.innerHTML = '<option value="">Sélectionner</option>';
            select.disabled = false;
        }
    });
}

// Afficher/masquer le loader
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
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    setTimeout(() => notification.remove(), 5000);
}

// Fonction pour rafraîchir le DataTable (à adapter selon votre configuration)
function refreshAEPDataTable() {
    if ($.fn.DataTable && $.fn.DataTable.isDataTable('#table-aep')) {
        $('#table-aep').DataTable().ajax.reload();
    } else {
        location.reload();
    }
}

// Fonction pour supprimer une AEP
function deleteAEP(aepId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette AEP ?')) {
        showLoading(true);

        fetch('<?php echo base_url("aep/delete") ?>/' + aepId, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('success', data.message);
                refreshAEPDataTable();
            } else {
                showNotification('error', data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('error', 'Erreur lors de la suppression');
        })
        .finally(() => {
            showLoading(false);
        });
    }
}
</script>
<!-- Script pour la gestion des exploitations -->
<script>
// Charger les AEP par province
function loadAep(communeId, selectedaepId = null, idField = 'AEP_ID') {
    const aepSelect = document.getElementById(idField);

    if (!aepSelect) return;

    // Réinitialiser et désactiver
    aepSelect.innerHTML = '<option value="">Chargement...</option>';
    aepSelect.disabled = true;

    if (!communeId) {
        aepSelect.innerHTML = '<option value="">Sélectionner</option>';
        aepSelect.disabled = false;
        return;
    }

    // Requête AJAX
    fetch('<?php echo base_url("infrastructure/get_aep_by_commune") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'commune_id=' + encodeURIComponent(communeId)
    })
    .then(response => {
        if (!response.ok) throw new Error('Erreur réseau');
        return response.json();
    })
    .then(data => {
        aepSelect.innerHTML = '<option value="">Sélectionner</option>';

        if (data && data.length > 0) {
            data.forEach(aep => {
                const option = document.createElement('option');
                option.value = aep.AEP_ID;
                option.textContent = aep.NOM;
                if (selectedaepId && aep.AEP_ID == selectedaepId) {
                    option.selected = true;
                }
                aepSelect.appendChild(option);
            });
        } else {
            aepSelect.innerHTML = '<option value="">Aucune AEP trouvée</option>';
        }

        aepSelect.disabled = false;
    })
    .catch(error => {
        // console.error('Erreur chargement AEP:', error);
        aepSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        aepSelect.disabled = false;
    });
}

</script>
<script>
// Variable globale pour stocker l'ID en cours de modification
let editingExploitantId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des écouteurs d'événements
    // initFormExploitant();

    // Initialiser les sélecteurs si en mode édition
    const urlParams = new URLSearchParams(window.location.search);
    const exploitantId = urlParams.get('id');
    if (exploitantId) {
        loadExploitantForEdit(exploitantId);
    }
});

// ===========================================
// FONCTIONS DE VALIDATION
// ===========================================

function validateFormExploitant() {
    let isValid = true;
    const errors = [];

    // Réinitialiser les erreurs
    removeErrorStyles();

    // Validation du nom
    const nom = document.getElementById('ENOM');
    if (!nom.value.trim()) {
        addErrorStyle(nom, 'Le nom est requis');
        errors.push('Nom requis');
        isValid = false;
    } else if (nom.value.trim().length < 2) {
        addErrorStyle(nom, 'Le nom doit contenir au moins 2 caractères');
        errors.push('Nom trop court');
        isValid = false;
    }

    // Validation du prénom
    const prenom = document.getElementById('PRENOM');
    if (!prenom.value.trim()) {
        addErrorStyle(prenom, 'Le prénom est requis');
        errors.push('Prénom requis');
        isValid = false;
    } else if (prenom.value.trim().length < 2) {
        addErrorStyle(prenom, 'Le prénom doit contenir au moins 2 caractères');
        errors.push('Prénom trop court');
        isValid = false;
    }

    // Validation du point focal
    const pointFocal = document.querySelector('input[name="IS_POINT_FOCAL"]:checked');
    if (!pointFocal) {
        const radioGroup = document.querySelectorAll('input[name="IS_POINT_FOCAL"]');
        radioGroup.forEach(radio => {
            radio.classList.add('is-invalid');
        });
        errors.push('Veuillez indiquer s\'il s\'agit d\'un point focal');
        isValid = false;
    }

    // Validation de la province
    const province = document.getElementById('EPROVINCE');
    if (!province.value) {
        addErrorStyle(province, 'Veuillez sélectionner une province');
        errors.push('Province requise');
        isValid = false;
    }

    // Validation du type de gestion
    const typeGestion = document.getElementById('TYPE_EXPLOITANT');
    if (!typeGestion.value) {
        addErrorStyle(typeGestion, 'Veuillez sélectionner un type de gestion');
        errors.push('Type de gestion requis');
        isValid = false;
    }
    // Validation de la commune
    const commune = document.getElementById('ECOMMUNE');
    if (!commune.value) {
        addErrorStyle(commune, 'Veuillez sélectionner une commune');
        errors.push('Commune requise');
        isValid = false;
    }
    // Validation de l'AEP
    const aep = document.getElementById('EAEP_ID');
    if (!aep.value) {
        addErrorStyle(aep, 'Veuillez sélectionner une AEP');
        errors.push('AEP requise');
        isValid = false;
    }

    // Validation du téléphone
    const tel = document.getElementById('TEL');
    if (!tel.value.trim()) {
        addErrorStyle(tel, 'Le numéro de téléphone est requis');
        errors.push('Téléphone requis');
        isValid = false;
    } else {
        // Validation simple du format téléphone
        const phoneRegex = /^[0-9+\-\s()]{8,}$/;
        if (!phoneRegex.test(tel.value)) {
            addErrorStyle(tel, 'Format de téléphone invalide');
            errors.push('Format téléphone invalide');
            isValid = false;
        }
    }

    // Validation de l'email (si fourni)
    const email = document.getElementById('EMAIL');
    if (email.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            addErrorStyle(email, 'Format d\'email invalide');
            errors.push('Email invalide');
            isValid = false;
        }
    }

    // Afficher les erreurs
    if (!isValid) {
        showErrorSummary(errors);
    }

    return isValid;
}

// ===========================================
// FONCTIONS UTILITAIRES D'ERREUR
// ===========================================

function addErrorStyle(element, message) {
    element.classList.add('is-invalid');

    // Chercher ou créer le message d'erreur
    let feedback = element.nextElementSibling;
    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
        feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        element.parentNode.insertBefore(feedback, element.nextSibling);
    }
    feedback.textContent = message;
}

function removeErrorStyles() {
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
}

function showErrorSummary(errors) {
    // Supprimer l'ancienne alerte
    const oldAlert = document.querySelector('.alert-error-summary');
    if (oldAlert) oldAlert.remove();

    // Créer la nouvelle alerte
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show alert-error-summary';
    alertDiv.setAttribute('role', 'alert');

    let html = '<strong>Erreurs de validation :</strong><ul>';
    errors.forEach(error => {
        html += `<li>${error}</li>`;
    });
    html += '</ul>';
    html += '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';

    alertDiv.innerHTML = html;

    // Insérer en haut du formulaire
    const form = document.getElementById('formExploitant');
    form.insertBefore(alertDiv, form.firstChild);

    // Auto-destruction après 5 secondes
    setTimeout(() => alertDiv.remove(), 5000);
}

// ===========================================
// FONCTION DE SOUMISSION
// ===========================================

async function submitFormExploitant(event) {
    event.preventDefault();

    // Valider le formulaire
    if (!validateFormExploitant()) {
        return false;
    }

    // Afficher le loader
    showLoading(true);

    try {
        const form = document.getElementById('formExploitant');
        const formData = new FormData(form);

        // Ajouter l'ID si en mode édition
        if (editingExploitantId) {
            formData.append('id_exploitant', editingExploitantId);
        }

        // Ajouter le token CSRF si nécessaire
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            formData.append('<?php echo csrf_token() ?>', csrfToken);
        }

        const response = await fetch('<?php echo base_url("infrastructure/enregistrer_exploitant") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        showLoading(false);

        if (data.success) {
            // Succès
            showNotification('success', data.message || 'Exploitant enregistré avec succès');

            // Fermer le modal si utilisé
            const modal = bootstrap.Modal.getInstance(document.getElementById('exploitantModal'));
            if (modal) modal.hide();

            // Réinitialiser le formulaire
            resetFormExploitant();

            // Rafraîchir le DataTable
            loadGestionData()
        } else {
            // Erreur de validation serveur
            if (data.errors) {
                displayServerErrors(data.errors);
            }
            showNotification('error', data.message || 'Erreur lors de l\'enregistrement');
        }
    } catch (error) {
        console.log('Erreur:', error);
        showLoading(false);
        showNotification('error', 'Erreur de connexion au serveur');
    }

    return false;
}

// Afficher les erreurs retournées par le serveur
function displayServerErrors(errors) {
    removeErrorStyles();

    for (const field in errors) {
        // Adapter les noms de champs si nécessaire
        let fieldId = field;
        if (field === 'EAEP_ID' || field === 'AEP_ID') {
            fieldId = 'EAEP_ID';
        } else if (field === 'EPROVINCE' || field === 'PROVINCE_ID') {
            fieldId = 'EPROVINCE';
        } else if (field === 'ECOMMUNE' || field === 'COMMUNE_ID') {
            fieldId = 'ECOMMUNE';
        }

        const input = document.getElementById(fieldId);
        if (input) {
            addErrorStyle(input, errors[field]);
        }
    }
}

// ===========================================
// FONCTIONS POUR LA MODIFICATION
// ===========================================

// Ouvrir le formulaire en mode ajout
function openAddExploitantForm() {
    resetFormExploitant();
    editingExploitantId = null;

    // Mettre à jour le titre
    const title = document.getElementById('modalTitle');
    if (title) title.textContent = 'Ajouter un exploitant';

    // Ouvrir le modal
    const modal = new bootstrap.Modal(document.getElementById('exploitantModal'));
    modal.show();
}

// Ouvrir le formulaire en mode édition
function modifierExploitant(exploitantId) {
    showLoading(true);

    fetch('<?php echo base_url("infrastructure/get_exploitant") ?>/' + exploitantId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fillFormExploitant(data.data);
            editingExploitantId = exploitantId;

            // Mettre à jour le titre
            const title = document.getElementById('modalTitle');
            if (title) title.textContent = 'Modifier exploitant';

            // Ouvrir le modal
            const modal = new bootstrap.Modal(document.getElementById('staticGestion'));
            modal.show();
        } else {
            showNotification('error', data.message || 'Erreur de chargement');
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

// Remplir le formulaire avec les données
function fillFormExploitant(data) {
    console.log('Données à remplir:', data);

    // Champs simples
    document.getElementById('ENOM').value = data.NOM || '';
    document.getElementById('PRENOM').value = data.PRENOM || '';
    document.getElementById('TEL').value = data.TEL || '';
    document.getElementById('EMAIL').value = data.EMAIL || '';
    document.getElementById('ID_EXPLOITANT').value = data.ID_EXPLOITANT || '';

    // Type d'exploitant
    if (data.TYPE_EXPLOITANT) {
        document.getElementById('TYPE_EXPLOITANT').value = data.TYPE_EXPLOITANT;
    }

    // Point focal (radio)
    if (data.IS_POINT_FOCAL == 1) {
        document.getElementById('pointFocalOui').checked = true;
    } else if (data.IS_POINT_FOCAL == 0) {
        document.getElementById('pointFocalNon').checked = true;
    }


        document.getElementById('EPROVINCE').value = data.PROVINCE_ID;

        // Charger les communes et sélectionner celle correspondante
        loadCommunes(data.PROVINCE_ID, data.COMMUNE_ID, 'ECOMMUNE')
        loadAep(data.COMMUNE_ID, data.AEP_ID, 'EAEP_ID');


}

// ===========================================
// FONCTIONS UTILITAIRES
// ===========================================

// Réinitialiser le formulaire
function resetFormExploitant() {
    const form = document.getElementById('formExploitant');
    form.reset();

    // Réinitialiser les selects
    resetSelect('ECOMMUNE');
    resetSelect('EAEP_ID');

    // Supprimer les erreurs
    removeErrorStyles();

    // Réinitialiser la variable d'édition
    editingExploitantId = null;
    document.getElementById('ID_EXPLOITANT').value = '';
}

// Réinitialiser un select
function resetSelect(selectId) {
    const select = document.getElementById(selectId);
    if (select) {
        select.innerHTML = '<option value="">Sélectionner</option>';
        select.disabled = false;
    }
}



// Afficher une notification
function showNotification(type, message) {
    // Supprimer les anciennes notifications
    const oldNotifications = document.querySelectorAll('.notification-toast');
    oldNotifications.forEach(n => n.remove());

    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show notification-toast`;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';
    notification.style.maxWidth = '400px';

    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
            <div class="flex-grow-1">${message}</div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
        </div>
    `;

    document.body.appendChild(notification);

    // Auto-fermeture après 5 secondes
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}
// Fonction pour charger un exploitant pour édition (via URL)
function loadExploitantForEdit(id) {
    modifierExploitant(id);
}
</script>
<!-- GESTION DE L'ARCHIVAGE -->
 <script>
// Variables globales
let selectedFiles = [];
let editingArchiveId = null;

document.addEventListener('DOMContentLoaded', function() {
    initArchiveForm();
    setupDragAndDrop();
});

function initArchiveForm() {
    // Écouter le changement de fichier
    const fileInput = document.getElementById('DOCUMENTS');
    if (fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
    }
}

// ===========================================
// GESTION DE L'UPLOAD MULTIPLE
// ===========================================

function setupDragAndDrop() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('DOCUMENTS');

    if (!uploadArea || !fileInput) return;

    // Empêcher le comportement par défaut du navigateur
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Mettre en évidence la zone de drop
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });

    // Gérer le drop
    uploadArea.addEventListener('drop', handleDrop, false);

    // Clic sur la zone pour ouvrir le sélecteur de fichiers
    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });
}

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight() {
    document.getElementById('uploadArea').classList.add('dragover');
}

function unhighlight() {
    document.getElementById('uploadArea').classList.remove('dragover');
}

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;

    handleFiles(files);
}

function handleFileSelect(e) {
    const files = e.target.files;
    handleFiles(files);
}

function handleFiles(files) {
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'image/jpeg',
        'image/png',
        'image/gif',
        'text/plain'
    ];

    // Convertir en tableau et filtrer
    const newFiles = Array.from(files).filter(file => {
        // Vérifier la taille
        if (file.size > maxSize) {
            showNotification('error', `Le fichier ${file.name} dépasse 5MB`);
            return false;
        }

        // Vérifier le type
        if (!allowedTypes.includes(file.type) && !file.name.match(/\.(pdf|doc|docx|xls|xlsx|jpg|jpeg|png|gif|txt)$/i)) {
            showNotification('error', `Le type du fichier ${file.name} n'est pas autorisé`);
            return false;
        }

        return true;
    });

    // Ajouter aux fichiers sélectionnés
    selectedFiles = [...selectedFiles, ...newFiles];

    // Limiter à 10 fichiers
    if (selectedFiles.length > 10) {
        showNotification('error', 'Vous ne pouvez pas sélectionner plus de 10 fichiers');
        selectedFiles = selectedFiles.slice(0, 10);
    }

    // Mettre à jour l'affichage
    updateFilesList();
    updateFileInput();
}

function updateFilesList() {
    const container = document.querySelector('#selectedFiles .files-list');
    if (!container) return;

    if (selectedFiles.length === 0) {
        container.innerHTML = '<p class="text-muted text-center">Aucun fichier sélectionné</p>';
        return;
    }

    let html = '<ul class="files-list">';

    selectedFiles.forEach((file, index) => {
        const fileExt = file.name.split('.').pop().toLowerCase();
        const fileSize = (file.size / 1024).toFixed(2) + ' KB';
        const icon = getFileIcon(fileExt);

        html += `
            <li class="file-item">
                <span class="file-icon ${icon.class}">${icon.html}</span>
                <div class="file-info">
                    <span class="file-name">${file.name}</span>
                    <span class="file-size">(${fileSize})</span>
                </div>
                <span class="file-remove" onclick="removeFile(${index})">
                    <i class="bi bi-trash"></i>
                </span>
            </li>
        `;
    });

    html += '</ul>';
    html += `<div class="files-counter">${selectedFiles.length} fichier(s) sélectionné(s)</div>`;

    container.innerHTML = html;
}

function getFileIcon(ext) {
    const icons = {
        pdf: { class: 'pdf', html: '<i class="bi bi-file-pdf"></i>' },
        doc: { class: 'doc', html: '<i class="bi bi-file-word"></i>' },
        docx: { class: 'doc', html: '<i class="bi bi-file-word"></i>' },
        xls: { class: 'xls', html: '<i class="bi bi-file-excel"></i>' },
        xlsx: { class: 'xls', html: '<i class="bi bi-file-excel"></i>' },
        jpg: { class: 'jpg', html: '<i class="bi bi-file-image"></i>' },
        jpeg: { class: 'jpg', html: '<i class="bi bi-file-image"></i>' },
        png: { class: 'png', html: '<i class="bi bi-file-image"></i>' },
        gif: { class: 'png', html: '<i class="bi bi-file-image"></i>' },
        txt: { class: 'txt', html: '<i class="bi bi-file-text"></i>' }
    };

    return icons[ext] || { class: 'txt', html: '<i class="bi bi-file"></i>' };
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    updateFilesList();
    updateFileInput();
}

function updateFileInput() {
    const fileInput = document.getElementById('DOCUMENTS');

    // Créer un nouveau FileList à partir de selectedFiles
    // Note: Cette méthode est limitée, mais fonctionne pour l'affichage
    // Pour l'envoi, on utilisera FormData directement
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });

    fileInput.files = dataTransfer.files;
}


// ===========================================
// VALIDATION DU FORMULAIRE
// ===========================================

function validateFormArchive() {
    let isValid = true;
    const errors = [];

    removeErrorStyles();

    // Validation du type de document
    const typeDoc = document.getElementById('TYPE_DOCUMENT_ID');
    if (!typeDoc.value) {
        addErrorStyle(typeDoc, 'Le type de document est requis');
        errors.push('Type de document requis');
        isValid = false;
    }

    // Validation de la province
    const province = document.getElementById('APROVINCE');
    if (!province.value) {
        addErrorStyle(province, 'La province est requise');
        errors.push('Province requise');
        isValid = false;
    }

    // Validation de la commune
    const commune = document.getElementById('ACOMMUNE');
    if (!commune.value) {
        addErrorStyle(commune, 'La commune est requise');
        errors.push('Commune requise');
        isValid = false;
    }
    // Validation de l'aep
    const aep = document.getElementById('AAEP_ID');
    if (!aep.value) {
        addErrorStyle(aep, 'L\'AEP est requise');
        errors.push('AEP requise');
        isValid = false;
    }


    // Validation des fichiers
    if (selectedFiles.length === 0) {
        const uploadArea = document.getElementById('uploadArea');
        uploadArea.classList.add('is-invalid');
        errors.push('Veuillez sélectionner au moins un document');
        isValid = false;
    }

    if (!isValid) {
        showErrorSummary(errors);
    }

    return isValid;
}

// ===========================================
// SOUMISSION DU FORMULAIRE
// ===========================================
async function submitFormArchive(event) {
    event.preventDefault();

    if (!validateFormArchive()) {
        return false;
    }

    showLoading(true);
    showProgress(true);

    try {
        const form = document.getElementById('formArchive');
        const formData = new FormData(form);

        // Ajouter les fichiers sélectionnés
        selectedFiles.forEach((file, index) => {
            formData.append('documents[]', file);
        });

        // Faire la requête UNE SEULE FOIS
        const response = await fetch('<?php echo base_url("infrastructure/enregistrer_archive") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        // Lire la réponse UNE SEULE FOIS
        const data = await response.json();

        showLoading(false);
        showProgress(false);

        if (data.success) {
            showNotification('success', data.message || 'Documents uploadés avec succès');
            resetFormArchive();
            loadArchivageData();

        } else {
            if (data.errors) {
                displayServerErrors(data.errors);
            }
            showNotification('error', data.message || 'Erreur lors de l\'upload');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showLoading(false);
        showProgress(false);
        showNotification('error', 'Erreur de connexion au serveur: ' + error.message);
    }
}

// ===========================================
// FONCTIONS UTILITAIRES
// ===========================================

function addErrorStyle(element, message) {
    element.classList.add('is-invalid');

    let feedback = element.nextElementSibling;
    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
        feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        element.parentNode.insertBefore(feedback, element.nextSibling);
    }
    feedback.textContent = message;
}

function removeErrorStyles() {
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    document.getElementById('uploadArea')?.classList.remove('is-invalid');
}

function showErrorSummary(errors) {
    const oldAlert = document.querySelector('.alert-error-summary');
    if (oldAlert) oldAlert.remove();

    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show alert-error-summary';
    alertDiv.innerHTML = `
        <strong>Erreurs de validation :</strong>
        <ul>${errors.map(e => `<li>${e}</li>`).join('')}</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    const form = document.getElementById('formArchive');
    form.insertBefore(alertDiv, form.firstChild);

    setTimeout(() => alertDiv.remove(), 5000);
}

function showProgress(show) {
    const progress = document.getElementById('uploadProgress');
    if (!progress) return;

    if (show) {
        progress.classList.add('show');
        updateProgress(0);
    } else {
        progress.classList.remove('show');
    }
}

function updateProgress(percent) {
    const progressBar = document.querySelector('.progress-bar');
    if (progressBar) {
        progressBar.style.width = percent + '%';
        progressBar.textContent = percent + '%';
    }
}

function resetFormArchive() {
    document.getElementById('formArchive').reset();
    selectedFiles = [];
    updateFilesList();
    removeErrorStyles();

    // Réinitialiser les selects
    document.getElementById('ACOMMUNE').innerHTML = '<option value="">Sélectionner d\'abord une province</option>';
    document.getElementById('AAEP_ID').innerHTML = '<option value="">Sélectionner</option>';
}



function showNotification(type, message) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    setTimeout(() => notification.remove(), 5000);
}

function displayServerErrors(errors) {
    removeErrorStyles();

    for (const field in errors) {
        let fieldId = field;
        if (field === 'PROVINCE_ID') fieldId = 'APROVINCE';
        if (field === 'COMMUNE_ID') fieldId = 'ACOMMUNE';

        const input = document.getElementById(fieldId);
        if (input) {
            addErrorStyle(input, errors[field]);
        }
    }
}

// Supprimer un seul document
function deleteArchive(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce document ?')) {
        showLoading(true);

        fetch('<?php echo base_url("infrastructure/delete_archive") ?>/' + id, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            showLoading(false);

            if (data.success) {
                showNotification('success', data.message);
                loadArchivageData();
            } else {
                showNotification('error', data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showLoading(false);
            showNotification('error', 'Erreur lors de la suppression');
        });
    }
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('TYPE_DOCUMENT_ID');

    // Écouter le changement de sélection
    if (typeSelect) {
        typeSelect.addEventListener('change', function() {
            if (this.value === '0') { // Si "Autre" est sélectionné
                openNewTypeModal();
                this.value = ''; // Réinitialiser la sélection
            }
        });
    }
});

// Ouvrir le modal pour ajouter un nouveau type
function openNewTypeModal() {
    // Réinitialiser le formulaire
    document.getElementById('newTypeDescr').value = '';
    document.getElementById('newTypeDescr').classList.remove('is-invalid');
    document.querySelector('#newTypeModal .invalid-feedback').style.display = 'none';

    // Ouvrir le modal
    const modal = new bootstrap.Modal(document.getElementById('newTypeModal'));
    modal.show();
}

// Sauvegarder le nouveau type
async function saveNewType() {
    const description = document.getElementById('newTypeDescr').value.trim();

    if (!description) {
        document.getElementById('newTypeDescr').classList.add('is-invalid');
        document.querySelector('#newTypeModal .invalid-feedback').style.display = 'block';
        return;
    }

    if (description.length < 3) {
        document.getElementById('newTypeDescr').classList.add('is-invalid');
        document.querySelector('#newTypeModal .invalid-feedback').textContent = 'La description doit contenir au moins 3 caractères';
        document.querySelector('#newTypeModal .invalid-feedback').style.display = 'block';
        return;
    }

    // Afficher le chargement
    document.getElementById('saveNewTypeBtn').disabled = true;
    document.getElementById('saveNewTypeBtn').innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enregistrement...';

    try {
        const response = await fetch('<?php echo base_url("infrastructure/createTypeDocument") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ description: description })
        });

        const result = await response.json();

        if (result.success) {
            // Ajouter le nouveau type au select
            const select = document.getElementById('TYPE_DOCUMENT_ID');
            const option = document.createElement('option');
            option.value = result.data.TYPE_DOCUMENT_ID;
            option.textContent = result.data.TYPE_DOCUMENT_DESCR;
            option.selected = true;

            // Insérer avant "Autre" (valeur 0)
            const autreOption = select.querySelector('option[value="0"]');
            if (autreOption) {
                select.insertBefore(option, autreOption);
            } else {
                select.appendChild(option);
            }

            // Fermer le modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('newTypeModal'));
            modal.hide();

            // Notification de succès
            showNotification('success', 'Type de document ajouté avec succès');
        } else {
            alert(result.message || 'Erreur lors de l\'ajout');
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur de connexion au serveur');
    } finally {
        // Réactiver le bouton
        document.getElementById('saveNewTypeBtn').disabled = false;
        document.getElementById('saveNewTypeBtn').innerHTML = 'Enregistrer';
    }
}


</script>