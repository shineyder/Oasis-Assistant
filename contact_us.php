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

<div class="card">
    <div class="card-body"> <!--ADAPTADO-->
        <form action="phpaction/talk.php" method="POST" enctype="multipart/form-data" role="form">
            <p>Selecione o motivo do contato:</p>
            <input type="hidden" id="id" name="id" type="text" value=<?php echo $publicador->getId()?>>
            <input type="hidden" id="nome" name="nome" type="text" value=<?php echo $publicador->getNome()?>>
            <input type="hidden" id="sobrenome" name="sobrenome" type="text" value=<?php echo $publicador->getSobrenome()?>>
            <input type="hidden" id="email" name="email" type="email" value=<?php echo $publicador->getEmail()?>>
            <!-- radio -->
            <div class="form-group">
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="assunto" id="assunto1" value="Problema">
                    <label for="assunto1" class="custom-control-label">Relatar um problema</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="assunto" id="assunto2" value="Sugestão">
                    <label for="assunto2" class="custom-control-label">Fazer uma sugestão</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="assunto" id="assunto3" value="Outro">
                    <label for="assunto3" class="custom-control-label">Outro</label>
                </div>
            </div>
            <div class="form-group">
                <label>Mensagem:</label>
                <textarea id="mensag" name="mensag" class="form-control" rows="4" placeholder="Digite ..."></textarea>
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" id="fileToUploadTalk" name="fileToUploadTalk" accept="image/png, image/jpeg" class="custom-file-input">
                    <label class="custom-file-label" for="fileToUploadTalk">Imagem (opcional)</label>
                    <span>Arquivo limitado a 1Mb (.png ou .jpeg)</span>
                </div>
            </div>
            <br>
            <button type="submit" name="btn-talk" class="btn btn-primary btn-block">Enviar</button>
        </form>
        
    </div>
    <!-- /.form-box -->
    <a href="home.php" class="btn btn-danger btn-block">Cancelar</a>
</div><!-- /.card -->

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
