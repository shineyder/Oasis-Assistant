<img class="map" id="Mapa_Local" src=<?php echo URL . "_img/maps/" . $this->loc . ".jpg";?> alt="Mapa Local">

<a href=<?php echo URL . "mapaRegio/" . $this->regio;?> class="btn btn-danger btn-block">Voltar</a>

<!-- Content Wrapper. Contains page content -->
<div id="div-rel" class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
    <div class="tab-content">
        <iframe scrolling="no" src=<?php echo URL . "territory/frame/" . $this->loc;?> name="rel" id="frame-rel"></iframe>
    </div>
</div>