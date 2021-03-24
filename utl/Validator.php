<?php

namespace utl;

class Validator
{
    public function minLength($data, $arg)
    {
        if (strlen($data) < $arg) :
            return "Campo deve ter pelo menos $arg caracteres";
        endif;
    }

    public function maxLength($data, $arg)
    {
        if (strlen($data) > $arg) :
            return "Campo deve ter no máximo $arg caracteres";
        endif;
    }

    public function digit($data)
    {
        if (!ctype_digit($data)) :
            return "Todo caracter deve ser um dígito";
        endif;
    }

    public function alpha($data)
    {
        if (!ctype_alpha($data)) :
            return "Todo caracter deve ser uma letra";
        endif;
    }

    public function alphaPlusSpaces($data)
    {
        if (!ctype_alpha(str_replace(' ', '', $data))) :
            return "Todo caracter deve ser uma letra";
        endif;
    }
}
