<?php

// base class with member properties and methods
class Vegetable {

   public static $edible='assaf';
   var $color;
   private $taste;

   function Vegetable($edible, $color="green") 
   {
       $this->edible = $edible;
       $this->color = $color;
       $this->blarg = $this->foo();
   }

   function is_edible() 
   {
       return $this->edible;
   }

   function what_color() 
   {
       return $this->color.$this->foo();
   }
   private function foo(){
    return 'foo';
   }
   function blahh(){
    echo self::$edible;
   }
   
} 

$veggie = new Vegetable(true, "blue");
echo "public var edible: [".$veggie->edible."]\n";
echo "public var color: [".$veggie->color."]\n";
echo "public method: [".$veggie->is_edible()."]\n";
echo "public method calling private method: [".$veggie->what_color()."]\n";
// echo "private method: [".$veggie->foo()."]\n";
echo "private method: [".$veggie->blarg."]\n";
echo "class vars: [".$veggie->blahh()."]\n";

