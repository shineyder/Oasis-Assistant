<?php

session_start();

/** Página:
*     Oculta - Ação PHP - Atualizar Publicadores
*   Conteúdo:
*     Atualiza a informação do servidor com respeito aos dados dos Publicadores.*/

// Função redirect

require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Assistant\PublicadorDAO;
use Assistant\EventoDAO;
use Assistant\Eventos;

if (isset($_POST['btn-up-email'])) :
    $id = $_POST['id'];
    $email = $_POST['email-up'];

    if (empty($email)) :
        $_SESSION['mensagem'] = "Campo Novo E-mail não foi preenchido";
        redirect('https://oasisassistant.000webhostapp.com/home.php');
        exit();
    else :
        $data_type = ['id', 'email'];
        $detail = [$id, $email];
        $publicadorup = PublicadorDAO::getInstance()->readAll($data_type, $detail);

        if ($publicadorup->getAccess() !== null) :
            $_SESSION['mensagem'] = "E-mail antigo e novo são iguais";
            redirect('https://oasisassistant.000webhostapp.com/home.php');
            exit();
        else :
            $data_type = ['id', ""];
            $detail = [$id, ""];
            $publicadorup = PublicadorDAO::getInstance()->readAll($data_type, $detail);
            $publicadorup->setEmail($email);
            $PublicadorDAO = PublicadorDAO::getInstance()->update($publicadorup);
            $_SESSION['obj'] = serialize($publicadorup);
            $_SESSION['mensagem'] = "E-mail alterado com sucesso!";

            $event = new Eventos(null, $publicadorup->getId(), null, null, "attPub", "AltEmail", $publicadorup->getEmail(), null, null, null, null, null, null, null);
            EventoDAO::getInstance()->create($event);

            redirect('https://oasisassistant.000webhostapp.com/home.php');
            exit();
        endif;
    endif;
endif;

if (isset($_POST['btn-up-senha'])) :
    $id = $_POST['id'];
    $senha_old = $_POST['senha-old'];
    $senha = $_POST['senha-up'];
    $senha_conf = $_POST['senha-up-conf'];

    if (empty($senha_old) or empty($senha) or empty($senha_conf)) :
        $_SESSION['mensagem'] = "Todos os campos precisam ser preenchidos";
        redirect('https://oasisassistant.000webhostapp.com/home.php');
        exit();
    else :
        if ($senha != $senha_conf) :
            $_SESSION['mensagem'] = "As novas senhas preenchidas não são iguais";
            redirect('https://oasisassistant.000webhostapp.com/home.php');
            exit();
        else :
            $data_type = ['id', 'senha'];
            $detail = [$id, md5($senha_old)];
            $publicadorup = PublicadorDAO::getInstance()->readAll($data_type, $detail);

            if ($publicadorup->getAccess() === null) :
                $_SESSION['mensagem'] = "Senha antiga não confere";
                redirect('https://oasisassistant.000webhostapp.com/home.php');
                exit();
            else :
                $senha = md5($senha);
                $publicadorup->setSenha($senha);
                $PublicadorDAO = PublicadorDAO::getInstance()->update($publicadorup);
                $_SESSION['obj'] = serialize($publicadorup);
                $_SESSION['mensagem'] = "Senha alterada com sucesso!";

                $event = new Eventos(null, $publicadorup->getId(), null, null, "attPub", "AltSenha", $publicadorup->getSenha(), null, null, null, null, null, null, null);
                EventoDAO::getInstance()->create($event);

                redirect('https://oasisassistant.000webhostapp.com/home.php');
                exit();
            endif;
        endif;
    endif;
endif;

$countPub = PublicadorDAO::getInstance()->lastId();
$countPub = intval($countPub['id']);

for ($i = 1; $i <= $countPub; $i++) :
    if (isset($_POST['btn-up-gru-' . $i])) :
        $pub = PublicadorDAO::getInstance()->readAll(["id", ""], [$i, ""]);
        $pub->setGrupo($_POST['group-' . $i]);
        PublicadorDAO::getInstance()->update($pub);

        $publicador = unserialize($_SESSION['obj']);
        if ($publicador->getId() == $pub->getId()) :
            $_SESSION['obj'] = serialize($pub);
        endif;

        $event = new Eventos(null, $pub->getId(), null, null, "attPub", "AltGrup", $pub->getGrupo(), null, null, null, null, null, null, null);
        EventoDAO::getInstance()->create($event);
        redirect('https://oasisassistant.000webhostapp.com/master_page.php');
        exit();
    endif;

    if (isset($_POST['btn-up-acc-' . $i])) :
        $pub = PublicadorDAO::getInstance()->readAll(["id", ""], [$i, ""]);
        $pub->setAccess($_POST['acc-' . $i]);
        var_dump($_POST);
        PublicadorDAO::getInstance()->update($pub);

        $event = new Eventos(null, $pub->getId(), null, null, "attPub", "AltAcc", $pub->getAccess(), null, null, null, null, null, null, null);
        EventoDAO::getInstance()->create($event);
        redirect('https://oasisassistant.000webhostapp.com/master_page.php');
        exit();
    endif;
endfor;
