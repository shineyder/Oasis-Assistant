<?php

/** Página:
*     Criar Conta
*   Conteúdo:
*     Formulário para criar conta no sistema*/

?>

<div class="register-box">
    <div class="register-logo">
        <img id="logo" src=<?php echo URL . "_img/logo/logo_oasis_assistant.png";?> alt="Logo Oásis Assistant">
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Cadastrar novo Usuário</p>

            <form action="signup/registerPub" method="POST">
                <div class="row">
                    <div class="col-5">
                        <div class="input-group mb-3">
                            <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-7">
                        <div class="input-group mb-3">
                            <input id="sobrenome" name="sobrenome" type="text" class="form-control" placeholder="Sobrenome">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /.col -->
                </div>
                <div class="input-group mb-3">
                    <input id="email" name="email" type="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="usuario" name="usuario" type="text" class="form-control" placeholder="Usuário">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
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
                <div class="input-group mb-3">
                    <input id="repeat-senha" name="repeat-senha" type="password" class="form-control" placeholder="Confirmar Senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="submit" name="btn-confirm" class="btn btn-primary btn-block">Criar Conta</button>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <a href="index" class="btn btn-danger btn-block">Cancelar</a>
                    </div>
                <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->