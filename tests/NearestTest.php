<?php


namespace Hector68\MkadGoogleDistance\Tests;

use Hector68\MkadGoogleDistance\DistanceHelper;
use Hector68\MkadGoogleDistance\MkadPolygon;
use Hector68\MkadGoogleDistance\Point;

class NearestTest extends \PHPUnit_Framework_TestCase
{
    public function addDataProvider()
    {
        return [
            [55.693893, 37.381225, 55.702805, 37.397952],
            [55.570831, 37.717510, 55.583983, 37.709425],
        ];
    }


    /**
     * @dataProvider addDataProvider
     */
    public function testNearest($x1, $y1, $x2, $y2)
    {
        $point = new Point($x1, $y1);

        $polygon = new MkadPolygon();

        $nearestPointPolygon = DistanceHelper::getNearestPolygonPoint($point, $polygon);



        $this->assertTrue($nearestPointPolygon->getX() == $x2 && $nearestPointPolygon->getY() == $y2);
    }

}