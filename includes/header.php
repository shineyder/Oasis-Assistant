<!--
Página:
    Cabeçalho
Conteúdo:
    Abertura das tags, inclusão de todas as bibliotecas utilizadas, logo e menu de navegação.
-->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title> Oasis Assistant</title>
        <link rel="stylesheet" href="_css/style.css"/>
        <link rel="shortcut icon" href="img/logo_oasis_assistant_min.ico">

        <!-- Compiled and minified CSS and Import Google Icon Font -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
        <!-- Compiled and minified JavaScript -->
        <script type = "text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
        <script type = "text/javascript" src="_JS/imageMapResizer.min.js"></script>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
        <header class="cabecalho row">
            <div class="center">
                <img id="logo" src="../img/logo_oasis_assistant.png" alt="Logo Oásis Assistant">
            </div>
            
            <?php
            if (isset($_SESSION['logado'])) :
                ?>  
            
                <div class="cabecalho-inf col s12 center">
                    <a href="home.php" class="btn-small blue darken-2">Ver Perfil</a>

                    <?php
                    if ($dados['access'] >= 6) :
                        ?>

                    <a href="master_page.php" class="btn-small blue darken-2">Master Page</a>

                        <?php
                    endif;
                    ?>
                    
                    <a href="my_relatorios.php" class="btn-small blue darken-2">Meus Relatórios</a>
                    <a href="vis_territorio.php" class="btn-small blue darken-2">Visualizar Territórios</a>
                    <a href="phpaction/logout.php" class="btn-small red darken-2">Sair</a>
                </div>

                <?php
            endif;
            ?>
        </header>

        <div class="content">
