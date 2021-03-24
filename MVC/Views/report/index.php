<?php

use lib\Session;

//Se acesso for maior que 8, exibe opção de emitir S13 e de escolher de qual publicador verá os relatórios
if (Session::get("access") >= 8) :
    ?>
    <h5>Emitir S-13:</h5>
    <a target="_blank" href="Report/doS13" class="btn btn-primary">S-13</a>
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
    $read = Session::get("id");
endif;

if (isset($read)) :
    echo "<iframe scrolling='no' src=" . URL . "Report/frame/" . $read . " name='report' id='frame-rep'></iframe>";
endif;

if (isset($_POST['btn-pub'])) :
    $read = $_POST['publicador'];
    echo "<iframe scrolling='no' src=" . URL . "Report/frame/" . $read . " name='report' id='frame-rep'></iframe>";
endif;
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>
