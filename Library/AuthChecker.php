<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 09.09.18
 * Time: 15:52
 */

namespace Library;


trait AuthChecker
{
    public function passwordCheck($pass, $hashPass)
    {
        if (hash_equals(crypt($pass . SALT), $hashPass)) {
            return true;
        }

        return false;
    }
}