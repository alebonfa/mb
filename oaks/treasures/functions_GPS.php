<?php
    function distancia($p1LA, $p1LO, $p2LA, $p2LO) {
        $earthRadius = 6372.795477598;
        $latFrom = deg2rad($p1LA);
        $lonFrom = deg2rad($p1LO);
        $latTo = deg2rad($p2LA);
        $lonTo = deg2rad($p2LO);
  
        $lonDelta = $lonTo - $lonFrom;
          $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
          $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

          $angle = atan2(sqrt($a), $b);
          return $angle * $earthRadius * 1000;
    }
?>