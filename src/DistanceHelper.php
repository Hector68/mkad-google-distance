<?php


namespace Hector68\MkadGoogleDistance;


class DistanceHelper
{


    /**
     * @param Point           $point
     * @param AbstractPolygon $polygon
     * @param bool            $pointOnBoundary
     *
     * @return bool
     */
    public static function pointInPolygon(
        Point $point,
        AbstractPolygon $polygon,
        $pointOnBoundary = true
    ) {
        $vertices = $polygon->getPoints();
        // Check if the point sits exactly on a vertex

        foreach ($vertices as $varPoint) {
            if ($point->equals($varPoint)) {
                return true;
            }
        }

        // Check if the point is inside the polygon or on the boundary
        $intersections  = 0;
        $vertices_count = count($vertices);
        for ($i = 1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i - 1];
            $vertex2 = $vertices[$i];
            if ($vertex1->getY() == $vertex2->getY()
                && $vertex1->getY() == $point->getY()
                && $point->getX() > min($vertex1->getX(), $vertex2->getX())
                && $point->getX() < max($vertex1->getX(), $vertex2->getX())
            ) {
                // Check if point is on an horizontal polygon boundary
                return $pointOnBoundary ? true : false;
            }
            if ($point->getY() > min($vertex1->getY(), $vertex2->getY())
                && $point->getY() <= max($vertex1->getY(), $vertex2->getY())
                && $point->getX() <= max($vertex1->getX(), $vertex2->getX())
                && $vertex1->getY() != $vertex2->getY()
            ) {
                $xinters =
                    ($point->getY() - $vertex1->getY()) * ($vertex2->getX() - $vertex1->getX())
                    / ($vertex2->getY() - $vertex1->getY())
                    + $vertex1->getX();
                if ($xinters == $point->getX()) {
                    // Check if point is on the polygon boundary (other than horizontal)
                    return $pointOnBoundary ? true : false;
                }
                if ($vertex1->getX() == $vertex2->getX() || $point->getX() <= $xinters) {
                    $intersections++;
                }
            }
        }
        // If the number of edges we passed through is even, then it's in the polygon.
        if ($intersections % 2 != 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param Point $point1
     * @param Point $point2
     *
     * @return int
     */
    public static function getDirectDistance(Point $point1, Point $point2)
    {

        if (($point1->getX() == $point2->getX()) && ($point1->getY() == $point2->getY())) {
            return 0;
        } // distance is zero because they're the same point
        $p1 = deg2rad($point1->getX());
        $p2 = deg2rad($point2->getX());
        $dp = deg2rad($point2->getX() - $point1->getX());
        $dl = deg2rad($point2->getY() - $point1->getY());
        $a  = (sin($dp / 2) * sin($dp / 2)) + (cos($p1) * cos($p2) * sin($dl / 2) * sin($dl / 2));
        $c  = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $r  = 6371008; // Earth's average radius, in meters
        $d  = $r * $c;

        return $d; // distance, in meters
    }


    /**
     * @param Point           $point
     * @param AbstractPolygon $polygon
     *
     * @return Point|null
     */
    public static function getNearestPolygonPoint(Point $point, AbstractPolygon $polygon)
    {
        $result = null;
        if ($points = $polygon->getPoints()) {
            $distanceArray = [];
            foreach ($points as $pointPolygon) {
                $distanceArray[self::getDirectDistance($point, $pointPolygon)] = $pointPolygon;
            }

            $result = $distanceArray[min(array_keys($distanceArray))];
        }

        return $result;
    }


    public static function getDistance(Point $point, AbstractPolygon $polygon, AbstractDistanceProvider $provider)
    {
        return self::pointInPolygon($point, $polygon) ? 0 : $provider->getDistance($point, $polygon);

    }

}