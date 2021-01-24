<?php



class ParkController {

    private $fleetManager;
    private $vehicleManager;
    private $locationManager;
    private $vehicle;
    private $fleet;
    private $location;
    protected $app;

    const NOT_PARKED = 0;
    const ALREADY_PARKED = 1;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->fleetManager = new FleetManager();
        $this->vehicleManager = new VehicleManager();
        $this->locationManager = new LocationManager();
    }
    public function getFleet($id)
    {
        $this->fleet = new Fleet($this->fleetManager->find($id));
        return $this->fleet;
    }


    public function registerVehicle($vehicle){

        if(!$this->isRegistered($vehicle['registration'])){

            $this->vehicle = new Vehicle($vehicle);
            $this->vehicleManager->addVehicle($vehicle);
        }

    }

    public function registerVehicleIntoFleet() {
        $fleet = $this->fleetManager->find('1456');
        $this->vehicle->setFleetId($fleet['id']);
        $this->vehicleManager->updateVehicle($this->vehicle);
    }

    public function parkVehicle(){

        $vehicle = $this->vehicleManager->find($this->vehicle->getRegistration());
        if(!empty($vehicle->getParkLocation())) {
            $vehicle->setParkLocation($this->location->getCoordinates());
            $this->vehicleManager->updateVehicle($vehicle);
        }

    }

    public function isParked($registration){
        $checkedVehicule = $this->vehicleManager->find($registration);
        return $checkedVehicule->getParkLocation() ? true : false;
    }

    public function isRegistered($registration){
        return $this->vehicleManager->find($registration) ? true : false;
    }


    public function registerLocation($location){
        $this->location = new Location();
        $this->location->setCoordinates($location);
        $this->locationManager->addLocation($location);
    }

    public function checkLocation() {

        $vehicle = $this->vehicleManager->find($this->vehicle->getRegistration());
        return $vehicle->getParkLocation() === $this->location->getCoordinates();
    }

    public function onPark(){

        if($this->vehicle->getParkLocation() === $this->location->getCoordinates()){
           return self::ALREADY_PARKED;
        } else {
            return self::NOT_PARKED;
        }

    }
    public function isLocationAlreadyUsed ($location) {
        $location = new Location();
        $location->setCoordinates($location);
        $this->location = $location;
        $vehicles = $this->vehicleManager->getVehicles();
        $result = array_filter($vehicles, function($vehicle){
            return $vehicle->getParkLocation === $this->location->getCoordinates();
        });

        return $result;
    }

    public function isPartOfMyFleet() {
        return $this->vehicle->getFleetId() === $this->fleet->getId();
    }








}
