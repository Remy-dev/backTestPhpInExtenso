<?php
namespace App\Domain\Entities;

use App\Domain\Traits\Hydrator;

/**
 * Class Fleet
 * @package App\Domain\Entities
 */
class Fleet {
    private $id = 0;
    private $user;
    private $vehicles = [];

    use Hydrator;

    public function __construct(array $datas){
        $this->hydrate($datas);
    }


    public function getUser(){
        return $this->user;
    }

    public function setVehicles(array $vehicles){
        $this->vehicles = $vehicles;
    }

    public function setUser($user){
        $this->user = $user;
    }

    public function getId(){
       return $this->id;
    }
    public function setId($id){
        $this->id = (int) $id;
    }





}
