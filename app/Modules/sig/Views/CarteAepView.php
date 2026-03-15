<?php echo view('includes/head'); ?>
<?php echo view('includes/sidebar'); ?>

<style>
    .aep-page .card {
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
        height: 700px;
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

    .filter-label {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    .legend-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 10px;
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

    .custom-aep-marker {
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .custom-aep-marker:hover {
        transform: scale(1.06);
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

<main class="app-main aep-page">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Carte Réseau AEP</h3>
                    <div class="text-muted small mt-1">
                        Visualisation des AEP reliés via EXECUTANT
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="#">SIG</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Carte Réseau AEP</li>
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

<script>
document.addEventListener("DOMContentLoaded", async function () {
    if (typeof L === "undefined") {
        console.error("Leaflet non chargé");
        return;
    }

    const map = L.map("map").setView([-3.37, 29.91], 8);

    L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        {
            maxZoom: 8,
            attribution: "© OpenStreetMap"
        }
    ).addTo(map);

    const filterProvince = document.getElementById("filterProvince");
    const filterCommune = document.getElementById("filterCommune");
    const btnResetFilters = document.getElementById("btnResetFilters");
    const btnCheckAllLegend = document.getElementById("btnCheckAllLegend");
    const btnUncheckAllLegend = document.getElementById("btnUncheckAllLegend");
    const legendEtat = document.getElementById("legendEtat");

    let allPoints = [];
    let currentLayerGroup = L.layerGroup().addTo(map);

    const infraConfig = {
        1: { label: "Captage", color: "#0d6efd", symbol: "💧" },
        2: { label: "Chambre", color: "#7c3aed", symbol: "🏠" },
        3: { label: "Conduite", color: "#f97316", symbol: "📏" },
        4: { label: "Réservoir", color: "#16a34a", symbol: "🛢️" },
        5: { label: "Branchement", color: "#dc3545", symbol: "🚰" }
    };

    function safeValue(v) {
        return (v !== null && v !== undefined && String(v).trim() !== "")
            ? String(v)
            : "Non renseigné";
    }

    function getInfraSymbol(typeInfraId) {
        return infraConfig[parseInt(typeInfraId)]?.symbol || "📍";
    }

    function getInfraColor(typeInfraId) {
        return infraConfig[parseInt(typeInfraId)]?.color || "#6b7280";
    }

    function getInfraLabel(typeInfraId) {
        return infraConfig[parseInt(typeInfraId)]?.label || "Infrastructure";
    }

    function createMarkerIcon(typeInfraId) {
        const symbol = getInfraSymbol(typeInfraId);
        const color = getInfraColor(typeInfraId);

        return L.divIcon({
            className: "",
            html: `
                <div class="custom-aep-marker" style="
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    background: ${color};
                    color: white;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 16px;
                    font-weight: bold;
                    border: 3px solid #ffffff;
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
        legendEtat.innerHTML = Object.entries(infraConfig).map(([id, conf]) => `
            <div class="legend-compact-item">
                <label class="legend-left">
                    <input
                        type="checkbox"
                        class="form-check-input legend-checkbox"
                        value="${id}"
                        checked
                    >
                    <span class="legend-color" style="background:${conf.color};"></span>
                    <span style="font-size:13px; color:#0f172a; font-weight:600;">
                        ${conf.symbol} ${conf.label}
                    </span>
                </label>
            </div>
        `).join("");

        document.querySelectorAll(".legend-checkbox").forEach(cb => {
            cb.addEventListener("change", refreshView);
        });
    }

    function getSelectedTypeIds() {
        return [...document.querySelectorAll(".legend-checkbox:checked")]
            .map(cb => parseInt(cb.value));
    }

    function fillSelect(select, values, placeholder) {
        const currentValue = select.value;
        select.innerHTML = `<option value="">${placeholder}</option>`;

        [...values]
            .filter(v => v !== null && v !== undefined && String(v).trim() !== "")
            .sort((a, b) => String(a).localeCompare(String(b), "fr", { sensitivity: "base" }))
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
        fillSelect(filterProvince, provinces, "Sélectionner");
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
        const selectedTypes = getSelectedTypeIds();

        return points.filter(p => {
            const provinceMatch = !province || String(p.province) === province;
            const communeMatch = !commune || String(p.commune) === commune;
            const typeMatch = selectedTypes.includes(parseInt(p.type_infra_id));

            return provinceMatch && communeMatch && typeMatch;
        });
    }

    function clearMap() {
        currentLayerGroup.clearLayers();
    }

    function renderMarkers(points) {
        clearMap();

        const bounds = [];

        points.forEach((p, index) => {
            const lat = parseFloat(p.lat);
            const lng = parseFloat(p.lng);

            if (isNaN(lat) || isNaN(lng)) return;

            const offset = index * 0.00015;
            const displayLat = lat + offset;
            const displayLng = lng + offset;

            const marker = L.marker([displayLat, displayLng], {
                icon: createMarkerIcon(p.type_infra_id)
            }).addTo(currentLayerGroup);

            marker.bindTooltip(`
                <div style="min-width:220px">
                    <div><strong>${safeValue(p.aep_nom)}</strong></div>
                    <div>Code AEP : ${safeValue(p.aep_code)}</div>
                    <div>Type : ${safeValue(p.type_infra || getInfraLabel(p.type_infra_id))}</div>
                    <div>Province : ${safeValue(p.province)}</div>
                    <div>Commune : ${safeValue(p.commune)}</div>
                    <div>Suit : ${safeValue(p.parent_code || 'Source')}</div>
                </div>
            `, {
                direction: "top",
                sticky: true,
                className: "custom-tooltip"
            });

            bounds.push([displayLat, displayLng]);

            if (
                p.parent_lat !== null &&
                p.parent_lat !== undefined &&
                p.parent_lng !== null &&
                p.parent_lng !== undefined &&
                !isNaN(parseFloat(p.parent_lat)) &&
                !isNaN(parseFloat(p.parent_lng))
            ) {
                L.polyline(
                    [
                        [parseFloat(p.parent_lat), parseFloat(p.parent_lng)],
                        [displayLat, displayLng]
                    ],
                    {
                        color: "#0d6efd",
                        weight: 4,
                        opacity: 0.8
                    }
                ).addTo(currentLayerGroup);
            }
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
        const resp = await fetch("<?= base_url('sig/aep_map/data') ?>");

        if (!resp.ok) {
            throw new Error("Erreur chargement");
        }

        allPoints = await resp.json();
        console.log("Points reçus :", allPoints);

        renderLegend();
        populateFilters(allPoints);
        renderMarkers(allPoints);

        filterProvince.addEventListener("change", function () {
            populateCommunes(allPoints);
            refreshView();
        });

        filterCommune.addEventListener("change", refreshView);

        btnResetFilters.addEventListener("click", function () {
            filterProvince.value = "";
            filterCommune.value = "";
            populateCommunes(allPoints);
            checkAllLegend();
            renderMarkers(allPoints);
        });

        btnCheckAllLegend.addEventListener("click", checkAllLegend);
        btnUncheckAllLegend.addEventListener("click", uncheckAllLegend);

    } catch (e) {
        console.error(e);
    }

    setTimeout(() => map.invalidateSize(), 500);
});
</script>

<?php echo view('includes/footer'); ?>