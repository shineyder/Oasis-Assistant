<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Oasis Assistant</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="_CSS/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="_CSS/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="_CSS/OverlayScrollbars.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="_CSS/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="_CSS/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="_CSS/responsive.bootstrap4.min.css">

    <link rel="stylesheet" href= "_CSS/style.css"/>
    <link rel="shortcut icon" href="img/logo_oasis_assistant_min.ico">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
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
                <a href="home.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="contact_us.php" class="nav-link">Fale Conosco</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="faq.php" class="nav-link">F.A.Q.</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="phpaction/logout.php" class="nav-link">Sair</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index.php" class="brand-link elevation-4">
        <img src="img/logo_oasis_assistant_min-2.png"
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
                    <?php
                    if ($publicador->getAccess() >= 8) :
                        ?>
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
                                    <a href="master_page_pub.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Publicadores</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="master_page_req.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Solicitações</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                    endif;

                    if ($publicador->getAccess() >= 2) :
                        ?>
                        <li class="nav-header">Território</li>

                        <li class="nav-item">
                            <a href="my_reports.php" class="nav-link">
                            <i class="nav-icon fas fa-street-view"></i>
                            <p>
                                Meus Relatórios
                            </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="view_territory.php" class="nav-link">
                            <i class="nav-icon fas fa-map"></i>
                            <p>
                                Visualizar Territórios
                            </p>
                            </a>
                        </li>
                        <?php
                    endif;
                    ?>

                    <li class="nav-header">Outros</li>

                    <li class="nav-item">
                        <a href="contact_us.php" class="nav-link">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            Fale Conosco
                        </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="faq.php" class="nav-link">
                        <i class="nav-icon fas fa-question"></i>
                        <p>
                            F.A.Q.
                        </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="phpaction/logout.php" class="nav-link">
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
<!--
    <header class="cabecalho row">
        <div class="center">
            <img id="logo" src="../img/logo_oasis_assistant.png" alt="Logo Oásis Assistant">
        </div>
        
        <?php
        //if (isset($_SESSION['logado'])) :
        ?>
            <div class="cabecalho-inf col s12 center">
                <a href="home.php" class="btn-small blue darken-2">Ver Perfil</a>

                <?php
                //if ($publicador->getAccess() >= 8) :
                ?>
                <a href="master_page.php" class="btn-small blue darken-2">Master Page</a>
                    <?php
                //endif;
                //if ($publicador->getAccess() >= 2) :
                    ?>
                <a href="my_reports.php" class="btn-small blue darken-2">Meus Relatórios</a>
                <a href="view_territory.php" class="btn-small blue darken-2">Visualizar Territórios</a>
                <a href="contact_us.php" class="btn-small blue darken-2">Fale Conosco</a>
                    <?php
                //endif;
                    ?>
                <a href="faq.php" class="btn-small blue darken-2">F.A.Q.</a>
                <a href="phpaction/logout.php" class="btn-small red darken-2">Sair</a>
            </div>
        <?php
        //endif;
        ?>
    </header>
    <div class="content">
        <br><br>-->
