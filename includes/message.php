<?php

if (isset($_SESSION['mensagem'])) :
    ?>

<script>
    // Mensagem
    window.onload = function() 
    {
        toastr['<?php echo $_SESSION['tipo']; ?>']('<?php echo $_SESSION['mensagem']; ?>')
    };
</script>

    <?php
endif;

$_SESSION['mensagem'] = [];
?>
