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

        if ($data == false) :
            return $verify;
        endif;

        if (@is_array($data[0])) :
            foreach ($data as $dataSingle) :
                $verify = $this->verifyAutenticateCode($cod, $dataSingle);
            endforeach;
        else :
            $verify = $this->verifyAutenticateCode($cod, $data);
        endif;

        return $verify;
    }

    public function verifyAutenticateCode($cod, $data)
    {
        $isEqual = 0;
        if ($cod == md5($data['usuario'])) :
            $isEqual = 1;
            $id = $data['id'];
            $this->db->update("publisher", ['access' => 1], "id = $id");
        endif;
        return $isEqual;
    }
}
