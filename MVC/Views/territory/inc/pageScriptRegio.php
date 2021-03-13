<script type = "text/javascript" src=<?php echo URL . "_public/_JS/imageMapResizer.min.js";?>></script>

<script>
    imageMapResize();
</script>
<script>
window.onload = function(){
    var param = "<?php print $this->regio;?>";
    document.getElementById(param).setAttribute("class", "");
};
</script>