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
            $newDataWork = ["worked" => ""];
            $newDataRes = ["nResidencia" => ""];
            $newDataCom = ["nComercio" => ""];
            $newDataEdi = ["nEdificio" => ""];
            $idMap = $dados_quadra->getId();
            $idUser = Session::get("id");
            $change = 0;

            //Verifica se houve mudanças: trabalhada
            if (intval(isset($_POST['work_' . $dados_quadra->getId()]) ? "1" : "0") != intval($dados_quadra->getWorked())) :
                $newDataWork = ["worked" => isset($_POST['work_' . $dados_quadra->getId()]) ? "1" : "0"];
                $change = 1;
            endif;

            //Verifica se houve mudanças: numero de residencias
            if (intval($dados_quadra->getRes()) != intval($_POST['n_res_' . $dados_quadra->getId()])) :
                $newDataRes = ["nResidencia" => $_POST['n_res_' . $dados_quadra->getId()]];
                $change = 1;
            endif;

            //Verifica se houve mudanças: numero de comercios
            if (intval($dados_quadra->getCom()) != intval($_POST['n_com_' . $dados_quadra->getId()])) :
                $newDataCom = ["nComercio" => $_POST['n_com_' . $dados_quadra->getId()]];
                $change = 1;
            endif;

            //Verifica se houve mudanças: numero de edificios
            if (intval($dados_quadra->getEdi()) != intval($_POST['n_edi_' . $dados_quadra->getId()])) :
                $newDataEdi = ["nEdificio" => $_POST['n_edi_' . $dados_quadra->getId()]];
                $change = 1;
            endif;

            //Caso tenha alguma mudança
            if ($change == 1) :
                //Atualiza a tabela map
                $newData = array_merge($newDataWork, $newDataRes, $newDataCom, $newDataEdi);
                $this->db->update("map", $newData, "id = $idMap");

                //Registra o evento do relatório
                $log = ["id" => null, "idUser" => $idUser, "idMapa" => $idMap, "timeN" => date('d/m/Y H:i:s'), "eventType" => "doRel", "data1" => "worked", "desc1" => $newData['worked'], "data2" => "nRes", "desc2" => $newData['nResidencia'], "data3" => "nCom", "desc3" => $newData['nComercio'], "data4" => "nEdi", "desc4" => $newData['nEdificio']];
                $this->db->create("event", $log);
            endif;
        endforeach;

        //Verifica se o território foi completo
        $this->completeTerr();

        //Emite mensagem de sucesso e redireciona para o frame dos relatórios
        $this->msg("Relatório enviado com sucesso!", "success", "Territory/frame/" . $_POST['mapactive']);
    }

    /**
     * completeTerr
     * Verifica se todas as quadras do território foram trabalhadas
     * Em caso afirmativo, registra na tabela de eventos e reinicia todo território
     */
    public function completeTerr()
    {
        $data = $this->db->read("map", "id", "worked = 0");

        if ($data == false) :
            $info = $this->db->read("event", "cobert", "", "ORDER BY id DESC LIMIT 1");

            $log = ["id" => null, "idUser" => null, "idMapa" => null, "timeN" => date('d/m/Y H:i:s'), "eventType" => "terrComp", "data1" => null, "desc1" => null, "data2" => null, "desc2" => null, "data3" => null, "desc3" => null, "data4" => null, "desc4" => null];
            $this->db->create("event", $log);

            $sql = "ALTER TABLE event ALTER cobert SET default :cobert";
            $p_sql = $this->db::conn()->prepare($sql);
            $p_sql->bindValue(":cobert", $info['cobert'] + 1);
            $p_sql->execute();
            $this->db::closeConn();

            $this->db->update("map", ["worked" => 0], "1 = 1");
            return 0;
        else :
            return 0;
        endif;
    }
}
