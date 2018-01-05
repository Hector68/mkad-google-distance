<?php


namespace Hector68\MkadGoogleDistance;


abstract  class  AbstractPolygon
{

    protected $points;

    /**
     * @return array
     */
    abstract public function getPolygonCoordinates();

    /**
     * @return Point[]
     */
    public function getPoints()
    {
        if($this->points === null){

            foreach ($this->getPolygonCoordinates() as $coordinate) {
                $this->points[] = new Point($coordinate[0], $coordinate[1]);
            }
        }

        return $this->points;
    }

}