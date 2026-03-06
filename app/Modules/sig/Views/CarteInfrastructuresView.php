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
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Infrastructure</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Chantier
                                </li>
                            </ol>
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
                                    <div id="map" style="height:600px; width:100%; border-radius:16px;"></div>
                                </div> <!-- /.card-body -->
                            </div> <!-- /.card -->
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main> <!--end::App Main--> <!--begin::Footer-->

        <div class="modal fade" id="infraModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">

                    <div class="modal-header text-white border-0 px-4 py-3"
                        style="background: linear-gradient(135deg, #0d6efd, #0b57d0);">
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

<!-- SCRIPT LEAFLET ICI (IMPORTANT) -->
<script>
document.addEventListener("DOMContentLoaded", async function () {
    if (typeof L === "undefined") {
        console.error("Leaflet non chargé (L undefined).");
        return;
    }

    const map = L.map("map").setView([-3.3731, 29.9189], 8);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: "&copy; OpenStreetMap contributors",
    }).addTo(map);

    const modal = new bootstrap.Modal(document.getElementById("infraModal"));
    const modalTitle = document.getElementById("modalTitle");
    const modalSubTitle = document.getElementById("modalSubTitle");
    const modalContent = document.getElementById("modalContent");

    function safeValue(v) {
        return (v !== null && v !== undefined && String(v).trim() !== "")
            ? String(v)
            : `<span class="text-muted fst-italic">Non renseigné</span>`;
    }
// sig/carte_infrastructure
    function badgeEtat(etat) {
        const value = (etat || "").toLowerCase();

        if (value.includes("bon") || value.includes("fonction")) {
            return `<span class="badge rounded-pill px-3 py-2" style="background:#e8f8ee;color:#18864b;border:1px solid #ccefd8;">${etat}</span>`;
        }
        if (value.includes("moyen")) {
            return `<span class="badge rounded-pill px-3 py-2" style="background:#fff4db;color:#a16207;border:1px solid #fde7b0;">${etat}</span>`;
        }
        if (value.includes("panne") || value.includes("mauvais")) {
            return `<span class="badge rounded-pill px-3 py-2" style="background:#fdecec;color:#c0392b;border:1px solid #f5c2c7;">${etat}</span>`;
        }

        return `<span class="badge rounded-pill px-3 py-2 bg-secondary">${etat || "Non défini"}</span>`;
    }

    function item(label, value) {
        return `
            <div class="col-md-6">
                <div class="h-100 rounded-4 border bg-white px-3 py-3 shadow-sm">
                    <div class="text-uppercase fw-bold small mb-2" style="color:#6b7280; letter-spacing:0.04em;">
                        ${label}
                    </div>
                    <div class="fw-semibold" style="color:#111827; font-size:15px;">
                        ${safeValue(value)}
                    </div>
                </div>
            </div>
        `;
    }

    try {
        const url = "<?= base_url('sig/carte_infrastructure/points') ?>";
        console.log("URL appelée :", url);

        const resp = await fetch(url);

        if (!resp.ok) {
            throw new Error(`Erreur HTTP ${resp.status}`);
        }

        const points = await resp.json();
        console.log("Points :", points);

        const bounds = [];

        points.forEach(p => {
            if (!p.lat || !p.lng) return;

            const marker = L.marker([p.lat, p.lng]).addTo(map);

            marker.on("click", function () {
                modalTitle.textContent = p.nom || "Détail infrastructure";
                modalSubTitle.textContent = p.code ? `Code : ${p.code}` : "Fiche descriptive";

                modalContent.innerHTML = `
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div class="d-inline-flex align-items-center gap-2 rounded-pill px-3 py-2"
                             style="background:#e8f0ff; color:#0b57d0; border:1px solid #cfe0ff; font-weight:700;">
                            <span>Code</span>
                            <span>${safeValue(p.code)}</span>
                        </div>

                        <div>
                            ${badgeEtat(p.etat)}
                        </div>
                    </div>

                    <div class="rounded-4 border bg-white p-4 shadow-sm mb-4">
                        <div class="fw-bold mb-3 pb-2"
                             style="font-size:16px; color:#172033; border-bottom:1px solid #eef2f7;">
                            Informations générales
                        </div>
                        <div class="row g-3">
                            ${item("Nom", p.nom)}
                            ${item("AEP", p.aep)}
                            ${item("Code", p.code)}
                            ${item("État", p.etat)}
                        </div>
                    </div>

                    <div class="rounded-4 border bg-white p-4 shadow-sm mb-4">
                        <div class="fw-bold mb-3 pb-2"
                             style="font-size:16px; color:#172033; border-bottom:0px solid #eef2f7;">
                            Classification
                        </div>
                        <div class="row g-3">
                            ${item("Type infrastructure", p.type_infra)}
                            ${item("Matériel", p.materiel)}
                            ${item("Fonctionnalité", p.fonctionnalite_id)}
                        </div>
                    </div>

                    <div class="rounded-4 border bg-white p-4 shadow-sm">
                        <div class="fw-bold mb-3 pb-2"
                             style="font-size:16px; color:#172033; border-bottom:1px solid #eef2f7;">
                            Observation
                        </div>
                        <div class="rounded-4 px-3 py-3"
                             style="background:#f9fbff; border:1px solid #e8eef8; color:#1f2937; line-height:1.7;">
                            ${safeValue(p.observation)}
                        </div>
                    </div>
                `;

                modal.show();
            });

            bounds.push([p.lat, p.lng]);
        });

        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [30, 30] });
        }

    } catch (e) {
        console.error("Erreur chargement points:", e);
    }

    setTimeout(() => map.invalidateSize(), 500);
});
</script>
<?php echo view('includes/footer') ?>

