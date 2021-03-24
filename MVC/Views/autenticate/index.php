<?php

if ($this->verify == 1) :
    ?>
    <div class="center">
        <h4>Autenticação concluida com sucesso!</h4>
        <p>Seu email foi autenticado e seu acesso ao Oasis Assistant foi liberado.</p>
        <a href=<?php echo URL;?> class="btn btn-success btn-block">Fazer LogIn</a>
    </div>
    <?php
else :
    ?>
    <div class="center">
        <h4>Houve algum erro com a autenticação!</h4>
        <p>Link de verificação utilizado inválido.</p>
        
        <a href=<?php echo URL;?> class="btn btn-danger btn-block">Página Inicial</a>
    </div>
    <?php
endif;
