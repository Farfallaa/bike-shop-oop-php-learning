<?php
/**
 * Created by PhpStorm.
 * User: farfa
 * Date: 09/11/2018
 * Time: 14:44
 */

class DatabaseObject
{
static protected $database;
static protected $table_name = "";
static protected $columns = [];
public $errors = [];


    static public function set_database($database){
        self::$database = $database;
    }

    //this is an all purpose function to pass in
    //any sql and perform a query for that class
    //from the database.
    static public function find_by_sql($sql){
        $result = self::$database->query($sql);
        if(!$result){
            exit("Database query failed.");
        }
        //before we turn query into result we want to
        //convert the results into objects:
        //1. start with an empty array:
        $object_array = [];
        //do a while loop that itterates through the whole table
        //row by row and while doing it Im calling a function
        //instantiate
        while($record = $result->fetch_assoc()){
            $object_array[] = static::instantiate($record);
        }

        $result->free();

        return $object_array;

    }

    static public function find_all(){
        $sql = "SELECT * FROM ".static::$table_name;
        return static::find_by_sql($sql);
    }

    static public function find_by_id($id){
        $sql = "SELECT * FROM ".static::$table_name. " ";
        $sql .= "WHERE id ='". self::$database->escape_string($id) . "'";
        $obj_array = static::find_by_sql($sql);
        if(!empty($obj_array)){
            return array_shift($obj_array);
            //array shift shifts (takes) first value of the array
            //turns it to an object and returns it back
        }
        else{
            return false;
        }

    }

    static protected function instantiate($record){
        $object = new static;//this object has properties from the class bellow
        //could manually assign values to properties
        //but automatic assignment is going to be
        //faster easier and re-usable.
        //$property => value is the way this associative
        //array is returned. First goes property and then
        //values so for each cell there is a property-value pair
        foreach($record as $property => $value){
            if(property_exists($object, $property)){
                $object->$property = $value;
            }
        }
        return $object;
    }

    protected function validate(){
        $this->errors = [];

        //add custom validations

        return $this->errors;
    }

    //updated create function:
    protected function create(){
        $this->validate();
        //validate will fill the class variable with errors
        //so you can continue only if there are no errors:
        if(!empty($this->errors)){
            return false;
        }
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO ".static::$table_name." (";
        $sql .= join(', ', array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        $result = self::$database->query($sql);
        //get an id of a newly created entry:
        if($result){
            $this->id = self::$database->insert_id;
        }
        return $result;//returns true or false
    }


    protected function update(){
        $this->validate();
        //validate will fill the class variable with errors
        //so you can continue only if there are no errors:
        if(!empty($this->errors)){
            return false;
        }
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = [];
        foreach($attributes as $key => $value){
            //e.g. brand = 'ereliukas';
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE ".static::$table_name. " SET ";
        $sql .= join(', ', $attribute_pairs);
        $sql .= " WHERE id='".self::$database->escape_string($this->id)."' ";
        $sql .= "LIMIT 1";
        $result = self::$database->query($sql);
        return $result;
    }

    //Save will be a function that can be used instead of create and update:
    public function save(){
        //a new record will not have an id yet.
        //so check if there is an id or not:

        if(isset($this->id)){
            return $this->update();
        }
        else{
            return $this->create();
        }
    }

    //fill in the object with properties from the form:
    public function merge_attributes($args=[]){
        //we wanna go through each of the args that
        //are being passed in
        //we wanna update the properties
        //of this object accordingly
        foreach($args as $key=>$value){
            if(property_exists($this, $key) && !is_null($value)){
                //e.g. $this->>brand
                //e.g. $this->>year etc each time different
                //as  the property is dynamic each time
                //and taken from the arguments of the object
                //array.
                $this->$key = $value;
                //after we finish running through this we
                //know we have an object with its properties
                //updated from the form values. we then need to
                //save this updated object to the database
                //so we write the update function.
            }
        }

    }

    //method that allows us to loop through
    //the object columns and checks if they
    //have a property
    //so create this attributes function
    //that is an associative array
    //that has both the key and the value.
    //key being a column list for object
    //and values being form values
    //properties which have database columns, excluding ID
    public function attributes(){
        $attributes = [];
        foreach (static::$db_columns as $column){
            if($column == 'id'){
                continue;
            }
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    //function to sanitize the values
    protected function sanitized_attributes(){
        $sanitized = [];
        foreach($this->attributes() as $key => $value){
            //return same key but sanitized value for each of the
            //keys in string:
            $sanitized[$key] = self::$database->escape_string($value);
        }
        return $sanitized;
    }

    public function delete(){
        $sql = "DELETE FROM ".static::$table_name. " ";
        $sql .= "WHERE id='".self::$database->escape_string($this->id)."' ";
        $sql .= "LIMIT 1";
        $result = self::$database->query($sql);
        return $result;
        //after deleting the instance of the object
        //will still exist even though the database record
        //does not.
        //This can be useful as in:
        //echo $user->first_name."was deleted.";
        //but, for example, we cant call $user->update() aftar
        //calling $user->delete.
    }

}