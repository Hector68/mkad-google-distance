<?php


namespace Hector68\MkadGoogleDistance;


abstract class AbstractDistanceProvider
{

    /**
     * @param Point           $point
     * @param AbstractPolygon $polygon
     *
     * @return int|false
     */
    abstract public function getDistance(Point $point, AbstractPolygon $polygon);


}