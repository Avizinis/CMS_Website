<?php 

// changes array keys. to upper and makes them constant.
function const_key(&$array){
    foreach($array as $key => $value){
        $oldkey = $key;
        $newkey = strtoupper($key);
        $array[$newkey] = $array[$oldkey];
        unset($array[$oldkey]);
        define ($newkey, $value);
    }
}

?>