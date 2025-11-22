<?php
//topic 4
// magic meth
class myclass {
    public function __call($name, $arguments){
        echo" name". $name. "<br>";
        echo "arguments:";
        print_r($arguments);
        echo "<br>";
    }
}
$call = new myclass();
$call->add(1,2);
$call -> getName("thommm");
$call -> calculate(1,2,3,4,5,6,7,8,9);
show_source(__FILE__);
