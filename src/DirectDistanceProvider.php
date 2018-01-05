<?php


namespace Hector68\MkadGoogleDistance;


class DirectDistanceProvider extends AbstractDistanceProvider
{
    /**
     * @param Point           $point
     * @param AbstractPolygon $polygon
     *
     * @return int|false
     */
     public function getDistance(Point $point, AbstractPolygon $polygon)
     {
         if($nearestPoint = DistanceHelper::getNearestPolygonPoint($point, $polygon))
         {
             return DistanceHelper::getDirectDistance($point, $nearestPoint);
         }

         return false;
     }
}