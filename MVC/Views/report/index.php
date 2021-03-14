<?php

/** Página: Relatórios
*   Conteúdo: Apresenta todos os relatórios feitos pelo usuário (Se acessado por Master, apresenta todos os relatório de todos os usuários)
*/

use lib\Session;

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
                foreach ($this->pub as $nome) :
                    ?>
                    <option value="<?php echo $nome["id"];?>"><?php echo $nome["nome"] . " " . $nome["sobrenome"];?></option>
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

<?php
if ((Session::get("access") >= 8 and isset($_POST['btn-pub'])) or Session::get("access") < 8) :
    if (isset($ver)) :
        $pub = Session::get("id");
    else :
        $pub = $_POST['publicador'];
    endif;
    ?>

    <h2>Relatórios feitos:</h2>

    <!-- [0] => obj\Event Object
                (
                    [id:obj\Event:private] => 15
                    [idUser:obj\Event:private] => 1
                    [idMap:obj\Event:private] => 1
                    [time:obj\Event:private] => 14/03/2021 12:54:52
                    [eventType:obj\Event:private] => doRel
                    [data1:obj\Event:private] => trab
                    [desc1:obj\Event:private] => 1
                    [data2:obj\Event:private] => nRes
                    [desc2:obj\Event:private] => 
                    [data3:obj\Event:private] => nCom
                    [desc3:obj\Event:private] => 
                    [data4:obj\Event:private] => nEdi
                    [desc4:obj\Event:private] => 
                    [cobert:obj\Event:private] => 1
                ) -->

    <?php
    $cob = EventsDAO::getInstance()->cobertNow();
    for ($j = 1; $j <= $cob; $j++) :
        $count = EventsDAO::getInstance()->relCount($pub, $j);
        for ($i = 0; $i < $count; $i++) :
            $dados = EventsDAO::getInstance()->readRelatorio($pub, $i, $j);
            if ($dados === null) :
                continue;
            endif;
            $loc = MapsDAO::getInstance()->readLoc($dados->getIdMap());
            ?>
            <!-- Default box -->
            <div class="card collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Relatório da Quadra <?php echo $loc["quadra"];?> do Mapa <?php echo $loc["maps"];?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Colapsar"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    if ($dados->getData1() !== null) :
                        echo "Trabalhada: " . (($dados->getDesc1() === "1") ? "Sim<br>" : "Não<br>");
                    else :
                        echo "Trabalhada: Não informado<br>";
                    endif;
                    if ($dados->getData2() !== null) :
                        echo "Número de Residências: " . $dados->getDesc2() . "<br>";
                    else :
                        echo "Número de Residências: Não informado<br>";
                    endif;
                    if ($dados->getData3() !== null) :
                        echo "Número de Comércios: " . $dados->getDesc3() . "<br>";
                    else :
                        echo "Número de Comércios: Não informado<br>";
                    endif;
                    if ($dados->getData4() !== null) :
                        echo "Número de Edifícios: " . $dados->getDesc4() . "<br>";
                    else :
                        echo "Número de Edifícios: Não informado<br>";
                    endif;

                    if ($dados->getCobert() == EventsDAO::getInstance()->cobertNow()) :
                        ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-rel-<?php echo $i;?>">Corrigir</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-del-rel-<?php echo $i;?>">Deletar</button>
                        <?php
                    endif;
                    ?>
                </div>
                <!-- /.card-body -->
                <?php
                if ($dados->getCobert() == EventsDAO::getInstance()->cobertNow()) :
                    ?>
                    <div class="modal fade" id="modal-up-rel-<?php echo $i;?>">
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
                                    <form action="phpaction/update_maps.php" method="POST">
                                        <input type="hidden" name="id_map" value="<?php echo $dados->getIdMap();?>">
                                        
                                        <div class="input-group mb-3">
                                            <input id="n_res_<?php echo $i;?>" name="n_res_<?php echo $i;?>" type="number" class="form-control" placeholder="Número de Residências">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-home"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input id="n_com_<?php echo $i;?>" name="n_com_<?php echo $i;?>" type="number" class="form-control" placeholder="Número de Comércios">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-store"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input id="n_edi_<?php echo $i;?>" name="n_edi_<?php echo $i;?>" type="number" class="form-control" placeholder="Número de Edifícios">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-building"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="btn-up-rel-<?php echo $i;?>" class="btn btn-primary">Confirmar</button>
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
                    <div class="modal fade" id="modal-del-rel-<?php echo $i;?>">
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
                                    <form action="phpaction/update_maps.php" method="POST">
                                        <input type="hidden" name="id_map" value="<?php echo $dados->getIdMap();?>">
                                        <button type="submit" name="btn-del-rel-<?php echo $i;?>" class="btn btn-warning">Confirmar</button>
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
                endif;
                ?>
            </div>
            <!-- /.card -->
            <?php
        endfor;
    endfor;
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