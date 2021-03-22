<img class="map" id="Mapa_Local" src=<?php echo URL . "_img/maps/" . $this->loc . ".jpg";?> alt="Mapa Local">

<a href=<?php echo URL . "Territory/showRegio/" . $this->regio;?> class="btn btn-danger btn-block">Voltar</a>

<iframe scrolling="no" src=<?php echo URL . "Territory/frame/" . $this->loc;?> id="frame-rel"></iframe>