<?php




class Vehicle {

    private $registration = '';
    private $type = '';
    private $fleetId = '';
    private $parkLocation = '';
    private $isParked = false;

    use Hydrator;

    public function __construct(array $datas)
    {
        $this->hydrate($datas);
    }

    public function getRegistration(){
        return $this->registration;
    }

    public function getType() {
        return $this->type;
    }

    public function getFleetId() {
        return $this->fleetId;
    }

    public function getParkLocation(){
        return $this->parkLocation;
    }

    public function setRegistration($registration){
        if(empty($registration) || null === $registration){
            throw new \InvalidArgumentException('Exception error : vehicle must have valid registration number');
        }
        $this->registration = $registration;

    }

    public function setType($type){
        if(is_string($type)){
            $this->type = $type;
        }
    }

    public function setFleetId($id){
        if(!empty($id)){
            $this->fleetId = $id;
        }
    }

    public function setParkLocation($location){
        $this->parkLocation = $location;
    }


    public function isParked(){
        return !empty($this->parkLocation);
    }
}
