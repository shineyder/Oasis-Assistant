<?php

use lib\Session;

Session::init();

if (Session::get('message') !== null and  Session::get('message') != []) :
    ?>
    <script>
        // Mensagem
        window.onload = function() 
        {
            toastr['<?php echo Session::get('tipo');?>']('<?php echo Session::get('message');?>')
        };
    </script>
    <?php
endif;

Session::set('tipo', []);
Session::set('message', []);
?>
