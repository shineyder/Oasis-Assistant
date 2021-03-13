<script type = "text/javascript" src=<?php echo URL . "_public/_JS/imageMapResizer.min.js";?>></script>

<script>
    imageMapResize();
</script>
<script>
window.onload = function(){
    var param = "<?php print $this->loc;?>";
    document.getElementById(param).setAttribute("class", "");
    document.getElementById("Mapa_Local").setAttribute("src", <?php echo URL;?> + "_img/maps/" . param + ".jpg");
};
</script>