<?php

namespace App\App;

use App\Domain\Entities\Fleet;
use App\Domain\Entities\Vehicle;
use App\Domain\Models\FleetManager;
use App\Domain\Models\LocationManager;
use App\Domain\Models\VehicleManager;
use App\Domain\ValueObject\Location;

/**
 * Class ParkController
 * @package App\App
 */
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

    /**
     * @return Fleet
     */
    public function getFleet() {
        return $this->fleet;
    }

    /**
     * @return Vehicle
     */
    public function getVehicle() {
        return $this->vehicle;
    }

    /**
     * @return Location
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getErrorMessage() {
        return $this->errorMessage;
    }

    /**
     * @param Fleet $fleet
     */
    public function setFleet(Fleet $fleet){
        $this->fleet = $fleet;
    }

    /**
     * @param Vehicle $vehicle
     */
    public function setVehicle(Vehicle $vehicle){
        $this->vehicle = $vehicle;
    }

    /**
     * @param $id
     * @return $this
     */
    public function initialiseFleet($id): ParkController
    {
       $this->fleet = new Fleet($this->fleetManager->find($id));
       return $this;
    }

    /**
     * @param ParkController $controller
     * @return $this
     */
    public function registerVehicle(ParkController $controller): ParkController
    {
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

    /**
     * @param ParkController $controller
     * @return $this
     */
    public function isRegistered(ParkController $controller): ParkController
    {
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

    /**
     * @param ParkController $controller
     * @return $this
     */
    public function registerVehicleIntoFleet(ParkController $controller): ParkController
    {

        $this->vehicle = $controller->getVehicle();
        $this->fleet = $controller->getFleet();
        $this->vehicle->setFleetId($this->fleet->getId());
        $this->vehicleManager->updateVehicle($this->vehicle);
        return $this;
    }

    /**
     * @param ParkController $controller
     * @return $this
     */
    public function parkVehicle(ParkController $controller): ParkController
    {
            $vehicle = $controller->getVehicle();
            $vehicle->setParkLocation($controller->getLocation()->getCoordinates());
            $this->vehicleManager->updateVehicle($vehicle);
            $this->errorMessage = '';
            return $this;
    }

    /**
     * @param ParkController $controller
     * @return $this
     */
    public function isParked(ParkController $controller): ParkController
    {
        $checkedVehicule = $this->vehicleManager->find($controller->getVehicle()->getRegistration());
        if($checkedVehicule->getParkLocation() === $controller->getLocation()->getCoordinates()) {
            $this->errorMessage = '';
            return $this;
        } else {
            $this->errorMessage = self::NOT_PARKED;
            return $this;
        }
    }


    /**
     * @param $location
     * @return $this
     */
    public function registerLocation($location): ParkController
    {

        $this->location = new Location();
        $this->location->setCoordinates($location);
        $this->locationManager->addLocation($location);
        return $this;
    }

    /**
     * @param ParkController $controller
     * @return $this
     */
    public function checkLocation(ParkController $controller): ParkController
    {

        $vehicle = $this->vehicleManager->find($controller->getVehicle()->getRegistration());
        if($vehicle->getParkLocation() === $this->location->getCoordinates()) {
            $this->errorMessage = '';
            return $this;
        } else {
            $this->errorMessage = self::ERROR_LOCATION;
            return $this;
        }
    }

    /**
     * @return int
     */
    public function onPark(): int
    {

        if($this->vehicle->getParkLocation() === $this->location->getCoordinates()){
           return self::ALREADY_PARKED;
        } else {
            return self::NOT_PARKED;
        }

    }

    /**
     * @param ParkController $controller
     * @return $this
     */
    public function isLocationAlreadyUsed (ParkController $controller): ParkController
    {
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

    /**
     * @param ParkController $controller
     * @return $this
     */
    public function isPartOfMyFleet(ParkController $controller): ParkController {
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


