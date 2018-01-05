<?php

namespace Hector68\MkadGoogleDistance\Tests;

use Hector68\MkadGoogleDistance\DistanceHelper;
use Hector68\MkadGoogleDistance\MkadPolygon;
use Hector68\MkadGoogleDistance\Point;


class MkadInOutTest extends \PHPUnit_Framework_TestCase
{


    public function addDataProvider()
    {
        return [
            [55.785685, 37.422590, true],
            [52.728229, 41.395246, false],
            [55.901482, 37.511668, false],
            [55.898733, 37.512955, true],
            [55.658425, 37.842986, false]
        ];
    }

    /**
     * @dataProvider addDataProvider
     */
    public function testMkad($x, $y, $result)
    {
        $point = new Point($x, $y);

        $polygon = new MkadPolygon();

        $this->assertEquals(DistanceHelper::pointInPolygon($point, $polygon), $result);
    }


    public function testVertex()
    {
        $point = new Point(55.702805, 37.397952);

        $polygon = new MkadPolygon();

        $this->assertTrue(DistanceHelper::pointInPolygon($point, $polygon));
    }
}