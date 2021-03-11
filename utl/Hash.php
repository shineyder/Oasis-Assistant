<?php

namespace utl;

class Hash
{
    /**
     * @param string $algo the algorithm (md5)
     * @param string $data The data to encode
     * @param string $salt The salt
     * @return string The hashed/salted data
     */
    public static function create($algo, $data, $salt)
    {
        $context = hash_init($algo, HASH_HMAC, $salt);
        hash_update($context, $data);
        return hash_final($context);
    }
}
