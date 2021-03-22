<?php

/** Página: Master - Requests (Solicitações)
*   Conteúdo: Apresenta todos as solicitações em aberto. Nível de visibilidade da página será definido pelo nível de acesso do usuário
*/

if (!$this->problem) :
    echo "<p>Nenhuma solicitação em aberto com assunto Problema.</p>";
endif;
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Problemas encontrados</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table id="table1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>E-mail</th>
                    <th>Solicitação</th>
                    <th>Data</th>
                    <th>Ticket</th>
                    <th>Status</th>
                    <th>Definir Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->problem as $dadosProblem) :
                    $key = array_search($dadosProblem->getIdUser(), array_column($this->publishers, 'id'));
                    ?>
                    <tr>
                        <td><?php echo $this->publishers[$key]['nome'];?></td>
                        <td><?php echo $this->publishers[$key]['sobrenome'];?></td>
                        <td><?php echo $this->publishers[$key]['email'];?></td>
                        <td><?php echo $dadosProblem->getMensag();?></td>
                        <td><?php echo $dadosProblem->getTimeN();?></td>
                        <td><?php echo $dadosProblem->getTicket();?></td>
                        <td><?php echo $dadosProblem->getStatusN();?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-sol-pro-<?php echo $dadosProblem->getId();?>">Definir</button>
                        </td>
                    </tr>

                    <!-- modal -->
                    <div class="modal fade" id="modal-up-sol-pro-<?php echo $dadosProblem->getId();?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Status</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Defina o status da solicitação</p>
                                    <form action="MasterReq/updateReq" method="POST">
                                        <input type="hidden" name="id" value=<?php echo $dadosProblem->getId();?>>
                                        <!-- radio -->
                                        <div class="form-group">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="sol" id="sol-pro1-<?php echo $dadosProblem->getId();?>" value="em Espera">
                                                <label for="sol-pro1-<?php echo $dadosProblem->getId();?>" class="custom-control-label">em Espera</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="sol" id="sol-pro2-<?php echo $dadosProblem->getId();?>" value="em Analise">
                                                <label for="sol-pro2-<?php echo $dadosProblem->getId();?>" class="custom-control-label">em Analise</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="sol" id="sol-pro3-<?php echo $dadosProblem->getId();?>" value="Concluido">
                                                <label for="sol-pro3-<?php echo $dadosProblem->getId();?>" class="custom-control-label">Concluido</label>
                                            </div>
                                        </div>
                                        <button type="submit" name="btn-up-sol-pro" class="btn btn-primary">Confirmar</button>
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
                    <th>E-mail</th>
                    <th>Solicitação</th>
                    <th>Data</th>
                    <th>Ticket</th>
                    <th>Status</th>
                    <th>Definir Status</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<?php
if (!$this->sugest) :
    echo "<p>Nenhuma solicitação em aberto com assunto Sugestão.</p>";
endif;
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sugestões feitas</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table id="table2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>E-mail</th>
                    <th>Solicitação</th>
                    <th>Data</th>
                    <th>Ticket</th>
                    <th>Status</th>
                    <th>Definir Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->sugest as $dadosSugest) :
                    $key = array_search($dadosSugest->getIdUser(), array_column($this->publishers, 'id'));
                    ?>
                    <tr>
                        <td><?php echo $this->publishers[$key]['nome'];?></td>
                        <td><?php echo $this->publishers[$key]['sobrenome'];?></td>
                        <td><?php echo $this->publishers[$key]['email'];?></td>
                        <td><?php echo $dadosSugest->getMensag();?></td>
                        <td><?php echo $dadosSugest->getTimeN();?></td>
                        <td><?php echo $dadosSugest->getTicket();?></td>
                        <td><?php echo $dadosSugest->getStatusN();?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-sol-sug-<?php echo $dadosSugest->getId();?>">Definir</button>
                        </td>
                    </tr>

                    <!-- modal -->
                    <div class="modal fade" id="modal-up-sol-sug-<?php echo $dadosSugest->getId();?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Status</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Defina o status da solicitação</p>
                                    <form action="MasterReq/updateReq" method="POST">
                                        <input type="hidden" name="id" value=<?php echo $dadosSugest->getId();?>>
                                        <!-- radio -->
                                        <div class="form-group">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="sol" id="sol-sug1-<?php echo $dadosSugest->getId();?>" value="em Espera">
                                                <label for="sol-sug1-<?php echo $dadosSugest->getId();?>" class="custom-control-label">em Espera</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="sol" id="sol-sug2-<?php echo $dadosSugest->getId();?>" value="em Analise">
                                                <label for="sol-sug2-<?php echo $dadosSugest->getId();?>" class="custom-control-label">em Analise</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="sol" id="sol-sug3-<?php echo $dadosSugest->getId();?>" value="Concluido">
                                                <label for="sol-sug3-<?php echo $dadosSugest->getId();?>" class="custom-control-label">Concluido</label>
                                            </div>
                                        </div>
                                        <button type="submit" name="btn-up-sol-sug"  class="btn btn-primary">Confirmar</button>
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
                    <th>E-mail</th>
                    <th>Solicitação</th>
                    <th>Data</th>
                    <th>Ticket</th>
                    <th>Status</th>
                    <th>Definir Status</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<?php
if (!$this->other) :
    echo "<p>Nenhuma solicitação em aberto com assunto Outro.</p>";
endif;
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Outros</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table id="table3" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>E-mail</th>
                    <th>Solicitação</th>
                    <th>Data</th>
                    <th>Ticket</th>
                    <th>Status</th>
                    <th>Definir Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->other as $dadosOther) :
                    $key = array_search($dadosOther->getIdUser(), array_column($this->publishers, 'id'));
                    ?>
                    <tr>
                        <td><?php echo $this->publishers[$key]['nome'];?></td>
                        <td><?php echo $this->publishers[$key]['sobrenome'];?></td>
                        <td><?php echo $this->publishers[$key]['email'];?></td>
                        <td><?php echo $dadosOther->getMensag();?></td>
                        <td><?php echo $dadosOther->getTimeN();?></td>
                        <td><?php echo $dadosOther->getTicket();?></td>
                        <td><?php echo $dadosOther->getStatusN();?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-sol-out-<?php echo $dadosOther->getId();?>">Definir</button>
                        </td>
                    </tr>

                    <!-- modal -->
                    <div class="modal fade" id="modal-up-sol-out-<?php echo $dadosOther->getId();?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Status</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Defina o status da solicitação</p>
                                    <form action="MasterReq/updateReq" method="POST">
                                        <input type="hidden" name="id" value=<?php echo $dadosOther->getId();?>>
                                        <!-- radio -->
                                        <div class="form-group">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="sol" id="sol-out1-<?php echo $dadosOther->getId();?>" value="em Espera">
                                                <label for="sol-out1-<?php echo $dadosOther->getId();?>" class="custom-control-label">em Espera</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="sol" id="sol-out2-<?php echo $dadosOther->getId();?>" value="em Analise">
                                                <label for="sol-out2-<?php echo $dadosOther->getId();?>" class="custom-control-label">em Analise</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="sol" id="sol-out3-<?php echo $dadosOther->getId();?>" value="Concluido">
                                                <label for="sol-out3-<?php echo $dadosOther->getId();?>" class="custom-control-label">Concluido</label>
                                            </div>
                                        </div>
                                        <button type="submit" name="btn-up-sol-out"  class="btn btn-primary">Confirmar</button>
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
                    <th>E-mail</th>
                    <th>Solicitação</th>
                    <th>Data</th>
                    <th>Ticket</th>
                    <th>Status</th>
                    <th>Definir Status</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->