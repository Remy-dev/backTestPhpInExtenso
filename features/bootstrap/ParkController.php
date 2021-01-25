<?php

class ParkController {

    private $fleetManager;
    private $vehicleManager;
    private $locationManager;
    private $vehicle;
    private $fleet;
    private $location;
    private $errorMessage;
    protected $app;

    const NOT_PARKED = 0;
    const ALREADY_PARKED = 1;
    const ALREADY_REGISTERED = 2;
    const NOT_REGISTERED_INTO_FLEET = 3;
    const ERROR_LOCATION = 4;
    const LOCATION_ALREADY_USED = 5;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->fleetManager = new FleetManager();
        $this->vehicleManager = new VehicleManager();
        $this->locationManager = new LocationManager();
    }

    public function getFleet() {
        return $this->fleet;
    }

    public function getVehicle() {
        return $this->vehicle;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getErrorMessage() {
        return $this->errorMessage;
    }

    public function setFleet(Fleet $fleet){
        $this->fleet = $fleet;
    }

    public function setVehicle(Vehicle $vehicle){
        $this->vehicle = $vehicle;
    }

    public function initialiseFleet($id)
    {
       $this->fleet = new Fleet($this->fleetManager->find($id));
       return $this;
    }

    public function registerVehicle(ParkController $controller) {
        $this->vehicle = $controller->getVehicle();
        $matchedVehicle = $this->vehicleManager->find($this->vehicle->getRegistration());

        if(!$matchedVehicle)
        {
            $this->vehicleManager->addVehicle($this->vehicle);
            $this->errorMessage = '';
            return $this;
        } else {
            $this->errorMessage = self::ALREADY_REGISTERED;
            return $this;
        }
    }

    public function isRegistered(ParkController $controller){
        $this->vehicle = $controller->getVehicle();
        $this->fleet = $controller->getFleet();
        $isRegistered =  $this->fleet->getId() === $this->vehicle->getFleetId();
        if($isRegistered) {
            $this->errorMessage = '';
            return $this;
        } else {
            $this->errorMessage = self::NOT_REGISTERED_INTO_FLEET;
            return $this;
        }
    }

    public function registerVehicleIntoFleet(ParkController $controller) {

        $this->vehicle = $controller->getVehicle();
        $this->fleet = $controller->getFleet();
        $this->vehicle->setFleetId($this->fleet->getId());
        $this->vehicleManager->updateVehicle($this->vehicle);
        return $this;
    }

    public function parkVehicle(ParkController $controller){
            $vehicle = $controller->getVehicle();
            $vehicle->setParkLocation($controller->getLocation()->getCoordinates());
            $this->vehicleManager->updateVehicle($vehicle);
            $this->errorMessage = '';
            return $this;
    }

    public function isParked(ParkController $controller){
        $checkedVehicule = $this->vehicleManager->find($controller->getVehicle()->getRegistration());
        if($checkedVehicule->getParkLocation() === $controller->getLocation()->getCoordinates()) {
            $this->errorMessage = '';
            return $this;
        } else {
            $this->errorMessage = self::NOT_PARKED;
            return $this;
        }
    }



    public function registerLocation($location){

        $this->location = new Location();
        $this->location->setCoordinates($location);
        $this->locationManager->addLocation($location);
        return $this;
    }

    public function checkLocation(ParkController $controller) {

        $vehicle = $this->vehicleManager->find($controller->getVehicle()->getRegistration());
        if($vehicle->getParkLocation() === $this->location->getCoordinates()) {
            $this->errorMessage = '';
            return $this;
        } else {
            $this->errorMessage = self::ERROR_LOCATION;
            return $this;
        }
    }

    public function onPark(){

        if($this->vehicle->getParkLocation() === $this->location->getCoordinates()){
           return self::ALREADY_PARKED;
        } else {
            return self::NOT_PARKED;
        }

    }
    public function isLocationAlreadyUsed (ParkController $controller) {
        $vehicles = $this->vehicleManager->getVehicles();
        $isUsed = false;

            foreach($vehicles as $key => $value){
                foreach($value as $key2 => $el) {
                    if($controller->getLocation()->getCoordinates() === $el['parkLocation'])
                    {
                        $isUsed = true;
                    }
                }
            }

        if(false === $isUsed) {
            $this->errorMessage = '';
            return $this;
        } else {
            $this->errorMessage = self::LOCATION_ALREADY_USED;
            return $this;
        }
    }

    public function isPartOfMyFleet(ParkController $controller) {
        $this->fleet = $controller->getFleet();
        $this->vehicle = $controller->getVehicle();
      if($this->fleet->getId() === $this->vehicle->getFleetId()){
          $this->errorMessage = '';
          return $this;
      }else {
          $this->errorMessage = self::NOT_REGISTERED_INTO_FLEET;
          return $this;
      }
    }

}


