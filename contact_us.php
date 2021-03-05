<?php

session_start();

/** Página:
*     Fale Conosco
*   Conteúdo:
*     Sessão para o usuário enviar sugestões ou relatar problemas.*/

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

//Verificação
if (!isset($_SESSION['logado'])) :
    redirect('http://oasisassistant.com/');
    exit();
endif;

//Dados
$publicador = unserialize($_SESSION['obj']);

// Header
require_once 'includes/header.php';
// Message
require_once 'includes/message.php';
?>

<!-- ABERTURA DAS ESTRUTURAS DE CONTEUDO-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Fale Conosco</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active">Fale Conosco</a></li>
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

<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>

<p>Envie sugestões ou relate problemas</p>

<div class="row">
    <form class="col s10 push-s1 m8 push-m2" action="phpaction/talk.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" type="text" value=<?php echo $publicador->getId()?>>
        <input type="hidden" id="nome" name="nome" type="text" value=<?php echo $publicador->getNome()?>>
        <input type="hidden" id="sobrenome" name="sobrenome" type="text" value=<?php echo $publicador->getSobrenome()?>>
        <input type="hidden" id="email" name="email" type="email" value=<?php echo $publicador->getEmail()?>>
        <span>Selecione o motivo do contato:</span>
        <p><label>
            <input name="assunto" type="radio" value="Problema" checked />
            <span>Relatar um problema</span>
        </label></p>
        <p><label>
            <input name="assunto" type="radio" value="Sugestão"/>
            <span>Fazer uma sugestão</span>
        </label></p>
        <p><label>
            <input name="assunto" type="radio" value="Outro"/>
            <span>Outro</span>
        </label></p>

        <textarea id="mensag" name="mensag"></textarea>
        <label for="mensag">Mensagem</label>

        <div class="btn-file">
            <br><span>Arquivo limitado a 1Mb (.png ou .jpeg)</span>
            <input type="file" id="fileToUploadTalk" name="fileToUploadTalk" accept="image/png, image/jpeg">
            <br><label for="fileToUploadTalk">Imagem (opcional)</label>
        </div>
        <br>
        <button type="submit" name="btn-talk" class="btn blue darken-2">Enviar</button>
        <a href="home.php" class="btn red darken-2">Cancelar</a>
    </form>
</div>

<!-- FECHAMENTO DAS ESTRUTURAS DE CONTEUDO-->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<!-- /.FECHAMENTO DAS ESTRUTURAS DE CONTEUDO-->

<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
