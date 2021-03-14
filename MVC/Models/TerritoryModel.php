<?php

namespace Models;

use lib\Session;

class TerritoryModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updateMaps($identificator)
    {
        //Lê todos os dados do referido mapa
        $data = $this->db->read("map", "*", "maps = $identificator");

        //Analisa quadra por quadra
        foreach ($data as $dados_quadra) :
            $newDataTrab = ["trab" => ""];
            $newDataRes = ["n_residencia" => ""];
            $newDataCom = ["n_comercio" => ""];
            $newDataEdi = ["n_edificio" => ""];
            $idMap = $dados_quadra->getId();
            $idUser = Session::get("id");
            $change = 0;

            //Verifica se houve mudanças: trabalhada
            if (intval(isset($_POST['trab_' . $dados_quadra->getId()]) ? "1" : "0") != intval($dados_quadra->getTrab())) :
                $newDataTrab = ["trab" => isset($_POST['trab_' . $dados_quadra->getId()]) ? "1" : "0"];
                $change = 1;
            endif;

            //Verifica se houve mudanças: numero de residencias
            if (intval($dados_quadra->getRes()) != intval($_POST['n_res_' . $dados_quadra->getId()])) :
                $newDataRes = ["n_residencia" => $_POST['n_res_' . $dados_quadra->getId()]];
                $change = 1;
            endif;

            //Verifica se houve mudanças: numero de comercios
            if (intval($dados_quadra->getCom()) != intval($_POST['n_com_' . $dados_quadra->getId()])) :
                $newDataCom = ["n_comercio" => $_POST['n_com_' . $dados_quadra->getId()]];
                $change = 1;
            endif;

            //Verifica se houve mudanças: numero de edificios
            if (intval($dados_quadra->getEdi()) != intval($_POST['n_edi_' . $dados_quadra->getId()])) :
                $newDataEdi = ["n_edificio" => $_POST['n_edi_' . $dados_quadra->getId()]];
                $change = 1;
            endif;

            //Caso tenha alguma mudança
            if ($change == 1) :
                //Atualiza a tabela map
                $newData = array_merge($newDataTrab, $newDataRes, $newDataCom, $newDataEdi);
                $this->db->update("map", $newData, "id = $idMap");

                //Registra o evento do relatório
                $log = ["id" => null, "id_user" => $idUser, "id_mapa" => $idMap, "timeN" => date('d/m/Y H:i:s'), "event_type" => "doRel", "data1" => "trab", "desc1" => $newData['trab'], "data2" => "nRes", "desc2" => $newData['n_residencia'], "data3" => "nCom", "desc3" => $newData['n_comercio'], "data4" => "nEdi", "desc4" => $newData['n_edificio']];
                $this->db->create("event", $log);
            endif;
        endforeach;

        //Verifica se o território foi completo
        $this->completeTerr();

        //Emite mensagem de sucesso e redireciona para o frame dos relatórios
        $this->msg("Relatório enviado com sucesso!", "success", "territory/frame/" . $_POST['mapactive']);
    }

    /**
     * completeTerr
     * Verifica se todas as quadras do território foram trabalhadas
     * Em caso afirmativo, registra na tabela de eventos e reinicia todo território
     */
    public function completeTerr()
    {
        $data = $this->db->read("map", "id", "trab = 0");

        if ($data == false) :
            $info = $this->db->read("event", "cobert", "", "ORDER BY id DESC LIMIT 1");

            $log = ["id" => null, "id_user" => null, "id_mapa" => null, "timeN" => date('d/m/Y H:i:s'), "event_type" => "terrComp", "data1" => null, "desc1" => null, "data2" => null, "desc2" => null, "data3" => null, "desc3" => null, "data4" => null, "desc4" => null];
            $this->db->create("event", $log);

            $sql = "ALTER TABLE event ALTER cobert SET default :cobert";
            $p_sql = $this->db::conn()->prepare($sql);
            $p_sql->bindValue(":cobert", $info['cobert'] + 1);
            $p_sql->execute();
            $this->db::closeConn();

            $this->db->update("map", ["trab" => 0], "1 = 1");
            return 0;
        else :
            return 0;
        endif;
    }
}
