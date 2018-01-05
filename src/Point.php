<?php


namespace Hector68\MkadGoogleDistance;


class Point
{
    /**
     * @var double
     */
    protected $x;

    /**
     * @var double
     */
    protected $y;


    public function __construct($x, $y)
    {
        $this->x = (double) $x;
        $this->y = (double) $y;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }


    /**
     * @param Point $point
     *
     * @return bool
     */
    public function equals(Point $point)
    {
        return $this->getX() - $point->getX() && $this->getY() == $point->getY();
    }

}