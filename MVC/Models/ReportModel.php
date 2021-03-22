<?php

namespace Models;

use lib\Session;

class ReportModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function doS13()
    {
        header('Content-Type: text/html; charset=UTF-8');
        //Variavel para monstarmos a tabela
        $dadosXls  = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
        $dadosXls .= "<table border='1'>";
        $dadosXls .= "<tr>";
        for ($i = 1; $i <= 24; $i++) :
            $dadosXls .= "<th colspan='2'>Mapa " . $i . "</th>";
        endfor;
        $dadosXls .= "</tr>";

        //Lê cobert atual
        $cobertNow = $this->db->read("event", "cobert", "", "ORDER BY id DESC LIMIT 1");
        $cobertNow = $cobertNow['cobert'];
        //Passa pelos registros de cada cobert
        for ($i = 1; $i <= $cobertNow; $i++) :
            $dadosXls .= "<tr>";
            //Passa por cada um dos mapas para preencher os nomes dos dirigentes
            for ($j = 1; $j <= 24; $j++) :
                //Lê qual id da primeira quadra do mapa
                $mapFirst = $this->db->read("map", "id", "maps = $j", "ORDER BY id ASC LIMIT 1");
                $mapFirst = $mapFirst['id'];
                //Lê qual id da última quadra do mapa
                $mapLast = $this->db->read("map", "id", "maps = $j", "ORDER BY id DESC LIMIT 1");
                $mapLast = $mapLast['id'];

                //Lê id de qual publicador mais trabalhou no mapa
                $idUser = $this->db->read("event", "id_user, COUNT(id_user) AS Qtd", "cobert = $i AND id_mapa BETWEEN $mapFirst AND $mapLast", "GROUP BY id_user ORDER BY COUNT(id_user) DESC LIMIT 1");
                //Escreve nome do publicador, se houver
                if ($idUser == false) :
                    $dadosXls .= "<td colspan='2'></td>";
                    continue;
                else :
                    $idUser = $idUser['id_user'];
                    $publisher = $this->db->read("publisher", "nome, sobrenome", "id = $idUser");
                    $dadosXls .= "<td colspan='2'>" . $publisher['nome'] . " " . $publisher['sobrenome'] . "</td>";
                endif;
            endfor;
            $dadosXls .= "</tr>";
            $dadosXls .= "<tr>";
            //Passa por cada um dos mapas para preencher as datas trabalhadas
            for ($j = 1; $j <= 24; $j++) :
                //Lê qual id da primeira quadra do mapa
                $mapFirst = $this->db->read("map", "id", "maps = $j", "ORDER BY id ASC LIMIT 1");
                $mapFirst = $mapFirst['id'];
                //Lê qual id da última quadra do mapa
                $mapLast = $this->db->read("map", "id", "maps = $j", "ORDER BY id DESC LIMIT 1");
                $mapLast = $mapLast['id'];

                //Lê quando trabalho no mapa começou
                $temp[0] = $this->db->read("event", "timeN", "cobert = $i AND event_type = 'doRel' AND id_mapa BETWEEN $mapFirst AND $mapLast", "ORDER BY timeN LIMIT 1");

                //Confere se todas as quadras do mapa foram trabalhadas
                $conf = $this->db->read("event", "COUNT(id_user) AS Qtd", "cobert = $i AND event_type = 'doRel' AND id_mapa BETWEEN $mapFirst AND $mapLast");
                if ($conf['Qtd'] < ($mapLast - $mapFirst + 1)) :
                    //Se não foi completo, tempo de conclusão fica vazio
                    $temp[1]['timeN'] = "";
                else :
                    //Se foi completo, lê o tempo de conclusão
                    $temp[1] = $this->db->read("event", "timeN", "cobert = $i AND event_type = 'doRel' AND id_mapa BETWEEN $mapFirst AND $mapLast", "ORDER BY timeN DESC LIMIT 1");
                endif;

                //Escreve as datas de inicio e fim do trabalho no mapa, se houver
                if ($temp[0] == false) :
                    $dadosXls .= "<td></td>";
                    $dadosXls .= "<td></td>";
                    continue;
                else :
                    $dadosXls .= "<td>" . substr($temp[0]['timeN'], 0, strpos($temp[0]['timeN'], ' ')) . "</td>";
                    $dadosXls .= "<td>" . substr($temp[1]['timeN'], 0, strpos($temp[1]['timeN'], ' ')) . "</td>";
                endif;
            endfor;
            $dadosXls .= "</tr>";
        endfor;
        $dadosXls .= "</table>";

        //Nome do arquivo que será exportado
        $arquivo = "S13.xls";
        //Configurações header para forçar o download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $arquivo . '"');
        header('Cache-Control: max-age=0');
        //Se for o IE9, isso talvez seja necessário
        header('Cache-Control: max-age=1');
        //Envia o conteúdo do arquivo
        echo $dadosXls;
        exit;
    }

    public function updateRep()
    {
        //POST e IDs
        $idUser = Session::get('id');
        $idMap = $_POST['id_map'];
        $nRes = $_POST['n_res'];
        $nCom = $_POST['n_com'];
        $nEdi = $_POST['n_edi'];

        //Atualiza tabela map
        $this->db->update("map", ["trab" => 1, "n_residencia" => $nRes, "n_comercio" => $nCom, "n_edificio" => $nEdi], "id = $idMap");

        //Salva log do ocorrido na tabela de eventos
        $log = ["id" => null, "id_user" => $idUser, "id_mapa" => $idMap, "timeN" => date('d/m/Y H:i:s'), "event_type" => "attRel", "data1" => "trab", "desc1" => 1, "data2" => "nRes", "desc2" => $nRes, "data3" => "nCom", "desc3" => $nCom, "data4" => "nEdi", "desc4" => $nEdi];
        $this->db->create("event", $log);

        //Se tudo deu certo emite mensagem de sucesso e retorna a index
        $this->msg("Relatório atualizado com sucesso", "success", "report/frame/" . $idUser . "/" . $_POST['pg']);
    }

    public function deleteRep()
    {
        //Declara IDs
        $idMap = $_POST['id_map'];
        $idUser = Session::get('id');

        //Verifica se existem dados salvos de coberturas passadas
        $cob = $this->db->read("event", "cobert", "", "ORDER BY id DESC LIMIT 1");
        $cob = $cob['cobert'] - 1;
        $dadosQuadraOld = $this->db->read("event", "*", "id_mapa = $idMap AND (event_type = 'doRel' OR event_type = 'attRel') AND cobert = $cob", "ORDER BY id DESC LIMIT 1");

        if ($dadosQuadraOld == false) :
            //Se não houver dados, define como 0
            $this->db->update("map", ["trab" => 0, "n_residencia" => 0, "n_comercio" => 0, "n_edificio" => 0], "id = $idMap");
        else :
            //Se houver dados, lança eles
            $this->db->update("map", ["trab" => 0, "n_residencia" => $dadosQuadraOld->getDesc2(), "n_comercio" => $dadosQuadraOld->getDesc3(), "n_edificio" => $dadosQuadraOld->getDesc4()], "id = $idMap");
        endif;

        //Salva log do ocorrido na tabela de eventos
        $log = ["id" => null, "id_user" => $idUser, "id_mapa" => $idMap, "timeN" => date('d/m/Y H:i:s'), "event_type" => "delRel", "data1" => null, "desc1" => null, "data2" => null, "desc2" => null, "data3" => null, "desc3" => null, "data4" => null, "desc4" => null];
        $this->db->create("event", $log);

        //Se tudo deu certo emite mensagem de sucesso e retorna a index
        $this->msg("Relatório deletado com sucesso", "success", "report/frame/" . $idUser . "/" . $_POST['pg']);
    }

    public function readRep($pubId, $pg)
    {
        //Lê a cobertura atual e inicia Relatório como vazio
        $cob = $this->db->read("event", "cobert", "", "ORDER BY id DESC LIMIT 1");
        $cob = (isset($cob['cobert'])) ? $cob['cobert'] : 1;
        $rel = null;

        //Conta quantos relatórios foram feitos
        $repQtd = $this->db->read("event", "id", "id_user = $pubId AND event_type = 'doRel' AND cobert = $cob", "ORDER BY id DESC");
        if ($repQtd == false) :
            //Se nenhum foi feito, vai para o prox publicador
            $this->count = 0;
            return false;
        endif;
        $repQtd = count($repQtd);
        $this->count = $repQtd;

        //Primeiro e último relatório a ser lido
        $first = ($pg - 1) * 15;
        if ($this->count > $first + 15) :
            $last = $first + 15;
        else :
            $last = $this->count;
        endif;

        //Avalia se os relatórios registrados (doRel) foram corrigidos (attRel) ou deletados (delRel)
        for ($i = $first; $i < $last; $i++) :
            $relOld = $this->db->read("event", "*", "id_user = $pubId AND event_type = 'doRel' AND cobert = $cob", "ORDER BY id DESC LIMIT 1 OFFSET $i");
            $idRel = $relOld->getId();

            //Verifica se relatório sofreu alterações
            $idMap = $relOld->getIdMap();
            $relAtt = $this->db->read("event", "*", "id_user = $pubId AND id_mapa = $idMap AND (event_type = 'attRel' OR event_type = 'delRel') AND cobert = $cob AND id > $idRel", "ORDER BY id DESC LIMIT 1");

            //Verifica Mapa e Quadra do relatório
            $quad = $this->db->read("map", "maps, quadra", "id = $idMap");

            //Caso não tenha nenhuma mudança, envia o relatório
            if ($relAtt == false) :
                $rel[$i] = [$relOld, $quad];
                continue;
            endif;

            //Caso o relatório tenha sido deletado, não envia dado
            $tipo = $relAtt->getEventType();
            if ($tipo == "delRel") :
                $rel[$i] = ["Relatório deletado", $quad];
                continue;
            endif;

            //Caso o relatório tenha sido atualizado, envia a atualização
            if ($tipo == "attRel") :
                $rel[$i] = [$relAtt, $quad];
                continue;
            endif;
        endfor;
        return $rel;
    }
}
