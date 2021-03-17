<?php

/** Página: Relatórios
*   Conteúdo: Apresenta todos os relatórios feitos pelo usuário (Se acessado por Master, apresenta todos os relatório de todos os usuários)
*/

use lib\Session;

//Se acesso for maior que 8, exibe opção de emitir S13 e de escolher de qual publicador verá os relatórios
if (Session::get("access") >= 8) :
    ?>
    <h5>Emitir S-13:</h5>
    <a target="_blank" href="report/doS13" class="btn btn-primary">S-13</a>
    <br><br>
    <form action="#" method="POST">
        <!-- select -->
        <div class="form-group">
            <label>Ver relatórios de:</label>
            <select id="publicador" name="publicador" class="form-control">
                <option value="" disabled selected>Selecione uma opção</option>
                <?php
                foreach ($this->pub as $publisher) :
                    ?>
                    <option value="<?php echo $publisher["id"];?>"><?php echo $publisher["nome"] . " " . $publisher["sobrenome"];?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>
        <button type="submit" name="btn-pub" class="btn btn-primary">Próximo</button>
    </form>
    <?php
else :
    $ver = 0;
endif;
?>

<br>
<h2>Relatórios feitos:</h2>
<p>OBS: Quando se completa o território, todos os relatórios até então são arquivados e, portanto, não aparecerão nesta página.</p>

<?php
if ((Session::get("access") >= 8 and isset($_POST['btn-pub'])) or Session::get("access") < 8) :
    if (isset($ver)) :
        $publisher = Session::get("id");
    else :
        $publisher = $_POST['publicador'];
    endif;

    if (!isset($this->report[$publisher])) :
        echo "<br>Publicador não emitiu nenhum relatório";
        die;
    endif;

    foreach ($this->report[$publisher] as $singleReport) :
        ?>
        <!-- Default box -->
        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Relatório da Quadra <?php echo $singleReport[1]["quadra"];?> do Mapa <?php echo $singleReport[1]["maps"];?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Colapsar"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <?php
                echo "Número de Residências: " . (($singleReport[0]->getDesc2() != "") ? $singleReport[0]->getDesc2() : "Não informado") . "<br>";
                echo "Número de Comércios: " . (($singleReport[0]->getDesc3() != "") ? $singleReport[0]->getDesc3() : "Não informado") . "<br>";
                echo "Número de Edifícios: " . (($singleReport[0]->getDesc4() != "") ? $singleReport[0]->getDesc4() : "Não informado") . "<br>";
                ?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-rel-<?php echo $singleReport[0]->getId();?>">Corrigir</button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-del-rel-<?php echo $singleReport[0]->getId();?>">Deletar</button>
            </div>
            <!-- /.card-body -->
            <div class="modal fade" id="modal-up-rel-<?php echo $singleReport[0]->getId();?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Corrigir Relatório</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Preencha os campos abaixo para alterar o relatório</p>
                            <form action="report/updateRep" method="POST">
                                <input type="hidden" name="id_map" value="<?php echo $singleReport[0]->getIdMap();?>">
                                
                                <div class="input-group mb-3">
                                    <input id="n_res_<?php echo $singleReport[0]->getId();?>" name="n_res_<?php echo $singleReport[0]->getId();?>" type="number" class="form-control" placeholder="Número de Residências">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input id="n_com_<?php echo $singleReport[0]->getId();?>" name="n_com_<?php echo $singleReport[0]->getId();?>" type="number" class="form-control" placeholder="Número de Comércios">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-store"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input id="n_edi_<?php echo $singleReport[0]->getId();?>" name="n_edi_<?php echo $singleReport[0]->getId();?>" type="number" class="form-control" placeholder="Número de Edifícios">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-building"></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="btn-up-rel-<?php echo $singleReport[0]->getId();?>" class="btn btn-primary">Confirmar</button>
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
            <div class="modal fade" id="modal-del-rel-<?php echo $singleReport[0]->getId();?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Deletar Relatório</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h5>Tem certeza que deseja deletar esse relatório?</h5>
                            <p>Todas as informações fornecidas serão deletadas!</p>
                            <form action="report/deleteRep" method="POST">
                                <input type="hidden" name="id_map" value="<?php echo $singleReport[0]->getIdMap();?>">
                                <button type="submit" name="btn-del-rel-<?php echo $singleReport[0]->getId();?>" class="btn btn-warning">Confirmar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
        <!-- /.card -->
        <?php
    endforeach;
endif;
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.collapsible').collapsible({accordion: false});
    })

    $(document).ready(function(){
        $('select').formSelect();
    });
</script>