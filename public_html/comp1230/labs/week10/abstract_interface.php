<?php
//abstract class
//

echo "<h2> Abstract constructor</h2>";
abstract class AnimalClass{
    abstract public function sound();
    public function breathe(){
        echo"animal is alive<br>";
    }
}
class Dog extends AnimalClass{
    public function sound(){
        echo"barks<br>";
    }
}
$dog = new Dog();
$dog->sound();
$dog->breathe();
class Cat extends AnimalClass
{
    public function sound()
    {
        echo "cat meows<br>";
    }
}
$cat = new Cat();
$cat->sound();
$cat->breathe();
echo "<h2> interface </h2>";
//syntax interface interfacename
interface ShapeInterface{
    public function area();
}
class circle implements ShapeInterface{
    public $radius;
    publc function __construct($radius){
        $this->radius = $radius;
}
    public function area(){
        return pi()*$this->radius*$this->radius;
    }
}
$circle = new Circle(5);
echo $circle->area();
show_source(__FILE__);

