<?php
/**
 * Created by PhpStorm.
 * User: farfa
 * Date: 29/09/2018
 * Time: 08:37
 */
class Bicycle extends DatabaseObject {
    // -----START OF ACTIVE RECORD CODE ------
    //tell this class about the database connection so that
    //this connection would be available to every instance of this
    //class and to all of its subclasses:
    static protected $table_name = 'bicycles';
    static protected $db_columns = ['id', 'brand', 'model', 'year', 'category', 'color', 'gender', 'price', 'weight_kg', 'condition_id',
        'description'];



    // -----END OF ACTIVE RECORD CODE ------

    public $id;
    public $brand;
    public $model;
    public $year;
    public $category;
    public $color;
    public $description;
    public $gender;
    public $price;
    public $weight_kg;
    public $condition_id;

    const CATEGORIES = ['Road', 'Mountain','Hybrid', 'Cruiser', 'City', 'BMX'];
    const GENDERS = ['Mens', 'Womens', 'Unisex'];

    const CONDITION_OPTIONS = [
        1 => 'Beat up',
        2 => 'Decent',
        3 => 'Good',
        4 => 'Great',
        5 => 'Like New' ];

    public function __construct($args=[]){
        //$this->brand = isset($args['brand'])? $args['brand']: '';
        $this->brand = $args['brand'] ?? '';
        $this->model = $args['model']?? '';
        $this->year = $args['year'] ?? '';
        $this->category = $args['category']?? '';
        $this->color = $args['color'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->gender = $args['gender'] ?? '';
        $this->price = $args['price'] ?? 0;
        $this->weight_kg = $args['weight_kg'] ?? 0.0;
        $this->condition_id = $args['condition_id']?? 3;
    }
////Another pattern to set properties for a class:
//foreach($args as $k=>$v){
//        if(property_exists($this, $k)){
//            $this->$k = $v;
//}
//}

public function name(){
        return "{$this->brand} {$this->model} {$this->year}";
}

public function weight_kg(){
        return number_format($this->weight_kg, 2). 'kg';
        }
public function set_weight_kg($value){
        $this->weight_kg = floatval($value);
}

public function weight_lbs(){
        $weight_lbs = floatval($this->weight_kg) * 2.2046226218;
        return number_format($weight_lbs, 2) . 'lbs';
}

public function set_weight_lbs($value){
        $this->weight_kg = floatval($value)/2.2046226218;
}

public function condition(){
        if($this->condition_id > 0){
            return self::CONDITION_OPTIONS[$this->condition_id];
        }
        else{
            return "Unknown";
        }

}
    //before creating or updating bicycle class check and see if its valid:
    //the method should add any errors to errors array:
    protected function validate()
    {
        //before need to ensure that the array is empty! so
        //if by mistake is not empty, it resets itself to being
        //empty once this function is run.
        $this->errors = [];
        if(is_blank($this->brand)){
            $this->errors[] = "Brand cannot be blank.";
        }
        if(is_blank($this->model)){
            $this->errors[] = "Model cannot be blank.";
        }
        //add custom validations
        return $this->errors;

    }

}