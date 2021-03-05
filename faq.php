<?php

session_start();

/** Página:
*     Home
* Conteúdo:
*     Dados do Usuário, opções de trocar email e senha.*/

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
                        <h1>F.A.Q.</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active">F.A.Q.</a></li>
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

<h5>Questões Frequentemente Perguntadas:</h5>

<ul>
    <p><li><b>Por que o site acessou direto sem pedir para fazer login?</b></li>
    <li>No último acesso você provavelmente não apertou em sair, então a sessão foi mantida aberta.</li></p>

    <p><li><b>No perfil meu grupo está como "à definir" ou está incorreto, como eu mudo isso?</b></li>
    <li>Só os superintendentes de grupo e seus ajudantes podem alterar esse campo, peça para um deles atualizar suas informações.</li></p>

    <p><li><b>Fiz um relatório, mas cometi um erro, o que eu faço?</b></li>
    <li>Vá na sessão Meus Relatórios e procure o relatório incorreto, lá você poderá deleta-lo ou corrigi-lo.</li></p>

    <p><li><b>Estou acessando o site pelo celular e os links do mapa não estão funcionando, como consertar?</b></li>
    <li>Ative rotação de tela, gire a tela e volte ao normal, isso atualizará a imagem e corrigirá o link.</li></p>

    <p><li><b>Enquanto estava usando o site tive uma ideia para melhora, como entre em contato com o desenvolvedor?</b></li>
    <li>Não faça contato via mensagem, use a sessão Fale Conosco que um e-mail com sua suguestão será enviado.</li></p>

    <p><li><b>Tive um problema ao usar o site e não consegui resolver, com quem entro em contato?</b></li>
    <li>Veja resposta da questão 5.</li></p>

    <p><li><b>Enviei uma solicitação pelo Fale Conosco, o que eu faço agora?</b></li>
    <li>Você receberá um email com o número do ticket de sua solicitação, se tiver algo mais a falar sobre a questão use o e-mail e informe o número do ticket.</li></p>

    <p><li><b>Não estou encontrando o e-mail enviado, o que aconteceu?</b></li>
    <li>Provavelmente o e-mail foi para a caixa de spam.</li></p>

    <p><li><b>Baixei uma planilha e tentei abrir direto pelo Outlook, mas deu erro, o que fazer?</b></li>
    <li>As planilhas são geradas automáticamente pelo sistema, para conseguir visualizar será necessário usar o Excel.</li></p>

    <p><li><b>Baixei uma planilha e tentei abrir pelo Excel, mas deu uma mensagem de arquivo corrompido ou não seguro, o que fazer?</b></li>
    <li>Essa mensagem surge por conta da forma como a planilha é gerada, essa mensagem de erro pode ser ignorada selecionando a opção de abrir mesmo assim.</li></p>
</ul>

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