<footer class="app-footer"> <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline"></div> <!--end::To the end--> <!--begin::Copyright--> <strong>
                Copyright &copy;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo date('Y') ?> &nbsp;
                <a href="#" class="text-decoration-none">AHAMR</a>.
            </strong>
            All rights reserved.
            <!--end::Copyright-->
        </footer> <!--end::Footer-->
    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="<?php echo base_url('assets/js/overlayscrollbars.browser.es6.min.js') ?>"  ></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="<?php echo base_url('assets/js/popper.min.js') ?>" ></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" ></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="<?php echo base_url('assets/js/adminlte.js') ?>"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <!-- Jquery -->

    <script src="<?php echo base_url('assets/js/code.jquery.com_jquery-3.7.0.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/datatables.min.js') ?>"></script>

    <!--  Select2 -->
    <script src="<?php echo base_url('assets/js/select2.min.js') ?>"></script>
<script>

        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> <!--end::OverlayScrollbars Configure--> <!--end::Script-->
<script>
function checkSession() {
    $.ajax({
        url: "<?php echo base_url('checkSession') ?>",
        method: "GET",
        dataType: "json",
        success: function(response) {
            if (!response.active) {
                location.reload(); // Actualise la page actuelle
            }
        },
        error: function() {
            console.error("Erreur lors de la vérification de session.");
        }
    });
}
// Vérifie toutes les 30 secondes
setInterval(checkSession, 30000);
</script>
        <script>
        function mettreAJourHorloge() {
            const maintenant = new Date();
            const heures = String(maintenant.getHours()).padStart(2, '0');
            const minutes = String(maintenant.getMinutes()).padStart(2, '0');
            const secondes = String(maintenant.getSeconds()).padStart(2, '0');
            document.getElementById('clockA').textContent = `${heures}:${minutes}:${secondes}`;
        }

        setInterval(mettreAJourHorloge, 1000);
        mettreAJourHorloge(); // Appel initial
    </script>

</body><!--end::Body-->

</html>
