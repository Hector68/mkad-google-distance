<?php


namespace Hector68\MkadGoogleDistance\Tests;

use Hector68\MkadGoogleDistance\DirectDistanceProvider;
use Hector68\MkadGoogleDistance\DistanceHelper;
use Hector68\MkadGoogleDistance\GoogleDistanceProvider;
use Hector68\MkadGoogleDistance\MkadPolygon;
use Hector68\MkadGoogleDistance\Point;

class DistanceTest extends \PHPUnit_Framework_TestCase
{

    public function testGoogleApi()
    {

        if (is_file(__DIR__ . '/.google_api_key.php')) {
            $key = require(__DIR__ . '/.google_api_key.php');

            $provider = new GoogleDistanceProvider($key);

            $mkad         = new MkadPolygon();
            $pointOutMkad = new Point(55.731727, 36.851284);

            $distance = DistanceHelper::getDistance($pointOutMkad, $mkad, $provider);

            $this->assertTrue($distance > 0);

            $pointInMkad = new Point(55.705485, 37.673276);
            $distance    = DistanceHelper::getDistance($pointInMkad, $mkad, $provider);
            $this->assertTrue($distance === 0);
        }
    }


    public function testDirectApi()
    {
        $provider = new DirectDistanceProvider();

        $mkad         = new MkadPolygon();
        $pointOutMkad = new Point(55.731727, 36.851284);

        $distance = DistanceHelper::getDistance($pointOutMkad, $mkad, $provider);

        $this->assertTrue($distance > 0);

        $pointInMkad = new Point(55.705485, 37.673276);
        $distance    = DistanceHelper::getDistance($pointInMkad, $mkad, $provider);
        $this->assertTrue($distance === 0);
    }

}