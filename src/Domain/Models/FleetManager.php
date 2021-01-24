<?php




class FleetManager
{
    private $id;
    public function getFleets(): array
    {

        $fleetsDatabase = file_get_contents(__DIR__.'/fleets.json');

        $fleets = json_decode($fleetsDatabase, true);

        return $fleets;
    }

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
