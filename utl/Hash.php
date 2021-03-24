<?php

namespace utl;

class Hash
{
    public static function create($algorithm, $data, $key)
    {
        $context = hash_init($algorithm, HASH_HMAC, $key);
        hash_update($context, $data);
        return hash_final($context);
    }
}
