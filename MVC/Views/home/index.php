<?php

if ($this->publicador->getAccess() == 1) :
    echo "<p>Sua conta aguarda análise dos administradores, após a análise sua conta terá o acesso às funcionalidades liberado.</p>";
endif;

echo "<b>Nome: </b>" . $this->publicador->getNome() . "<br>";
echo "<b>Sobrenome: </b>" . $this->publicador->getSobrenome() . "<br>";
echo "<b>E-mail: </b>" . $this->publicador->getEmail() . "<br>";
echo "<b>Grupo: </b>" . (($this->publicador->getGrupo() == null) ? "à definir" : $this->publicador->getGrupo()) . "<br>";
echo "<b>Usuário: </b>" . $this->publicador->getUsuario() . "<br><br>";
?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-email">
    Alterar E-mail
</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-senha">
    Alterar Senha
</button>

<!-- modal -->
<div class="modal fade" id="modal-email">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar E-mail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Preencha os campos abaixo para alterar seu e-mail</p>
                <form action="Home/updatePublisherEmail" method="POST">
                    <input type="hidden" name="id" value="<?php echo $this->publicador->getId();?>">
                    
                    <div class="input-group mb-3">
                        <input id="email-up" name="email-up" type="email" class="form-control" placeholder="Novo Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="btn-up-email" class="btn btn-primary">Confirmar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- modal -->
<div class="modal fade" id="modal-senha">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar Senha</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Preencha os campos abaixo para alterar sua senha</p>
                <form action="Home/updatePublisherPassword" method="POST">
                    <input type="hidden" name="id" value="<?php echo $this->publicador->getId();?>">

                    <div class="input-group mb-3">
                        <input id="senha-old" name="senha-old" type="password" class="form-control" placeholder="Senha Antiga">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input id="senha-new" name="senha-new" type="password" class="form-control" placeholder="Nova Senha">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input id="senha-new-conf" name="senha-new-conf" type="password" class="form-control" placeholder="Confirmar Nova Senha">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="btn-up-senha" class="btn btn-primary">Confirmar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->