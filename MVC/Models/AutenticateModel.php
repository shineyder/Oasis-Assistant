<?php

namespace Models;

class AutenticateModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function autenticate($cod)
    {
        $verify = 0;
        $data = array();
        $data = $this->db->read("publisher", "id, usuario", "access = 0");

        if (@is_array($data[0])) :
            foreach ($data as $dataSingle) :
                if ($cod == md5($dataSingle['usuario'])) :
                    $verify = 1;
                    $id = $dataSingle['id'];
                    $this->db->update("publisher", ['access' => 1], "id = $id");
                    return $verify;
                endif;
            endforeach;
        else :
            if ($cod == @md5($data['usuario'])) :
                $verify = 1;
                $id = $data['id'];
                $this->db->update("publisher", ['access' => 1], "id = $id");
                return $verify;
            endif;
        endif;

        return $verify;
    }
}
