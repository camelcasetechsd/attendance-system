<?php

namespace Utilities\Service;

class Random {

    public function getRandomName() {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                . '0123456789'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $cid = substr(implode('', $seed), 1, 10) . uniqid();


        return $cid;
    }

}
