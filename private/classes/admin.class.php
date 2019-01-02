<?php

class Admin extends DatabaseObject {

  static protected $table_name = "admins";
  static protected $db_columns = ['id', 'first_name', 'last_name', 'email', 'username', 'hashed_password'];

  public $id;
  public $first_name;
  public $last_name;
  public $email;
  public $username;
  protected $hashed_password;
  public $password;
  public $confirm_password;
  protected $password_required = true;

  public function __construct($args=[]) {
    $this->first_name = $args['first_name'] ?? '';
    $this->last_name = $args['last_name'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->username = $args['username'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->confirm_password = $args['confirm_password'] ?? '';
  }

  public function full_name() {
    return $this->first_name . " " . $this->last_name;
  }

  protected function set_hashed_password(){
    $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
  }
  //overwriting the original create and update functions from object class
    //to be able to include password hashing before doing any of those
    // actions::
  protected function create(){
      $this->set_hashed_password();
      return parent::create();


  }

  protected function update(){
      if($this->password != ''){
          //validate password if password is entered in the form
          $this->set_hashed_password();
      } else {
        //meaning that the password is not in the form:
          //skip hashing and validation
       $this->password_required = false;
      }
      //if the password is not required (e.g. user
      //already has password and so the
      //form contains an empty string, we dont
      //then want to hash the empty strings so we
      //need to add check here as well:
      return parent::update();
  }
    //before creating or updating bicycle class check and see if its valid:
    //the method should add any errors to errors array:
  protected function validate() {
        $this->errors = [];

        if(is_blank($this->first_name)) {
            $this->errors[] = "First name cannot be blank.";
        } elseif (!has_length($this->first_name, array('min' => 2, 'max' => 255))) {
            $this->errors[] = "First name must be between 2 and 255 characters.";
        }

        if(is_blank($this->last_name)) {
            $this->errors[] = "Last name cannot be blank.";
        } elseif (!has_length($this->last_name, array('min' => 2, 'max' => 255))) {
            $this->errors[] = "Last name must be between 2 and 255 characters.";
        }

        if(is_blank($this->email)) {
            $this->errors[] = "Email cannot be blank.";
        } elseif (!has_length($this->email, array('max' => 255))) {
            $this->errors[] = "Last name must be less than 255 characters.";
        } elseif (!has_valid_email_format($this->email)) {
            $this->errors[] = "Email must be a valid format.";
        }

        if(is_blank($this->username)) {
            $this->errors[] = "Username cannot be blank.";
        } elseif (!has_length($this->username, array('min' => 5, 'max' => 255))) {
            $this->errors[] = "Username must be between 8 and 255 characters.";
        }
        //check if the username is unique and if its not unique add in errors:
          elseif(!has_unique_username($this->username, $this->id ?? 0)){
              $this->errors[] = "We already have this username in the database. Try another username.";
          }
        //only validate password if the password is passed in the form:
        if($this->password_required) {
            if (is_blank($this->password)) {
                $this->errors[] = "Password cannot be blank.";
            } elseif (!has_length($this->password, array('min' => 5))) {
                $this->errors[] = "Password must contain 12 or more characters";
            } elseif (!preg_match('/[A-Z]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 uppercase letter";
            } elseif (!preg_match('/[a-z]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 lowercase letter";
            } elseif (!preg_match('/[0-9]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 number";
            } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 symbol";
            }
            if (is_blank($this->confirm_password)) {
                $this->errors[] = "Confirm password cannot be blank.";
            } elseif ($this->password !== $this->confirm_password) {
                $this->errors[] = "Password and confirm password must match.";
            }
        }

        return $this->errors;
    }

  static public function find_by_username($username){
      $sql = "SELECT * FROM ".static::$table_name. " ";
      $sql .= "WHERE username ='". self::$database->escape_string($username) . "'";
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
}

?>
