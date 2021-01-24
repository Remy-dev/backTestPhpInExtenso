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

    public static function addVehicle(array $vehicle): void
    {
        $vehiclesDatabase = file_get_contents(__DIR__.'/vehicles.json');
        $content = json_decode($vehiclesDatabase, true);
        array_push($content['fleets'], $vehicle);
        file_put_contents(__DIR__.'/vehicles.json', json_encode($content, JSON_PRETTY_PRINT));

    }

    public function updateVehicle(Vehicle $vehicle): void
    {
        $vehiclesDatabase = file_get_contents(__DIR__.'/vehicles.json');
        $content = json_decode($vehiclesDatabase, true);


        foreach($content as $key => $element)
        {
           foreach($element as $entity){
               if($entity['registration'] === $vehicle->getRegistration()){

                   $entity['registration'] = $vehicle->getRegistration();
                   $entity['type'] = $vehicle->getType();
                   $entity['fleetId'] = $vehicle->getFleetId();
                   $entity['parkLocation']= $vehicle->getParkLocation();
                   $entity['isParked'] = $vehicle->isParked();
               }
           }

        }
        file_put_contents(__DIR__.'/vehicles.json', json_encode($content, JSON_PRETTY_PRINT));
    }

    public static function deleteVehicle($id){

        $vehiclesDatabase = fopen(__DIR__.'/vehicles.json', 'w+');
        $vehicles = json_decode($vehiclesDatabase, true);
        $vehicles = array_filter($vehicles, function($vehicle, $id){
           return $vehicle['registration'] !== $id ? $vehicle['registration'] : null;
        });
        fwrite($vehiclesDatabase, json_encode($vehicles, JSON_PRETTY_PRINT));
        fclose($vehiclesDatabase);

    }

    public function find($registration)
    {
        $vehicle = [];
        $this->registration = $registration;
        $vehiclesDatabase = file_get_contents(__DIR__.'/vehicles.json');
        $content = json_decode($vehiclesDatabase, true);
        foreach($content as $key => $element){
           foreach($element as $entity){
               if($entity['registration'] === $this->registration)
               {
                  $vehicle = $entity;
               }
           }
        }
        if(!empty($vehicle['registration'])){
            return $vehicle;
        }
        return 1;
    }

}
