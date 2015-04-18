<?php

namespace Maalls\Google\Geocoding\Test;
use Maalls\Google\Geocoding\Geocoding;

class SubmissionTest extends \PHPUnit_Framework_TestCase
{

    public function testAddress() {

        $geocoding = new Geocoding("AIzaSyB53r-5YexxquSN0O7BDhwWrYoVbrxIzOA");

        $response = json_decode($geocoding->address("75014, France"));

        $result = $response->results[0];
        var_dump($result);
        $this->assertEquals('OK', $response->status);
        $this->assertEquals('48.8314408', $result->geometry->location->lat);
        $this->assertEquals('2.3255684', $result->geometry->location->lng);

        list($lat, $lng) = $geocoding->latlng("75014, France");

        $this->assertEquals('48.8314408', $lat);
        $this->assertEquals('2.3255684', $lng);

    }

}