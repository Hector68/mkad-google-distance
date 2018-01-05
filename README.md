# Библиотека помогает определить расстояние до МКАД
... или других объектов
### Использование
### Через Google APi
```
  $provider = new GoogleDistanceProvider($key);
            $mkad         = new MkadPolygon();
            $pointOutMkad = new Point(55.731727, 36.851284);
            $distance = DistanceHelper::getDistance($pointOutMkad, $mkad, $provider);
            $this->assertTrue($distance > 0);
            $pointInMkad = new Point(55.705485, 37.673276);
            $distance    = DistanceHelper::getDistance($pointInMkad, $mkad, $provider);
            $this->assertTrue($distance === 0);
```
### Определять расстояние напрямую
```
 $provider = new DirectDistanceProvider();
        $mkad         = new MkadPolygon();
        $pointOutMkad = new Point(55.731727, 36.851284);
        $distance = DistanceHelper::getDistance($pointOutMkad, $mkad, $provider);
        $this->assertTrue($distance > 0);
        $pointInMkad = new Point(55.705485, 37.673276);
        $distance    = DistanceHelper::getDistance($pointInMkad, $mkad, $provider);
        $this->assertTrue($distance === 0);
```
