<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title id="titre">Tanganyika Urisanze Lodge Hotel</title><!--begin::Primary Meta Tags-->
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Tanganyika Urisanze Lodge Hotel | Login">
    <meta name="author" content="Julius">
    <meta name="description" content="Tanganyika Urisanze Lodge Hotel">
    <meta name="keywords" content="Tanganyika Urisanze Lodge Hotel"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/favicon.ico') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/adminlte.css') ?>"><!--end::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-icons.min.css') ?>">
</head> <!--end::Head--> <!--begin::Body-->
<style>
.btn-color{
  background-color:rgb(48, 49, 49);
  color: #fff;

}
.btn-color:hover {
            background-color: #23272A; /* Légèrement plus foncé au survol */
            color: #fff;
}
.profile-image-pic{
  height: 200px;
  width: 200px;
  object-fit: cover;
}



.cardbody-color{
  background-color: #ebf2fa;
}

a{
  text-decoration: none;
}
    body {
      background-image: url(<?php echo base_url('assets/img/loginbg.jpg') ?>); /* chemin vers ton image */
      background-size: cover; /* ajuste l'image pour couvrir tout l'écran */
      background-repeat: no-repeat; /* évite la répétition */
      background-position: center center; /* centre l'image */
    }
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


<body class="login-page bg-body-secondary">
    <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">

        <div class="card my-5">
          <form class="card-body cardbody-color p-lg-5" id="loginForm" >
            <div class="text-center">
              <img src="<?php echo base_url('assets/img/logologin.jpg') ?>" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                width="200px" alt="profile">
            </div>

            <div class="mb-3">
            <input type="text" class="form-control" id="USERNAME" name="USERNAME" placeholder="Email ou Tél">

              <!-- <input type="text" class="form-control" id="Username" aria-describedby="emailHelp"
                placeholder="User Name"> -->
            </div>
            <div class="input-group password-wrapper mb-3 position-relative">
            <input type="password" class="form-control" placeholder="Password" id="PASSWORD" name="PASSWORD">
            <i class="bi bi-eye toggle-password" onclick="togglePassword(this, 'PASSWORD')"></i>
            </div>
            <div class="text-center">
            <button id="btnsb" type="button" class="btn btn-color px-5 mb-5 w-100">Connexion</button>

        </div>

          </form>
        </div>

      </div>
    </div>
  </div>



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

// Vérifier le champ "Nom du chantier"
let USERNAME = $("#USERNAME").val();
if (USERNAME.trim() === "") {
    isValid = false;
    $("#USERNAME").addClass("is-invalid")
        .after('<div class="invalid-feedback">Le nom d\'utilisateur est obligatoire.</div>');
}
// Vérifier la date de création
let PASSWORD = $("#PASSWORD").val();
if (PASSWORD === "") {
    isValid = false;
    $("#PASSWORD").addClass("is-invalid")
        .after('<div class="invalid-feedback">Le mot de passe est obligatoire.</div>');
}

const loginForm = document.getElementById("loginForm");

// Si tout est valide, envoyer les données via AJAX
if (isValid) {
    let formData = new FormData(loginForm);
    console.log(formData);
    $("#btnsb").prop('disabled', true).text('connexion...');
    $.ajax({
        url: "<?php echo base_url('login') ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                window.location.href = response.redirect_url;
            }else{
                $('#responseMessage').html("<div class='alert alert-danger'>Nom d'utilisateur ou mot de passe incorect</div>").fadeIn();
            }
        },
        error: function (xhr, status, error) {
            $('#responseMessage').html("<div class='alert alert-danger'>Une erreur s'est produite : "+error+"</div>").fadeIn();
        },
        complete:function(){
            $("#btnsb").prop('disabled', false).text('Connexion');
           // Masquer le message après 5 secondes
           setTimeout(() => {
                $('#responseMessage').fadeOut();
            }, 5000);
        }
    });
}
});
    </script>
<script>
    function togglePassword(icon, fieldId) {
        const input = document.getElementById(fieldId);
        const isVisible = input.type === "text";

        input.type = isVisible ? "password" : "text";
        icon.classList.toggle("bi-eye");
        icon.classList.toggle("bi-eye-slash");
    }
</script>

</body><!--end::Body-->

</html>
