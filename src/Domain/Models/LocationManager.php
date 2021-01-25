<?php

namespace App\Domain\Models;

use App\Domain\ValueObject\Location;

/**
 * Class LocationManager
 * @package App\Domain\Models
 */
class LocationManager {

    /**
     * @param string $location
     */
    public function addLocation ($location) {
        $locationDatabase = file_get_contents(__DIR__.'/locations.json');
        $content = json_decode($locationDatabase, true);
        $content['locations']['coordinates']= '';
        $content['locations']['coordinates'] = $location;
        file_put_contents(__DIR__.'/locations.json', json_encode($content, JSON_PRETTY_PRINT));
    }

    /**
     * @param Location $location
     */
    public function updateLocation(Location $location) {
        $locationDatabase = file_get_contents(__DIR__.'/locations.json');
        $content = json_decode($locationDatabase, true);


        foreach($content as $element)
        {
            if($element['coordinates'] === $location->getCoordinates()){

                $content[$element['coordinates']] = $location->getCoordinates();
            }
        }
        file_put_contents(__DIR__.'/locations.json', json_encode($content, JSON_PRETTY_PRINT));
    }



}
