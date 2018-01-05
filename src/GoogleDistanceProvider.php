<?php


namespace Hector68\MkadGoogleDistance;


class GoogleDistanceProvider extends AbstractDistanceProvider
{


    private $token;


    protected $apiUrl = 'https://maps.googleapis.com/maps/api/directions/json';


    public function __construct($token)
    {
        $this->token = $token;
    }


    protected function createApiQuery(Point $point1, Point $point2)
    {
        $queryArray = [
            'origin'      => $point1->getX() . ',' . $point1->getY(),
            'destination' => $point2->getX() . ',' . $point2->getY(),
            'key'         => $this->token
        ];

        return $this->apiUrl . '?' . http_build_query($queryArray);
    }

    /**
     * @param Point           $point1
     * @param AbstractPolygon $polygon
     *
     * @return bool|int
     */
    protected function getGoogleApiData(Point $point1, AbstractPolygon $polygon)
    {
        $coord = $polygon->getPolygonCoordinates();
        $centroid = array_reduce( $coord, function ($x,$y) use ($coord) {
            $len = count($coord);
            return [$x[0] + $y[0]/$len, $x[1] + $y[1]/$len];
        }, array(0,0));


        if ( $point2 = new Point($centroid[0], $centroid[1])) {

            $query = $this->createApiQuery($point1, $point2);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $query);
            $resultJson = curl_exec($ch);
            curl_close($ch);

            if (empty($resultJson) === false) {
                $result = json_decode($resultJson, true);

                if ($result['status'] === 'OK' && isset($result['routes'][0]['legs'][0]['steps'])) {

                    $distance = 0;
                    $steps    = $result['routes'][0]['legs'][0]['steps'];

                    foreach ($steps as $step) {

                        $distance += $step['distance']['value'];

                        if (
                        DistanceHelper::pointInPolygon(
                            new Point(
                                $step['end_location']['lat'],
                                $step['end_location']['lng']
                            ),
                            $polygon
                        )
                        ) {
                            break;
                        }
                    }

                    return $distance;

                }



            }
        }

        return false;
    }


    /**
     * @param Point           $point
     * @param AbstractPolygon $polygon
     *
     * @return int|false
     */
    public function getDistance(Point $point, AbstractPolygon $polygon)
    {

        return $this->getGoogleApiData($point, $polygon);

    }
}