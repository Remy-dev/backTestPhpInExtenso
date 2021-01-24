<?php

class LocationManager {

    public function addLocation ($location) {
        $locationDatabase = file_get_contents(__DIR__.'/locations.json');
        $content = json_decode($locationDatabase, true);
        array_push($content['location'], $location);
        file_put_contents(__DIR__.'/locations.json', json_encode($content, JSON_PRETTY_PRINT));
    }

    public function updateLocation($location) {
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
