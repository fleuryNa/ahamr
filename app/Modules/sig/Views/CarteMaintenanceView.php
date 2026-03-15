<?php
    echo view('includes/head');
?>
<?php echo view('includes/sidebar') ?>

<style>
    .maintenance-page .card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .map-layout {
        display: grid;
        grid-template-columns: 4fr 1fr;
        gap: 18px;
        min-height: 650px;
    }

    .map-panel {
        background: #fff;
        border-radius: 18px;
        padding: 12px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        border: 1px solid #eef2f7;
    }

    .side-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        border: 1px solid #eef2f7;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    #map {
        height: 650px;
        width: 100%;
        border-radius: 16px;
    }

    .panel-section {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        padding: 14px;
    }

    .panel-title {
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        letter-spacing: .04em;
        margin-bottom: 12px;
    }

    .legend-compact-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 0;
    }

    .legend-left {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        margin: 0;
        cursor: pointer;
    }

    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    .filter-label {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    .leaflet-tooltip.custom-tooltip {
        background: #fff;
        border: 1px solid #dbe4ef;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.10);
        color: #0f172a;
        padding: 8px 10px;
    }

    .leaflet-tooltip.custom-tooltip:before {
        border-top-color: #fff !important;
    }

    .custom-map-marker {
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .custom-map-marker:hover {
        transform: scale(1.06);
    }

    .legend-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 10px;
    }

    @media (max-width: 1200px) {
        .map-layout {
            grid-template-columns: 1fr;
        }

        #map {
            height: 560px;
        }
    }
</style>

