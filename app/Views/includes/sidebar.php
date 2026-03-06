<?php
    $segments = service('uri')->getSegments();
    $userdata = session()->get("userdata");
    // print_r($userdata);
    function hasRole($requiredRole)
    {
    $roles = session()->get('role') ?? [];
    return in_array($requiredRole, $roles);
    }
?>
<!--begin::Body-->
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
   <!--begin::App Wrapper-->
   <div class="app-wrapper">
   <!--begin::Header-->
   <nav class="app-header navbar navbar-expand bg-body-secondary" data-bs-theme="dark">
      <!--begin::Container-->
      <div class="container-fluid">
         <!--begin::Start Navbar Links-->
         <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
            <li class="nav-item d-none d-md-block">
               <span class="bi bi-clock bg-light"></span>
               <div class="badge badge-light"  id="clockA"></div>
            </li>
         </ul>
         <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
         <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item"> <a class="nav-link" data-widget="navbar-search" href="#" role="button"> <i class="bi bi-search"></i> </a> </li>
            <!--end::Navbar Search--> <!--begin::Messages Dropdown Menu-->
            <!--begin::Notifications Dropdown Menu-->
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li>
            <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
               <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <img src="<?php echo base_url('assets/img/user2-160x160.png') ?>" class="user-image rounded-circle shadow" alt="User Image"> <span class="d-none d-md-inline"><?php echo $userdata['NOM'] . " " . $userdata['PRENOM'] ?></span> </a>
               <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                  <!--begin::User Image-->
                  <li class="user-header text-bg-primary">
                     <img src="<?php echo base_url('assets/img/user2-160x160.png') ?>" class="rounded-circle shadow" alt="User Image">
                     <p>
                        <?php echo $userdata['PRO_DESCR'] ?>
                     </p>
                  </li>
                  <!--end::User Image--> <!--begin::Menu Body-->
                  <!--begin::Menu Footer-->
                  <li class="user-footer"> <a href="#" class="btn btn-default btn-flat">Profile</a> <a href="<?php echo base_url('logout') ?>" class="btn btn-default btn-flat float-end">Sign out</a> </li>
                  <!--end::Menu Footer-->
               </ul>
            </li>
            <!--end::User Menu Dropdown-->
         </ul>
         <!--end::End Navbar Links-->
      </div>
      <!--end::Container-->
   </nav>
   <!--end::Header--> <!--begin::Sidebar-->
   <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
         <!--begin::Brand Link-->
         <a href="#" class="brand-link">
            <!--begin::Brand Image--> <img src="<?php echo base_url('assets/img/mainlogo.png') ?>" alt="AHAMR" style="width: 126px; max-height: 60px;" class="brand-image opacity-75 "> <!--end::Brand Image-->
         </a>
         <!--end::Brand Link-->
      </div>
      <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
         <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
               <?php if (hasRole('dashboard')): ?>
               <li class="nav-item<?php echo(in_array('dashboard', $segments)) ? ' menu-open' : ''; ?>">
                  <a href="#" class="nav-link">
                     <i class="nav-icon bi bi-speedometer"></i>
                     <p>
                        Dashboard
                        <i class="nav-arrow bi bi-chevron-right"></i>
                     </p>
                  </a>
                  <ul class="nav nav-treeview">
                     <li class="nav-item">
                        <a href="<?php echo base_url('dashboard') ?>" class="nav-link<?php echo(end($segments) == 'dashboard') ? ' active' : ''; ?>">
                           <i class="nav-icon bi bi-graph-up"></i>
                           <p>Général</p>
                        </a>
                     </li>

                  </ul>
               </li>
               <?php endif; ?>


            <?php if (hasRole('admin')): ?>
               <li class="nav-item<?php echo(in_array('admin', $segments)) ? ' menu-open' : ''; ?>">
                  <a href="#" class="nav-link ">
                     <i class="nav-icon bi bi-gear-fill"></i>
                     <p>
                        Adminstration
                        <i class="nav-arrow bi bi-chevron-right"></i>
                     </p>
                  </a>
                  <ul class="nav nav-treeview">
                     <li class="nav-item">
                        <a href="<?php echo base_url('admin/users') ?>" class="nav-link<?php echo(end($segments) === 'users') ? ' active' : ''; ?>">
                           <i class="nav-icon bi bi-person"></i>
                           <p>Utilisateur</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="<?php echo base_url('admin/profil') ?>" class="nav-link<?php echo(end($segments) === 'profil') ? ' active' : ''; ?> ">
                           <i class="nav-icon bi bi-shield"></i>
                           <p>Profil</p>
                        </a>
                     </li>
                  </ul>
               </li>
               <?php endif; ?>

               
                  <li class="nav-item<?php echo(in_array('sig', $segments)) ? ' menu-open' : ''; ?>">
                     <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-map"></i>
                        <p>
                           SIG
                           <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                     </a>

                     <ul class="nav nav-treeview">

                        <li class="nav-item">
                           <a href="<?php echo base_url('sig/carte_infrastructure') ?>"
                              class="nav-link<?php echo(end($segments) === 'infrastructure') ? ' active' : ''; ?>">
                              <i class="nav-icon bi bi-diagram-3"></i>
                              <p>Infrastructure</p>
                           </a>
                        </li>

                     </ul>
                  </li>
              
            </ul>
            <!--end::Sidebar Menu-->
         </nav>
      </div>
      <!--end::Sidebar Wrapper-->
   </aside>
   <!--end::Sidebar-->
   <!-- ovarlay -->
   <div id="loadingOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; text-align:center;">
      <div class="spinner-border text-light" role="status" style="margin-top:20%;"></div>
      <p class="text-light">Traitement en cours...</p>
   </div>
   <!-- end ovarlay -->