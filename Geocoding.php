<?php

namespace Maalls\Google\Geocoding;

class Geocoding 
{
    
    protected $format = "json";
    protected $uri = "https://maps.googleapis.com/maps/api/geocode/";
    protected $key;

    public function __construct($key) {

        if(!$key) throw new \Exception("Key required.");
        $this->key = $key;

    }

    public function latlng($address) {

        $json = $this->address($address);
        $rsp = json_decode($json);

        if(!$rsp) throw new \Exception("Network issue while querying the google geocoding API.");

        if($rsp->status == "OK") {

            $location = $rsp->results[0]->geometry->location;

            return array($location->lat, $location->lng);

        }
        else {

            throw new \Exception("Invalid Gooogle geocoding API $this->key request: " . $rsp->status . " " . $json);

        }

    }

    public function address($address) {

        $parameters = array(
            "address" => $address
        );

        return $this->request($parameters);

    }

    public function setFormat($format) {

        $this->format = $format;

    }

    public function request($parameters) {

        $parameters["key"] = $this->key;

        $ch = curl_init($this->generateUri($parameters));

        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true
        ));

        $rsp = curl_exec($ch);

        return $rsp;

    }

    public function generateUri($parameters) {

        $base = $this->uri;

        return $base . $this->format . "?" . http_build_query($parameters);

    }

}