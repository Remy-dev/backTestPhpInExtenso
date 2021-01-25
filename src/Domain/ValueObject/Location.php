<?php

namespace App\Domain\ValueObject;


class Location {

    private $coordinates;

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;
    }
}
