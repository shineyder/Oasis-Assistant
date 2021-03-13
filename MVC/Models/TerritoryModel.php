<?php

namespace Models;

class TerritoryModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function registerReport()
    {
        if (isset($_POST['btn-env-rel'])) :
            $id_first = $_POST['first'];
            $id_last = $_POST['last'];

            for ($i = $id_first; $i <= $id_last; $i++) {
                $dados_quadra = MapsDAO::getInstance()->read($i);
                $isChange = 0;
                if (intval(isset($_POST['trab_' . $i]) ? "1" : "0") != intval($dados_quadra->getTrab())) :
                    $dados_quadra->setTrab(isset($_POST['trab_' . $i]) ? "1" : "0");
                    $isChange = 1;
                endif;
        
                if (intval($dados_quadra->getRes()) != intval($_POST['n_res_' . $i])) :
                    $dados_quadra->setRes($_POST['n_res_' . $i]);
                    $isChange = 1;
                endif;
        
                if (intval($dados_quadra->getCom()) != intval($_POST['n_com_' . $i])) :
                    $dados_quadra->setCom($_POST['n_com_' . $i]);
                    $isChange = 1;
                endif;
        
                if (intval($dados_quadra->getEdi()) != intval($_POST['n_edi_' . $i])) :
                    $dados_quadra->setEdi($_POST['n_edi_' . $i]);
                    $isChange = 1;
                endif;
        
                if ($isChange == 1) :
                    MapsDAO::getInstance()->update($dados_quadra);
                    $cob = EventsDAO::getInstance()->cobertNow();
        
                    if (EventsDAO::getInstance()->isRel($i, $cob) == 1) :
                        $event = new Events(null, $publicador->getId(), $dados_quadra->getId(), null, "attRel", "trab", $dados_quadra->getTrab(), "nRes", $dados_quadra->getRes(), "nCom", $dados_quadra->getCom(), "nEdi", $dados_quadra->getEdi(), null);
                    else :
                        $event = new Events(null, $publicador->getId(), $dados_quadra->getId(), null, "doRel", "trab", $dados_quadra->getTrab(), "nRes", $dados_quadra->getRes(), "nCom", $dados_quadra->getCom(), "nEdi", $dados_quadra->getEdi(), null);
                    endif;
        
                    EventsDAO::getInstance()->create($event);
                endif;
            }
            MapsDAO::getInstance()->completTerr();
            redirect('http://oasisassistant.com/report.php#' . $_POST['mapactive']);
            exit();
        endif;
        
        $cob = EventsDAO::getInstance()->cobertNow();
        $count = EventsDAO::getInstance()->relCount($publicador->getId(), $cob);
        
        for ($i = 0; $i < $count; $i++) :
            if (isset($_POST['btn-up-rel-' . $i])) :
                $id_map = $_POST['id_map'];
                $dados_quadra = MapsDAO::getInstance()->read($id_map);
                $dados_quadra->setRes($_POST['n_res_' . $i]);
                $dados_quadra->setCom($_POST['n_com_' . $i]);
                $dados_quadra->setEdi($_POST['n_edi_' . $i]);
                MapsDAO::getInstance()->update($dados_quadra);
        
                $event = new Events(null, $publicador->getId(), $dados_quadra->getId(), null, "attRel", "trab", $dados_quadra->getTrab(), "nRes", $dados_quadra->getRes(), "nCom", $dados_quadra->getCom(), "nEdi", $dados_quadra->getEdi(), null);
                EventsDAO::getInstance()->create($event);
        
                redirect('http://oasisassistant.com/my_reports.php');
                exit();
            endif;
        
            if (isset($_POST['btn-del-rel-' . $i])) :
                $id_map = $_POST['id_map'];
        
                $dados_quadra = MapsDAO::getInstance()->read($id_map);
        
                $event = new Events(null, $publicador->getId(), $id_map, null, "delRel", null, null, null, null, null, null, null, null, null);
                EventsDAO::getInstance()->create($event);
        
                $dados_quadra_old = EventsDAO::getInstance()->readLastRelatorio($id_map);
        
                if ($dados_quadra_old == 0) :
                    $dados_quadra->setTrab(0);
                    $dados_quadra->setRes(0);
                    $dados_quadra->setCom(0);
                    $dados_quadra->setEdi(0);
                    MapsDAO::getInstance()->update($dados_quadra);
                else :
                    $dados_quadra->setTrab(0);
                    $dados_quadra->setRes($dados_quadra_old->getDesc2());
                    $dados_quadra->setCom($dados_quadra_old->getDesc3());
                    $dados_quadra->setEdi($dados_quadra_old->getDesc4());
                    MapsDAO::getInstance()->update($dados_quadra);
                endif;
        
                redirect('http://oasisassistant.com/my_reports.php');
                exit();
            endif;
        endfor;
    }
}