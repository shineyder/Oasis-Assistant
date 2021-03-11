<?php

namespace lib;

class Model
{
    public function __construct()
    {
        $this->db = new Database();
    }
}
