<?php




class VehicleManager
{
    const NOT_REGISTERED = 1;
    private $registration;

    public static function getVehicles(): array
    {
        $vehiclesDatabase = file_get_contents(__DIR__.'/vehicles.json');
        $vehicles = json_decode($vehiclesDatabase, true);

        return $vehicles;

    }

    public function addVehicle(Vehicle $vehicle): void
    {
        $vehiclesDatabase = file_get_contents(__DIR__.'/vehicles.json');
        $content = json_decode($vehiclesDatabase, true);
        array_push($content['vehicles'],[
            "registration" =>$vehicle->getRegistration(),
            "type" => $vehicle->getType(),
            "fleetId" => [$vehicle->getFleetId()],
            "parkLocation" => $vehicle->getParkLocation(),
            "isParked" => $vehicle->isParked()
        ]);


        file_put_contents(__DIR__.'/vehicles.json', json_encode($content, JSON_PRETTY_PRINT));

    }

    public function updateVehicle(Vehicle $vehicle): void
    {
        $vehiclesDatabase = file_get_contents(__DIR__.'/vehicles.json');
        $content = json_decode($vehiclesDatabase, true);
        var_dump($vehicle->getParkLocation());
        foreach($content as $key => $element)
        {
            foreach($element as $key2 => $el){
                if($el['registration'] === $vehicle->getRegistration()){

                    $content[$key][$key2]["registration"] = $vehicle->getRegistration();
                    $content[$key][$key2]["type"] = $vehicle->getType();

                       if(!in_array($vehicle->getFleetId(), $el['fleetId'])){
                           array_push($content[$key][$key2]['fleetId'], $vehicle->getFleetId());
                       }

                    $content[$key][$key2]["parkLocation"] = $vehicle->getParkLocation();
                    $content[$key][$key2]["isParked"] = $vehicle->isParked();

                }
            }


        }
        file_put_contents(__DIR__.'/vehicles.json', json_encode($content, JSON_PRETTY_PRINT));
    }


    public function find($registration)
    {
        $vehicle = [];
        $vehiclesDatabase = file_get_contents(__DIR__.'/vehicles.json');
        $content = json_decode($vehiclesDatabase, true);
        foreach($content as $key => $element){
           foreach($element as $key2 => $el){
               if($el['registration'] === $registration)
               {
                  $vehicle = $el;
               }
           }
        }

        return !empty($vehicle) ? new Vehicle($vehicle) : null;

    }

}
