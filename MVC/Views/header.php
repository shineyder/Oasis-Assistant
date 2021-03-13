<?php

//header

use lib\Session;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo (isset($this->title)) ? $this->title : 'Oasis Assistant';?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/all.min.css";?>>
    <!-- Theme style -->
    <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/adminlte.min.css";?>>
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/OverlayScrollbars.min.css";?>>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/toastr.min.css";?>>
    <!-- DataTables -->
    <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/dataTables.bootstrap4.min.css";?>>
    <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/responsive.bootstrap4.min.css";?>>

    <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/style.css";?>>
    <link rel="shortcut icon" href=<?php echo URL . "_img/logo/logo_oasis_assistant_min.ico";?>>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<?php Session::init();?>
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-red navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href=<?php echo URL . "home";?> class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href=<?php echo URL . "contact_us";?> class="nav-link">Fale Conosco</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href=<?php echo URL . "faq";?> class="nav-link">F.A.Q.</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href=<?php echo URL . "home/logout";?> class="nav-link">Sair</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href=<?php echo URL?> class="brand-link elevation-4">
        <img src=<?php echo URL . "_img/logo/logo_oasis_assistant_min-2.png";?>
            alt="Oasis Assistant Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Oasis Assistant</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                    <?php if (Session::get('access') >= 8) :?>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>
                                Master Page
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href=<?php echo URL . "masterPub";?> class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Publicadores</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href=<?php echo URL . "masterReq";?> class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Solicitações</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif;?>

                    <?php if (Session::get('access') >= 2) :?>
                        <li class="nav-header">Território</li>

                        <li class="nav-item">
                            <a href=<?php echo URL . "myReports";?> class="nav-link">
                            <i class="nav-icon fas fa-street-view"></i>
                            <p>
                                Meus Relatórios
                            </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=<?php echo URL . "territory";?> class="nav-link">
                            <i class="nav-icon fas fa-map"></i>
                            <p>
                                Visualizar Territórios
                            </p>
                            </a>
                        </li>
                    <?php endif;?>

                    <li class="nav-header">Outros</li>

                    <li class="nav-item">
                        <a href=<?php echo URL . "contactUs";?> class="nav-link">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            Fale Conosco
                        </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=<?php echo URL . "faq";?> class="nav-link">
                        <i class="nav-icon fas fa-question"></i>
                        <p>
                            F.A.Q.
                        </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=<?php echo URL . "home/logout";?> class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Sair
                        </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- ABERTURA DAS ESTRUTURAS DE CONTEUDO-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?php echo $this->local;?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href=<?php echo URL . "home";?>>Home</a></li>
                                <li class="breadcrumb-item active"><?php echo $this->local;?></a></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
    <!-- /.ABERTURA DAS ESTRUTURAS DE CONTEUDO-->
