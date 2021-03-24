<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/all.min.css";?>>
    <!-- Theme style -->
    <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/adminlte.min.css";?>>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/toastr.min.css";?>>

    <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/style.css";?>>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<!-- ABERTURA DAS ESTRUTURAS DE CONTEUDO-->
<!-- Site wrapper -->
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
<!-- /.ABERTURA DAS ESTRUTURAS DE CONTEUDO-->

<h2>Relatórios feitos:</h2>
<p>OBS: Quando se completa o território, todos os relatórios até então são arquivados e, portanto, não aparecerão nesta página.</p>
<?php
if ($this->report == false) :
    echo "<br>Publicador não emitiu nenhum relatório";
    die;
endif;

foreach ($this->report as $singleReport) :
    if ($singleReport[0] == "Relatório deletado") :
        ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Relatório da Quadra <?php echo $singleReport[1]["quadra"];?> do Mapa <?php echo $singleReport[1]["maps"];?> DELETADO</h3>
            </div>
        </div>
        <?php
        continue;
    endif;
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
                        <form action=<?php echo URL . "Report/updateReport";?> method="POST">
                            <input type="hidden" name="id_map" value="<?php echo $singleReport[0]->getIdMap();?>">
                            <input type="hidden" name="pg" value="<?php echo $this->pg?>">
                            
                            <div class="input-group mb-3">
                                <input id="n_res_<?php echo $singleReport[0]->getId();?>" name="n_res" type="number" class="form-control" placeholder="Número de Residências">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-home"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input id="n_com_<?php echo $singleReport[0]->getId();?>" name="n_com" type="number" class="form-control" placeholder="Número de Comércios">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-store"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input id="n_edi_<?php echo $singleReport[0]->getId();?>" name="n_edi" type="number" class="form-control" placeholder="Número de Edifícios">
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
                        <form action=<?php echo URL . "Report/deleteReport";?> method="POST">
                            <input type="hidden" name="id_map" value="<?php echo $singleReport[0]->getIdMap();?>">
                            <input type="hidden" name="pg" value="<?php echo $this->pg?>">
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

//Paginação
$nPg = ceil($this->count / 15);
if ($nPg != 1) :
    echo "<div class='pag'>";
    if ($this->pg != 1) :
        echo "<a href=" . URL . "Report/frame/" . $this->read . "/" . ($this->pg - 1) . ">&laquo;</a>";
    endif;
    for ($i = 1; $i <= $nPg; $i++) :
        if ($this->pg == $i) :
            echo "<a href=" . URL . "Report/frame/" . $this->read . "/" . $i . " class='active'>$i</a>";
        else :
            echo "<a href=" . URL . "Report/frame/" . $this->read . "/" . $i . ">$i</a>";
        endif;
    endfor;
    if ($this->pg != $nPg) :
        echo "<a href=" . URL . "Report/frame/" . $this->read . "/" . ($this->pg + 1) . ">&raquo;</a>";
    endif;
    echo "</div>";
endif;
?>
<!-- FECHAMENTO DAS ESTRUTURAS DE CONTEUDO-->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.Main content -->
    </div>
</div>
<!-- /.Site wrapper -->
<!-- /.FECHAMENTO DAS ESTRUTURAS DE CONTEUDO-->

<!-- jQuery -->
<script src=<?php echo URL . "_public/_JS/jquery.min.js";?>></script>
<!-- Bootstrap 4 -->
<script src=<?php echo URL . "_public/_JS/bootstrap.bundle.min.js";?>></script>
<!-- AdminLTE App -->
<script src=<?php echo URL . "_public/_JS/adminlte.min.js";?>></script>
<!-- overlayScrollbars -->
<script src=<?php echo URL . "_public/_JS/jquery.overlayScrollbars.min.js";?>></script>
<!-- Toastr -->
<script src=<?php echo URL . "_public/_JS/toastr.min.js";?>></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.collapsible').collapsible({accordion: false});
    })
</script>

<script>
    M.AutoInit();
</script>
</body>
</html>