<main class="app-main maintenance-page">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Maintenance</h3>
                    <div class="text-muted small mt-1">Carte SIG de suivi des maintenances et de l’état des infrastructures</div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="#">Maintenance</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Carte des chantiers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-3 p-lg-4">
                    <div class="map-layout">

                        <div class="map-panel">
                            <div id="map"></div>
                        </div>

                        <div class="side-panel">
                            <div class="panel-section">
                                <div class="panel-title">Filtres</div>

                                <div class="mb-3">
                                    <label class="filter-label" for="filterProvince">Province</label>
                                    <select id="filterProvince" class="form-select rounded-3">
                                        <option value="">Sélectionner</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="filter-label" for="filterCommune">Commune</label>
                                    <select id="filterCommune" class="form-select rounded-3">
                                        <option value="">Sélectionner</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="filter-label" for="filterTypeInfra">Type infrastructure</label>
                                    <select id="filterTypeInfra" class="form-select rounded-3">
                                        <option value="">Sélectionner</option>
                                    </select>
                                </div>

                                <div class="d-grid">
                                    <button id="btnResetFilters" class="btn btn-outline-primary rounded-3">
                                        Réinitialiser les filtres
                                    </button>
                                </div>
                            </div>

                            <div class="panel-section">
                                <div class="panel-title">Légende</div>

                                <div class="legend-actions">
                                    <button id="btnCheckAllLegend" class="btn btn-sm btn-outline-success rounded-3">
                                        Tout cocher
                                    </button>
                                    <button id="btnUncheckAllLegend" class="btn btn-sm btn-outline-danger rounded-3">
                                        Tout décocher
                                    </button>
                                </div>

                                <div id="legendEtat"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="infraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="max-width: 1280px;">
        <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
            <div class="modal-header text-white border-0 px-4 py-3"
                style="background: linear-gradient(135deg, #111827, #1f2937);">
                <div>
                    <h5 class="modal-title fw-bold mb-1" id="modalTitle">Détail infrastructure</h5>
                    <div id="modalSubTitle" class="small text-white-50">Fiche descriptive</div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4" id="modalContent" style="background:#f8fafc;"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0" style="background: rgba(17,24,39,0.95);">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white">Aperçu de l'image</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img id="zoomedImage" src="" alt="Image zoomée" style="max-width:100%; max-height:80vh; object-fit:contain; border-radius:12px;">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", async function () {
    if (typeof L === "undefined") {
        console.error("Leaflet non chargé (L undefined).");
        return;
    }

    const map = L.map("map").setView([-3.3731, 29.9189], 8);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 8,
        attribution: "&copy; OpenStreetMap contributors",
    }).addTo(map);

    const modal = new bootstrap.Modal(document.getElementById("infraModal"));
    const modalTitle = document.getElementById("modalTitle");
    const modalSubTitle = document.getElementById("modalSubTitle");
    const modalContent = document.getElementById("modalContent");

    const filterProvince = document.getElementById("filterProvince");
    const filterCommune = document.getElementById("filterCommune");
    const filterTypeInfra = document.getElementById("filterTypeInfra");
    const btnResetFilters = document.getElementById("btnResetFilters");
    const btnCheckAllLegend = document.getElementById("btnCheckAllLegend");
    const btnUncheckAllLegend = document.getElementById("btnUncheckAllLegend");
    const legendEtat = document.getElementById("legendEtat");

    let allPoints = [];
    let currentLayerGroup = L.layerGroup().addTo(map);

    const etatsConfig = {
        1: { label: "Fonctionnel", color: "#198754" },
        2: { label: "En panne", color: "#dc3545" },
        3: { label: "En maintenance", color: "#fd7e14" },
        4: { label: "Hors service", color: "#6c757d" },
        5: { label: "En construction", color: "#0d6efd" },
        6: { label: "Partiellement fonctionnel", color: "#ffc107" }
    };

    function safeValue(v) {
        return (v !== null && v !== undefined && String(v).trim() !== "")
            ? String(v)
            : `<span class="text-muted fst-italic">Non renseigné</span>`;
    }

    function normalizeText(v) {
        return String(v || "").trim().toLowerCase();
    }

    function badgeEtat(etat) {
        const value = normalizeText(etat);

        if (value.includes("fonctionnel") && !value.includes("partiellement")) {
            return `<span class="badge rounded-pill px-3 py-2" style="background:#e8f8ee;color:#18864b;border:1px solid #ccefd8;">${etat}</span>`;
        }
        if (value.includes("partiellement")) {
            return `<span class="badge rounded-pill px-3 py-2" style="background:#fff7e6;color:#b26a00;border:1px solid #ffe0a3;">${etat}</span>`;
        }
        if (value.includes("maintenance")) {
            return `<span class="badge rounded-pill px-3 py-2" style="background:#fff4db;color:#a16207;border:1px solid #fde7b0;">${etat}</span>`;
        }
        if (value.includes("panne")) {
            return `<span class="badge rounded-pill px-3 py-2" style="background:#fdecec;color:#c0392b;border:1px solid #f5c2c7;">${etat}</span>`;
        }
        if (value.includes("hors service")) {
            return `<span class="badge rounded-pill px-3 py-2" style="background:#eceff3;color:#4b5563;border:1px solid #d5dbe3;">${etat}</span>`;
        }
        if (value.includes("construction")) {
            return `<span class="badge rounded-pill px-3 py-2" style="background:#e7f1ff;color:#0d6efd;border:1px solid #cfe2ff;">${etat}</span>`;
        }

        return `<span class="badge rounded-pill px-3 py-2 bg-secondary">${etat || "Non défini"}</span>`;
    }

    function getEtatColor(etatId) {
        return etatsConfig[parseInt(etatId)]?.color || "#6c757d";
    }

    function getEtatLabel(etatId) {
        return etatsConfig[parseInt(etatId)]?.label || "Non défini";
    }

    function getInfraSymbol(typeInfraId) {
        switch (parseInt(typeInfraId)) {
            case 1: return "💧";
            case 2: return "🏠";
            case 3: return "📏";
            case 4: return "🛢️";
            case 5: return "🚰";
            default: return "📍";
        }
    }

    function getInfraLabel(typeInfraId) {
        switch (parseInt(typeInfraId)) {
            case 1: return "Captage";
            case 2: return "Chambre";
            case 3: return "Conduite";
            case 4: return "Réservoir";
            case 5: return "Branchement";
            default: return "Infrastructure";
        }
    }

    function createInfraIcon(typeInfraId, etatId) {
        const color = getEtatColor(etatId);
        const symbol = getInfraSymbol(typeInfraId);

        return L.divIcon({
            className: "",
            html: `
                <div class="custom-map-marker" style="
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    background: ${color};
                    color: white;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 17px;
                    font-weight: bold;
                    box-shadow: 0 3px 10px rgba(0,0,0,0.25);
                ">
                    ${symbol}
                </div>
            `,
            iconSize: [36, 36],
            iconAnchor: [18, 18],
            popupAnchor: [0, -15]
        });
    }

    function renderLegend() {
        legendEtat.innerHTML = Object.entries(etatsConfig).map(([id, conf]) => `
            <div class="legend-compact-item">
                <label class="legend-left">
                    <input
                        type="checkbox"
                        class="form-check-input legend-checkbox"
                        value="${id}"
                        checked
                    >
                    <span class="legend-color" style="background:${conf.color};"></span>
                    <span style="font-size:13px; color:#0f172a; font-weight:600;">${conf.label}</span>
                </label>
            </div>
        `).join("");

        document.querySelectorAll(".legend-checkbox").forEach(cb => {
            cb.addEventListener("change", refreshView);
        });
    }

    function getSelectedEtatIds() {
        return [...document.querySelectorAll(".legend-checkbox:checked")]
            .map(cb => parseInt(cb.value));
    }

    function fillSelect(select, values, placeholder) {
        const currentValue = select.value;
        select.innerHTML = `<option value="">${placeholder}</option>`;

        [...values]
            .filter(v => v !== null && v !== undefined && String(v).trim() !== "")
            .sort((a, b) => String(a).localeCompare(String(b), 'fr', { sensitivity: 'base' }))
            .forEach(v => {
                const option = document.createElement("option");
                option.value = String(v);
                option.textContent = String(v);
                select.appendChild(option);
            });

        if ([...select.options].some(o => o.value === currentValue)) {
            select.value = currentValue;
        }
    }

    function populateFilters(points) {
        const provinces = new Set(points.map(p => p.province));
        const types = new Set(points.map(p => p.type_infra_description || getInfraLabel(p.type_infra_id)));

        fillSelect(filterProvince, provinces, "Sélectionner");
        fillSelect(filterTypeInfra, types, "Sélectionner");
        populateCommunes(points);
    }

    function populateCommunes(points) {
        const selectedProvince = filterProvince.value;

        const communes = new Set(
            points
                .filter(p => !selectedProvince || String(p.province) === selectedProvince)
                .map(p => p.commune)
        );

        fillSelect(filterCommune, communes, "Sélectionner");
    }

    function applyFilters(points) {
        const province = filterProvince.value;
        const commune = filterCommune.value;
        const typeInfra = filterTypeInfra.value;
        const selectedEtats = getSelectedEtatIds();

        return points.filter(p => {
            const pointType = p.type_infra_description || getInfraLabel(p.type_infra_id);

            const provinceMatch = !province || String(p.province) === province;
            const communeMatch = !commune || String(p.commune) === commune;
            const typeMatch = !typeInfra || String(pointType) === typeInfra;
            const etatMatch = selectedEtats.includes(parseInt(p.etat_id));

            return provinceMatch && communeMatch && typeMatch && etatMatch;
        });
    }

    function clearMarkers() {
        currentLayerGroup.clearLayers();
    }

    function renderMarkers(points) {
        clearMarkers();

        const bounds = [];

        points.forEach(p => {
            if (p.lat === null || p.lat === undefined || p.lng === null || p.lng === undefined) {
                return;
            }

            const lat = parseFloat(p.lat);
            const lng = parseFloat(p.lng);

            if (isNaN(lat) || isNaN(lng)) return;

            const marker = L.marker([lat, lng], {
                icon: createInfraIcon(p.type_infra_id, p.etat_id)
            });

            marker.bindTooltip(`
                <div style="min-width:180px">
                    <div><strong>${safeValue(p.nom || p.aep_nom)}</strong></div>
                    <div>Type : ${safeValue(p.type_infra_description || getInfraLabel(p.type_infra_id))}</div>
                    <div>État : ${safeValue(p.etat_description || getEtatLabel(p.etat_id))}</div>
                </div>
            `, {
                direction: "top",
                sticky: true,
                className: "custom-tooltip"
            });

            marker.on("click", function () {
                const infraName = p.nom || p.aep_nom || "Détail infrastructure";
                const infraCode = p.code || p.aep_code || "";
                const etatLabel = p.etat_description || getEtatLabel(p.etat_id);
                const typeInfraLabel = p.type_infra_description || getInfraLabel(p.type_infra_id);

                const defaultPhoto = "<?= base_url('assets/images/no-image.png') ?>";
                const photoUrl = (p.photo && String(p.photo).trim() !== "") ? p.photo : defaultPhoto;

                function infoItem(label, value, color = "#2563eb") {
                    return `
                        <div style="display:flex; gap:12px; min-height:54px;">
                            <div style="width:4px; min-width:4px; border-radius:999px; background:${color};"></div>
                            <div>
                                <div style="font-size:12px; text-transform:uppercase; letter-spacing:.03em; color:#6b7280; margin-bottom:3px;">
                                    ${label}
                                </div>
                                <div style="font-size:15px; font-weight:600; color:#1f2937; line-height:1.45;">
                                    ${safeValue(value)}
                                </div>
                            </div>
                        </div>
                    `;
                }

                function softBadge(text, bg, color, border, icon = "") {
                    return `
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            gap:8px;
                            padding:10px 16px;
                            border-radius:999px;
                            font-size:14px;
                            font-weight:600;
                            background:${bg};
                            color:${color};
                            border:1px solid ${border};
                        ">
                            ${icon ? `<span>${icon}</span>` : ""}
                            <span>${text}</span>
                        </span>
                    `;
                }

                modalTitle.textContent = infraName;
                modalSubTitle.textContent = infraCode ? `Code : ${infraCode}` : "Fiche descriptive";

                modalContent.innerHTML = `
                    <div style="width:100%;">

                        <div class="row g-3" style="margin-bottom:18px;">
                            <div class="col-lg-8">
                                <div style="
                                    background:linear-gradient(135deg,#f9fafb,#ffffff);
                                    border:1px solid #e5e7eb;
                                    border-radius:16px;
                                    padding:20px;
                                    box-shadow:0 6px 20px rgba(15,23,42,0.06);
                                    height:100%;
                                ">
                                    <div style="font-size:24px; font-weight:800; color:#1f2937; margin-bottom:6px;">
                                        ${safeValue(infraName)}
                                    </div>

                                    <div style="color:#6b7280; margin-bottom:14px;">
                                        Vue détaillée de l’infrastructure dans le système SIG de maintenance
                                    </div>

                                    <div style="display:flex; flex-wrap:wrap; gap:10px;">
                                        ${softBadge(`Code : ${safeValue(infraCode)}`, "#eff6ff", "#1d4ed8", "#bfdbfe", "🏷️")}
                                        ${softBadge(typeInfraLabel, "#eef2ff", "#5b21b6", "#ddd6fe", getInfraSymbol(p.type_infra_id))}
                                        ${softBadge(etatLabel, `${getEtatColor(p.etat_id)}18`, getEtatColor(p.etat_id), `${getEtatColor(p.etat_id)}55`, "●")}
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div style="
                                    background:#ffffff;
                                    border:1px solid #e5e7eb;
                                    border-radius:16px;
                                    overflow:hidden;
                                    box-shadow:0 6px 20px rgba(15,23,42,0.06);
                                    height:100%;
                                ">
                                    <div style="
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        padding:14px;
                                        background:#f8fafc;
                                        min-height:150px;
                                    ">
                                        <img
                                            src="${photoUrl}"
                                            alt="Photo maintenance"
                                            id="modalMaintenancePhoto"
                                            style="
                                                width:100%;
                                                max-width:220px;
                                                height:140px;
                                                object-fit:cover;
                                                border-radius:12px;
                                                cursor:pointer;
                                                border:1px solid #d1d5db;
                                                box-shadow:0 4px 12px rgba(0,0,0,0.08);
                                            "
                                            onerror="this.onerror=null; this.src='${defaultPhoto}';"
                                        >
                                    </div>

                                    <div style="
                                        padding:14px 16px;
                                        border-top:1px solid #e5e7eb;
                                        background:#fcfcfd;
                                    ">
                                        <div style="font-size:15px; font-weight:700; color:#1f2937; margin-bottom:3px;">
                                            Photo de maintenance
                                        </div>
                                        <div style="font-size:13px; color:#6b7280;">
                                            Cliquez sur l'image pour agrandir
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="
                            background:#ffffff;
                            border:1px solid #e5e7eb;
                            border-radius:16px;
                            overflow:hidden;
                            box-shadow:0 6px 20px rgba(15,23,42,0.06);
                            margin-bottom:18px;
                        ">
                            <div style="
                                display:flex;
                                align-items:center;
                                gap:10px;
                                padding:14px 18px;
                                background:#f8fafc;
                                border-bottom:1px solid #e5e7eb;
                                font-size:17px;
                                font-weight:800;
                                color:#1f2937;
                            ">
                                <span style="
                                    width:22px;
                                    height:22px;
                                    display:inline-flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:8px;
                                    background:#eff6ff;
                                    color:#2563eb;
                                    font-size:15px;
                                ">📘</span>
                                <span>Informations générales</span>
                            </div>

                            <div style="padding:18px; background:#fff;">
                                <div style="
                                    display:grid;
                                    grid-template-columns:repeat(2, minmax(0, 1fr));
                                    gap:14px 24px;
                                ">
                                    ${infoItem("Nom", infraName, "#3b82f6")}
                                    ${infoItem("AEP", p.aep_nom, "#3b82f6")}
                                    ${infoItem("Code AEP", p.aep_code, "#3b82f6")}
                                    ${infoItem("Province", p.province, "#3b82f6")}
                                    ${infoItem("Commune", p.commune, "#3b82f6")}
                                    ${infoItem("Statut", p.statut_id, "#3b82f6")}
                                </div>
                            </div>
                        </div>

                        <div style="
                            background:#ffffff;
                            border:1px solid #e5e7eb;
                            border-radius:16px;
                            overflow:hidden;
                            box-shadow:0 6px 20px rgba(15,23,42,0.06);
                            margin-bottom:18px;
                        ">
                            <div style="
                                display:flex;
                                align-items:center;
                                gap:10px;
                                padding:14px 18px;
                                background:#f8fafc;
                                border-bottom:1px solid #e5e7eb;
                                font-size:17px;
                                font-weight:800;
                                color:#1f2937;
                            ">
                                <span style="
                                    width:22px;
                                    height:22px;
                                    display:inline-flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:8px;
                                    background:#ecfdf5;
                                    color:#16a34a;
                                    font-size:15px;
                                ">🛠️</span>
                                <span>Informations de maintenance</span>
                            </div>

                            <div style="padding:18px; background:#fff;">
                                <div style="
                                    display:grid;
                                    grid-template-columns:repeat(2, minmax(0, 1fr));
                                    gap:14px 24px;
                                ">
                                    ${infoItem("Date maintenance", p.date_maintenance, "#22c55e")}
                                    ${infoItem("Date enregistrement", p.date_enregistrement, "#22c55e")}
                                    ${infoItem("Date modification", p.date_modification, "#22c55e")}
                                    ${infoItem("Agent", p.user, "#22c55e")}
                                    ${infoItem("Validateur", p.validateur, "#22c55e")}
                                </div>
                            </div>
                        </div>

                        <div style="
                            background:#ffffff;
                            border:1px solid #e5e7eb;
                            border-radius:16px;
                            overflow:hidden;
                            box-shadow:0 6px 20px rgba(15,23,42,0.06);
                            margin-bottom:18px;
                        ">
                            <div style="
                                display:flex;
                                align-items:center;
                                gap:10px;
                                padding:14px 18px;
                                background:#f8fafc;
                                border-bottom:1px solid #e5e7eb;
                                font-size:17px;
                                font-weight:800;
                                color:#1f2937;
                            ">
                                <span style="
                                    width:22px;
                                    height:22px;
                                    display:inline-flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:8px;
                                    background:#fff7ed;
                                    color:#f97316;
                                    font-size:15px;
                                ">📝</span>
                                <span>Commentaire</span>
                            </div>

                            <div style="padding:18px; background:#fff;">
                                <div style="
                                    background:#f8fafc;
                                    border-radius:14px;
                                    padding:16px;
                                    border-left:4px solid #f97316;
                                    color:#1f2937;
                                    line-height:1.7;
                                    min-height:90px;
                                ">
                                    ${safeValue(p.commentaire)}
                                </div>
                            </div>
                        </div>

                        <div style="
                            background:#ffffff;
                            border:1px solid #e5e7eb;
                            border-radius:16px;
                            overflow:hidden;
                            box-shadow:0 6px 20px rgba(15,23,42,0.06);
                            margin-bottom:0;
                        ">
                            <div style="
                                display:flex;
                                align-items:center;
                                gap:10px;
                                padding:14px 18px;
                                background:#f8fafc;
                                border-bottom:1px solid #e5e7eb;
                                font-size:17px;
                                font-weight:800;
                                color:#1f2937;
                            ">
                                <span style="
                                    width:22px;
                                    height:22px;
                                    display:inline-flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:8px;
                                    background:#f5f3ff;
                                    color:#8b5cf6;
                                    font-size:15px;
                                ">✅</span>
                                <span>Observation de validation</span>
                            </div>

                            <div style="padding:18px; background:#fff;">
                                <div style="
                                    background:#f8fafc;
                                    border-radius:14px;
                                    padding:16px;
                                    border-left:4px solid #8b5cf6;
                                    color:#1f2937;
                                    line-height:1.7;
                                    min-height:90px;
                                ">
                                    ${safeValue(p.observation_validation)}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                modal.show();

                setTimeout(() => {
                    const img = document.getElementById("modalMaintenancePhoto");
                    const zoomedImage = document.getElementById("zoomedImage");
                    const imageZoomModalEl = document.getElementById("imageZoomModal");

                    if (img && zoomedImage && imageZoomModalEl) {
                        img.onclick = function () {
                            const imageZoomModal = bootstrap.Modal.getOrCreateInstance(imageZoomModalEl);
                            zoomedImage.src = this.src;
                            imageZoomModal.show();
                        };
                    }
                }, 100);
            });

            marker.addTo(currentLayerGroup);
            bounds.push([lat, lng]);
        });

        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [30, 30] });
        }
    }

    function refreshView() {
        const filtered = applyFilters(allPoints);
        renderMarkers(filtered);
    }

    function checkAllLegend() {
        document.querySelectorAll(".legend-checkbox").forEach(cb => {
            cb.checked = true;
        });
        refreshView();
    }

    function uncheckAllLegend() {
        document.querySelectorAll(".legend-checkbox").forEach(cb => {
            cb.checked = false;
        });
        refreshView();
    }

    try {
        const url = "<?= base_url('sig/maintenance/data') ?>";
        const resp = await fetch(url);

        if (!resp.ok) {
            throw new Error(`Erreur HTTP ${resp.status}`);
        }

        allPoints = await resp.json();

        renderLegend();
        populateFilters(allPoints);
        renderMarkers(allPoints);

        filterProvince.addEventListener("change", function () {
            populateCommunes(allPoints);
            refreshView();
        });

        filterCommune.addEventListener("change", refreshView);
        filterTypeInfra.addEventListener("change", refreshView);

        btnResetFilters.addEventListener("click", function () {
            filterProvince.value = "";
            filterCommune.value = "";
            filterTypeInfra.value = "";
            populateCommunes(allPoints);
            checkAllLegend();
            renderMarkers(allPoints);
        });

        btnCheckAllLegend.addEventListener("click", checkAllLegend);
        btnUncheckAllLegend.addEventListener("click", uncheckAllLegend);

    } catch (e) {
        console.error("Erreur chargement points:", e);
    }

    setTimeout(() => map.invalidateSize(), 500);
});
</script>

<?php echo view('includes/footer') ?>