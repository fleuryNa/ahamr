<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Tanganyika Urisanze Lodge Hotel</title><!--begin::Primary Meta Tags-->
    <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico') ?>" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Tanganyika Urisanze Lodge Hotel | Login">
    <meta name="author" content="Julius">
    <meta name="description" content="Tanganyika Urisanze Lodge Hotel">
    <meta name="keywords" content="Tanganyika Urisanze Lodge Hotel"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/index.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/overlayscrollbars.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-icons.min.css') ?>">
    <style>
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 40px; /* espace pour l'icône */
        }

        .password-wrapper .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #ccc;
        }

        .password-wrapper .toggle-password:hover {
            color: #333;
        }


    </style>
  <style>
    body {
      background-image: url(<?php echo base_url('assets/img/loginbg.jpg') ?>);
      background-size: cover; /* ajuste l'image pour couvrir tout l'écran */
      background-repeat: no-repeat; /* évite la répétition */
      background-position: center center; /* centre l'image */
    }
  </style>

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/adminlte.css') ?>"><!--end::Required Plugin(AdminLTE)-->
</head> <!--end::Head--> <!--begin::Body-->

<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div id="responseMessage"></div>
        <!-- <div class="login-logo"> <a href="#">Tanganyika Urisanze Lodge Hotel</a> </div>  -->
        <div class="text-small text-bg-light"><p>Bienvenue                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php echo $connexion['PRENOM'] ?> , veuillez créer votre mot de passe.</p></div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Création de mot de passe</p>
            <form id="loginForm">
                <input type="hidden" name="USER_ID" id="USER_ID" value="<?php echo $connexion['USER_ID'] ?>">
                <div class="password-wrapper mb-3 position-relative">
                    <input type="password" id="PASSWORD" name="PASSWORD" class="form-control" placeholder="Nouveau mot de passe">
                    <i class="bi bi-eye toggle-password" onclick="togglePassword(this, 'PASSWORD')"></i>
                </div>

                <div class="password-wrapper mb-3 position-relative">
                    <input type="password" id="CPASSWORD"  name="CPASSWORD" class="form-control" placeholder="Confirmer le mot de passe">
                    <i class="bi bi-eye toggle-password" onclick="togglePassword(this, 'CPASSWORD')"></i>
                </div>
                    <div class="row">
                        <div class="col-8">

                        </div> <!-- /.col -->
                        <div class="col-4">
                            <div class="d-grid gap-2"> <button id="btnsb" type="button" class="btn btn-secondary">Enregistrer</button> </div>
                        </div> <!-- /.col -->
                    </div> <!--end::Row-->

            </form>

<script>
    function togglePassword(icon, fieldId) {
        const input = document.getElementById(fieldId);
        const isVisible = input.type === "text";

        input.type = isVisible ? "password" : "text";
        icon.classList.toggle("bi-eye");
        icon.classList.toggle("bi-eye-slash");
    }
</script>



            </div> <!-- /.login-card-body -->
        </div>
    </div> <!-- /.login-box --> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="<?php echo base_url('assets/js/overlayscrollbars.browser.es6.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/popper.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>  -->
    <script src="<?php echo base_url('assets/js/adminlte.js') ?>"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script src="<?php echo base_url('assets/js/code.jquery.com_jquery-3.7.0.min.js') ?>"></script>

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
$("#btnsb").on("click", function (e) {
    e.preventDefault(); // Empêche la soumission traditionnelle

    // Réinitialiser les messages d'erreur
    $(".is-invalid").removeClass("is-invalid");
    $(".invalid-feedback").remove();

    let isValid = true;

    // Vérifier les champs de mot de passe
    let PASSWORD = $("#PASSWORD").val();
    let CPASSWORD = $("#CPASSWORD").val();

    if (PASSWORD.trim() === "") {
        isValid = false;
        $("#PASSWORD").addClass("is-invalid")
            .after('<div class="invalid-feedback">Le mot de passe est obligatoire.</div>');
    } else {
        // Appeler la fonction de validation du mot de passe
        const pwdValidation = validerMotDePasse(PASSWORD);
        if (pwdValidation !== true) {
            isValid = false;
            $("#PASSWORD").addClass("is-invalid")
                .after('<div class="invalid-feedback">' + pwdValidation + '</div>');
        } else if (PASSWORD !== CPASSWORD) {
            isValid = false;
            $("#CPASSWORD").addClass("is-invalid")
                .after('<div class="invalid-feedback">Les mots de passe ne correspondent pas.</div>');
        }
    }

    const loginForm = document.getElementById("loginForm");

    // Si tout est valide, envoyer les données via AJAX
    if (isValid) {
        let formData = new FormData(loginForm);
        $("#btnsb").prop('disabled', true).text('Enregistrement...');
        $.ajax({
            url: "<?php echo base_url('savenewpassword') ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $('#responseMessage').html("<div class='alert alert-success'>Mot de passe créé avec succès. Redirection dans 5 secondes...</div>").fadeIn();

                    setTimeout(function () {
                        window.location.href = response.redirect_url;
                    }, 5000); // 5000 ms = 5 secondes
                } else {
                    $('#responseMessage').html("<div class='alert alert-danger'>Nom d'utilisateur ou mot de passe incorrect.</div>").fadeIn();
                }
            },
            error: function (xhr, status, error) {
                $('#responseMessage').html("<div class='alert alert-danger'>Une erreur s'est produite : " + error + "</div>").fadeIn();
            },
            complete: function () {
                $("#btnsb").prop('disabled', false).text('Enregistrer');
                setTimeout(() => {
                    $('#responseMessage').fadeOut();
                }, 5000);
            }
        });
    }
});

    </script>
<script>
function validerMotDePasse(password) {
    const minLength = 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasDigit     = /[0-9]/.test(password);
    const hasSpecial   = /[!@#\$%\^\&*\)\(+=._-]/.test(password);

    if (password.length < minLength) {
        return "Le mot de passe doit contenir au moins 8 caractères.";
    }
    if (!hasUppercase) {
        return "Le mot de passe doit contenir au moins une lettre majuscule.";
    }
    if (!hasLowercase) {
        return "Le mot de passe doit contenir au moins une lettre minuscule.";
    }
    if (!hasDigit) {
        return "Le mot de passe doit contenir au moins un chiffre.";
    }
    if (!hasSpecial) {
        return "Le mot de passe doit contenir au moins un caractère spécial.";
    }

    return true; // mot de passe valide
}
</script>




</body><!--end::Body-->

</html>
