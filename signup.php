<!--
    Página: Criar Conta
    Conteúdo: Todos os mapas e sessão de relatório de serviço

    Exibição inicial tem o mapa do território todo da congregação (Mapa_Completo), com link para exibir o território de cada grupo (Mapa_Regio), nesse tem outro link para cada território individual (Mapa_Local). 

    A sessão de relatório de serviço só é exibida quando um Mapa_Local está em foco. Essa sessão está dentro de um iframe e exibe as informações atuais no sistema sobre cada quadra (se a quadra já foi trabalhada, número de residencias, número de comércios e número de edifícios). Nessa sessão também é possivel emitir um relatório de serviço e preencher ou atualizar as informações da quadra.
    
    Ao emitir o relatório o usuário tem até 24h para realizar qualquer correção na página de relatórios, após isso só o administrador do sistema poderá fazer alterações.
-->

<?php

//Sessão
session_start();

// Header
require_once 'includes/header.php';
// Message
require_once 'includes/message.php';
?>

<div class="row">
    <form class="col s12 push-s2 m8 push-m2" action="phpaction/create_dir.php" method="POST">
        <div class="row">
            <div class="input-field col s4">
                <input id="nome" name="nome" type="text" class="validate">
                <label for="nome">Nome</label>
            </div>
            <div class="input-field col s4">
                <input id="sobrenome" name="sobrenome" type="text" class="validate">
                <label for="sobrenome">Sobrenome</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s8">
                <input id="email" name="email" type="email" class="validate">
                <label for="email">Email</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s8">
                <input id="user" name="user" type="text" class="validate">
                <label for="user">Usuário</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s8">
                <input id="senha" name="senha" type="password" class="validate">
                <label for="senha">Senha</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s8">
                <input id="repeat-senha" name="repeat-senha" type="password" class="validate">
                <label for="repeat-senha">Confirmar Senha</label>
            </div>
        </div>
        
        <button type="submit" name="btn-confirm" class="btn blue darken-2">Criar Conta</button>
        <a href="index.php" class="btn red darken-2">Cancelar</a>
    </form>
</div>
        
<?php
// Footer
require_once 'includes/footer.php';
?>
