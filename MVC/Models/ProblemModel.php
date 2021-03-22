<?php

namespace Models;

use lib\Mail;

class ProblemModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function recover()
    {
        $tipo = $this->sanitize(5, "cod_err", "Problem");

        //Verifica se algum Tipo de problema foi selecionado
        if (empty($tipo)) :
            $this->msg("Nenhum problema selecionado", "warning", "Problem");
        endif;

        //Verifica se as informações sobre o problema foram preenchidas
        if (empty($_POST['rec']) or (isset($_POST['rec2']) ? empty($_POST['rec2']) : false)) :
            $this->msg("Informações solicitadas não preenchidas", "warning", "Problem");
        endif;

        switch ($tipo) :
            case 1: // Esqueceu usuario
                //Validando POST
                $email = $this->sanitize(3, "rec", "Problem");

                //Verifica se o email informado está cadastrado
                $info = $this->db->read("publisher", "*", "email = '$email'");
                if ($info == false) :
                    $this->msg("E-mail não cadastrado", "warning", "Problem");
                endif;

                //Envia email com dados para recuperação
                $email_send = new Mail();
                $message = $email_send->message(1, [$info->getNome(), $info->getSobrenome(), $info->getUsuario()]);
                $email_send->sendMail($info->getEmail(), $info->getNome(), $info->getSobrenome(), $message, "Recuperacao de usuario", "");

                //Salva log do ocorrido na tabela de eventos
                $log = ["id" => null, "id_user" => $info->getId(), "id_mapa" => null, "timeN" => date('d/m/Y H:i:s'), "event_type" => "recPub", "data1" => "RecUser", "desc1" => $info->getUsuario(), "data2" => null, "desc2" => null, "data3" => null, "desc3" => null, "data4" => null, "desc4" => null];
                $this->db->create("event", $log);

                //Se tudo deu certo emite mensagem de sucesso e retorna a index
                $this->msg("Um e-mail para recuperação do usuario foi enviado!", "success");
                break;
            case 2: //Esqueceu senha
                //Validando POST
                $user = $this->sanitize(1, "rec", "Problem");
                $email = $this->sanitize(3, "rec2", "Problem");

                //Verifica se o usuario e o email informado está cadastrado
                $info = $this->db->read("publisher", "*", "usuario = '$user' AND email = '$email'");
                if ($info == false) :
                    $this->msg("E-mail e/ou Usuário não cadastrado", "warning", "Problem");
                endif;

                //Define nova senha como 123456
                $info->setSenha('dbb2e19e00fa08193553b6930032b95a');
                $this->db->update("publisher", ["senha" => "dbb2e19e00fa08193553b6930032b95a"], "usuario = '$user' AND email = '$email'");

                //Envia email com dados para recuperação
                $email_send = new Mail();
                $message = $email_send->message(2, [$info->getNome(), $info->getSobrenome()]);
                $email_send->sendMail($info->getEmail(), $info->getNome(), $info->getSobrenome(), $message, "Recuperacao de senha", "");

                //Salva log do ocorrido na tabela de eventos
                $log = ["id" => null, "id_user" => $info->getId(), "id_mapa" => null, "timeN" => date('d/m/Y H:i:s'), "event_type" => "recPub", "data1" => "RecSenha", "desc1" => "dbb2e19e00fa08193553b6930032b95a", "data2" => null, "desc2" => null, "data3" => null, "desc3" => null, "data4" => null, "desc4" => null];
                $this->db->create("event", $log);

                //Se tudo deu certo emite mensagem de sucesso e retorna a index
                $this->msg("Um e-mail para recuperação de senha foi enviado!", "success");
                break;
            case 3: //Não recebeu email de autenticação
                //Validando POST
                $user = $this->sanitize(1, "rec", "Problem");
                $email = $this->sanitize(3, "rec2", "Problem");

                //Verifica se o usuario informado está cadastrado
                $info = $this->db->read("publisher", "*", "usuario = '$user'");
                if ($info == false) :
                    $this->msg("Usuário não cadastrado", "warning", "Problem");
                endif;

                //Verifica se o email informado é o mesmo do cadastro
                $info = $this->db->read("publisher", "*", "usuario = '$user' AND email = '$email'");
                if ($info == false) :
                    $this->msg("E-mail informado não confere", "warning", "Problem");
                endif;

                //Verifica se a conta já foi autenticada
                if ($info->getAccess() != 0) :
                    $this->msg("E-mail da conta já foi autenticado", "warning", "Problem");
                endif;

                //Envia email com dados para recuperação
                $email_send = new Mail();
                $message = $email_send->message(3, [$info->getNome(), $info->getSobrenome(), $info->getUsuario()]);
                $email_send->sendMail($info->getEmail(), $info->getNome(), $info->getSobrenome(), $message, "Reenvio de email de autenticacao", "");

                //Salva log do ocorrido na tabela de eventos
                $log = ["id" => null, "id_user" => $info->getId(), "id_mapa" => null, "timeN" => date('d/m/Y H:i:s'), "event_type" => "recPub", "data1" => "ReEmailAut", "desc1" => null, "data2" => null, "desc2" => null, "data3" => null, "desc3" => null, "data4" => null, "desc4" => null];
                $this->db->create("event", $log);

                //Se tudo deu certo emite mensagem de sucesso e retorna a index
                $this->msg("E-mail de autenticação foi reenviado!", "success");
                break;
            case 4: //Outro problema
                //Validando POST e verificando Anexo
                $text = $this->sanitize(10, "rec", "Problem");
                $identificador = $this->sanitize(4, "rec2", "Problem");
                $target_file = $this->verifyImg($_FILES["fileToUpload"]);

                //Envia email com os dados da solicitação
                $email_send = new Mail();
                $message = $email_send->message(4, [$identificador, $text]);
                $email_send->sendMail('adrianoshineyder@hotmail.com', 'Adriano', 'Shineyder', strtr($message, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"), "Problema nao padrao", $target_file);

                //Apaga a img
                if ($target_file != '') :
                    unlink($target_file);
                endif;

                //Se tudo deu certo emite mensagem de sucesso e retorna a index
                $this->msg("Solicitação enviada!", "success");
                break;
        endswitch;
    }
}
