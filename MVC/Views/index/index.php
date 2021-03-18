<?php

/** Página: Inicial
*   Conteúdo: Área de LogIn, opções de Criar Conta e Problemas de LogIn.
*/

?>
<div class="login-box">
    <div class="login-logo">
        <img id="logo" src=<?php echo URL . "_img/logo/logo_oasis_assistant.png";?> alt="Logo Oásis Assistant">
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Login</p>

            <form action="index/loginRun" method="POST">
                <div class="input-group mb-3">
                    <input id="usuario" name="usuario" type="text" class="form-control" placeholder="Usuário">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="senha" name="senha" type="password" class="form-control" placeholder="Senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" name="btn-entrar" class="btn btn-primary btn-block">Entrar</button>
            </form>
            <p class="mb-1">
                <a href=<?php echo URL . "problem";?>>Problemas com Login?</a>
            </p>
            <p class="mb-0">
                <a href=<?php echo URL . "signup";?> class="text-center">Criar conta</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->
