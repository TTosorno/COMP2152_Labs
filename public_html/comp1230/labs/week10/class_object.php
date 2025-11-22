<?php
//TOPIC 1: Classes and Objects
//3 P's for variables: Public, Private, Protected
//SYNTAX => class className{}
//Example: Person
class Person{
    public $name; //accessible everywhere
    private $age; // not accessible
    protected $address; // not accessible
    //2. Create the constructor method
    //to assign values to vars
    //Keyword: this
    //SYNTAX => __construct(vars/args){}
    public function __construct($name,$age,$address){
        $this->name = $name;
        $this->age = $age;
        $this->address = $address;
    }
    //3. Create a function to display the vars
    public function displayInfo(){
        echo "Name: ".$this->name."<br>";
        echo "Age: ".$this->age."<br>";
        echo "Address: ".$this->address."<br>";


    }
}
//Calling by using "new"
$person = new Person("Noela", 22,"Toronto");
$person->displayInfo();
echo $person->name;
show_source(__FILE__);
//echo $person->address; //Cannot access protected property Person::address