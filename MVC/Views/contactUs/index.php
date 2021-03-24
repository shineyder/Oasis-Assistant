<div class="card">
    <div class="card-body"> <!--ADAPTADO-->
        <form action="ContactUs/sendTalk" method="POST" enctype="multipart/form-data" role="form">
            <p>Selecione o motivo do contato:</p>
            <input type="hidden" id="id" name="id" type="text" value=<?php echo $this->publicador->getId()?>>
            <input type="hidden" id="nome" name="nome" type="text" value=<?php echo $this->publicador->getNome()?>>
            <input type="hidden" id="sobrenome" name="sobrenome" type="text" value=<?php echo $this->publicador->getSobrenome()?>>
            <input type="hidden" id="email" name="email" type="email" value=<?php echo $this->publicador->getEmail()?>>
            <!-- radio -->
            <div class="form-group">
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="assunto" id="assunto1" value="Problema">
                    <label for="assunto1" class="custom-control-label">Relatar um problema</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="assunto" id="assunto2" value="Sugestao">
                    <label for="assunto2" class="custom-control-label">Fazer uma sugestão</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="assunto" id="assunto3" value="Outro">
                    <label for="assunto3" class="custom-control-label">Outro</label>
                </div>
            </div>
            <div class="form-group">
                <label>Mensagem:</label>
                <textarea id="mensag" name="mensag" class="form-control" rows="4" placeholder="Digite ..."></textarea>
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" id="fileToUploadTalk" name="fileToUploadTalk" accept="image/png, image/jpeg" class="custom-file-input">
                    <label class="custom-file-label" for="fileToUploadTalk">Imagem (opcional)</label>
                    <span>Arquivo limitado a 1Mb (.png ou .jpeg)</span>
                </div>
            </div>
            <br>
            <button type="submit" name="btn-talk" class="btn btn-primary btn-block">Enviar</button>
        </form>
        
    </div>
    <!-- /.form-box -->
    <a href="Home" class="btn btn-danger btn-block">Cancelar</a>
</div><!-- /.card -->
