<?php 

function formatString($string) {
    return trim(str_replace('"', '', $string));
}

//FUNCTIONS TO CONVERT PLAIN SECONDS TO APPROPRIATE TIME EQUIVALENT
// 30 -> 30Sec
// 60 -> 1Min
// 65 -> 1Min 5Sec
//3599 -> 59Min

function formatSeconds($seconds){
    if($seconds < 60){
        $seconds_suffix = "Sec";
        $seconds = $seconds;
        return $seconds ."". $seconds_suffix;
    }elseif($seconds < 60 * 60) {
        $minut_suffix = "Min";
        $seconds_suffix = "Sec";
        $minut = floor($seconds / 60);
        $seconds = $seconds - ($minut * 60);
        return $minut ."". $minut_suffix . " " . $seconds . "" . $seconds_suffix;
    }elseif($seconds < 60 * 60 * 60) {
        $hour_suffix = "Hr";
        $minut_suffix = "Min";
        $seconds_suffix = "Sec";
        $hour = floor($seconds / 3600);
        $minut = floor(($seconds - ($hour * 3600)) / 60);
        $seconds = $seconds - (($hour * 3600) + ($minut * 60));

        if($seconds == 0){
            return $hour ."". $hour_suffix . " " . $minut . "" . $minut_suffix;
        }else {
            return $hour ."". $hour_suffix . " " . $minut . "" . $minut_suffix . " " . $seconds . "" . $seconds_suffix;
        }

    }

    
}

?>