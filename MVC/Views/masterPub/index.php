<?php

/** Página:
*     Master - Reports (relatórios)
*   Conteúdo:
*     Apresenta todos os usuários cadastrados, histórico de alterações nos cadastros, histórico de relatórios emitidos e a opção de emitir a S-13. Nível de visibilidade da página será definido pelo nível de acesso do usuário*/

use lib\Session;

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de Publicadores:</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Sobrenome</th>
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th>Grupo</th>
                            <th>Acesso</th>
                            <th>Definir Grupo</th>
                            <th>Definir Acesso</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($this->publicadores as $dadosPub) :
                        ?>
                        <tr>
                            <td><?php echo $dadosPub->getNome();?></td>
                            <td><?php echo $dadosPub->getSobrenome();?></td>
                            <td><?php echo $dadosPub->getUsuario();?></td>
                            <td><?php echo $dadosPub->getEmail();?></td>
                            <td><?php echo $dadosPub->getGrupo();?></td>
                            <td><?php echo $dadosPub->getAccess();?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-gru-<?php echo $dadosPub->getId();?>">Definir</button>
                            </td>
                            <td>
                                <?php if (Session::get('id') != $dadosPub->getId()) :?> 
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-acc-<?php echo $dadosPub->getId();?>">Definir</button>
                                <?php endif;?>
                            </td>
                        </tr>

                        <!-- modal -->
                        <div class="modal fade" id="modal-up-gru-<?php echo $dadosPub->getId();?>" style="height: 400px;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Grupo</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Selecione o Grupo ao qual o publicador pertence</p>
                                        <form action="masterPub/updatePubGrupo" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $dadosPub->getId();?>">
                                            <!-- radio -->
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="group" id="group1-<?php echo $dadosPub->getId();?>" value="Porto Novo 1">
                                                    <label for="group1-<?php echo $dadosPub->getId();?>" class="custom-control-label">Porto Novo 1</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="group" id="group2-<?php echo $dadosPub->getId();?>" value="Porto Novo 2">
                                                    <label for="group2-<?php echo $dadosPub->getId();?>" class="custom-control-label">Porto Novo 2</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="group" id="group3-<?php echo $dadosPub->getId();?>" value="Presidente Médici">
                                                    <label for="group3-<?php echo $dadosPub->getId();?>" class="custom-control-label">Presidente Médici</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="group" id="group4-<?php echo $dadosPub->getId();?>" value="Morro do Sesi">
                                                    <label for="group4-<?php echo $dadosPub->getId();?>" class="custom-control-label">Morro do Sesi</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="group" id="group5-<?php echo $dadosPub->getId();?>" value="Del Porto">
                                                    <label for="group5-<?php echo $dadosPub->getId();?>" class="custom-control-label">Del Porto</label>
                                                </div>
                                            </div>
                                            <button type="submit" name="btn-up-gru" class="btn btn-primary">Confirmar</button>
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
                        <div class="modal fade" id="modal-up-acc-<?php echo $dadosPub->getId();?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Nível de Acesso</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Defina o nível de acesso do publicador</p>
                                        <form action="masterPub/updatePubAccess" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $dadosPub->getId();?>">
                                            <!-- radio -->
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc" id="acc1-<?php echo $dadosPub->getId();?>" value="-1">
                                                    <label for="acc1-<?php echo $dadosPub->getId();?>" class="custom-control-label">Desassociado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc" id="acc2-<?php echo $dadosPub->getId();?>" value="1">
                                                    <label for="acc2-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 1</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc" id="acc3-<?php echo $dadosPub->getId();?>" value="2">
                                                    <label for="acc3-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 2</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc" id="acc4-<?php echo $dadosPub->getId();?>" value="3">
                                                    <label for="acc4-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 3</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc" id="acc5-<?php echo $dadosPub->getId();?>" value="4">
                                                    <label for="acc5-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 4</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc" id="acc6-<?php echo $dadosPub->getId();?>" value="5">
                                                    <label for="acc6-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 5</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc" id="acc7-<?php echo $dadosPub->getId();?>" value="6">
                                                    <label for="acc7-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 6</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc" id="acc8-<?php echo $dadosPub->getId();?>" value="7">
                                                    <label for="acc8-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 7</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc" id="acc9-<?php echo $dadosPub->getId();?>" value="8">
                                                    <label for="acc9-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 8</label>
                                                </div>
                                                <?php if (Session::get('access') == 10) :?> 
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" name="acc" id="acc10-<?php echo $dadosPub->getId();?>" value="9">
                                                        <label for="acc10-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 9</label>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <button type="submit" name="btn-up-acc" class="btn btn-primary">Confirmar</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <?php
                    endforeach;
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nome</th>
                            <th>Sobrenome</th>
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th>Grupo</th>
                            <th>Acesso</th>
                            <th>Definir Grupo</th>
                            <th>Definir Acesso</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>