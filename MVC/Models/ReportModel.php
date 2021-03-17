<?php

namespace Models;

use lib\Session;

class ReportModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updateRep()
    {
        //
    }

    public function deleteRep()
    {
        //
    }

    public function doS13()
    {
        //
    }

    public function readReport()
    {
        //Se acesso for de ADM, lê todos os publicadores
        if (Session::get('access') >= 8) :
            $pub = $this->db->read("publisher", "id, nome, sobrenome");
        else :
            $id = Session::get('id');
            $pub = $this->db->read("publisher", "id, nome, sobrenome", "id = $id");
        endif;

        //Lê a cobertura atual e inicia Relatório como vazio
        $cob = $this->db->read("event", "cobert", "", "ORDER BY id DESC LIMIT 1");
        $cob = $cob['cobert'];
        $rel = null;

        //Verifica se a leitura será de um unico publicador e faz as adaptações necessárias
        if (isset($pub['id'])) :
            $pub = [0 => $pub];
        endif;

        //Faz a analise para cada publicador
        foreach ($pub as $singlePub) :
            $id = $singlePub['id'];

            //Conta quantos relatórios foram feitos (se nenhum foi feito, vai para o prox publicador)
            $repQtd = $this->db->read("event", "id", "id_user = $id AND event_type = 'doRel' AND cobert = $cob", "ORDER BY id DESC");
            if ($repQtd == false) :
                continue;
            endif;
            $repQtd = count($repQtd);

            //Avalia se os relatórios registrados (doRel) foram corrigidos (attRel) ou deletados (delRel)
            for ($i = 0; $i < $repQtd; $i++) :
                $relOld = $this->db->read("event", "*", "id_user = $id AND event_type = 'doRel' AND cobert = $cob", "ORDER BY id LIMIT 1 OFFSET $i");

                //Verifica se relatório sofreu alterações
                $idMap = $relOld->getIdMap();
                $relAtt = $this->db->read("event", "*", "id_user = $id AND id_mapa = $idMap AND (event_type = 'attRel' OR event_type = 'delRel') AND cobert = $cob", "ORDER BY id DESC LIMIT 1");

                //Verifica Mapa e Quadra do relatório
                $quad = $this->db->read("map", "maps, quadra", "id = $idMap");

                //Caso não tenha nenhuma mudança, envia o relatório
                if ($relAtt == false) :
                    $rel[$id][$i] = [$relOld, $quad];
                    continue;
                endif;

                //Caso o relatório tenha sido deletado, não envia dado
                $tipo = $relAtt->getEventType();
                if ($tipo == "delRel") :
                    $rel[$id][$i] = null;
                    continue;
                endif;

                //Caso o relatório tenha sido atualizado, envia a atualização
                if ($tipo == "attRel") :
                    $rel[$id][$i] = [$relAtt, $quad];
                    continue;
                endif;
            endfor;
        endforeach;
        return $rel;
    }
}
