<?php

namespace Utilities\Service;

class Time {

    public function hourDifference($firstTime,$lastTime) {
        $firstTime=strtotime($firstTime);
        $lastTime=strtotime($lastTime);
        $timeDiff=$lastTime-$firstTime;//in seconds
        return $timeDiff/60/60;//in hours
    }

}
