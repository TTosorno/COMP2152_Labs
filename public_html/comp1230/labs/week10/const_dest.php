<?php
//TOPIC 2: Constructor and destructor
//__construct(vars)
//__destruct()
class AnimalClass{
    public $name;

    public function __construct($name){
        $this->name = $name;
        echo "Constructor is created<br>";
    }
    //2nd way
    public function __destruct(){ //All vars
        unset($name); //only name is destroyed
        echo "constructor is destroyed<br>";
    }
}
//Calling using new
// SYNTAX => varName
$constructor = new AnimalClass("Dog");
echo $constructor->name."<br>";
//$constructor->name = "";
//$destructor = new AnimalClass();
show_source(__FILE__);