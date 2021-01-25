<?php

namespace App\Domain\Models;

/**
 * Class FleetManager
 * @package App\Domain\Models
 */
class FleetManager
{
    private $id;

    /**
     * @return array of fleets
     *
     */
    public function getFleets(): array
    {

        $fleetsDatabase = file_get_contents(__DIR__.'/fleets.json');

        $fleets = json_decode($fleetsDatabase, true);

        return $fleets;
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function find($id)
    {
        $fleet = [];
        $fleetsDatabase = file_get_contents(__DIR__.'/fleets.json');

        $fleets = json_decode($fleetsDatabase, true);

        foreach($fleets as $key => $value) {
            if($value['id'] == $id)  {
                $fleet = $value;
            }

        }
        return $fleet;
    }


}
