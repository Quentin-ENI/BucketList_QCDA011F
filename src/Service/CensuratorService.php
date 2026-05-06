<?php

namespace App\Service;

class CensuratorService
{
    private $insults = [
        "Fichtre",
        "Diantre",
        "Vertuchou",
        "Manant"
    ];

    public function purify(string $text): string {
        return str_ireplace($this->insults, "****", $text);
    }
}
