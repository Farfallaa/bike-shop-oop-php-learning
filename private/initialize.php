<?php
  ob_start(); // turn on output buffering

  // session_start(); // turn on sessions if needed

  // Assign file paths to PHP constants
  // __FILE__ returns the current path to this file
  // dirname() returns the path to the parent directory
  define("PRIVATE_PATH", dirname(__FILE__));
  define("PROJECT_PATH", dirname(PRIVATE_PATH));
  define("PUBLIC_PATH", PROJECT_PATH . '/public');
  define("SHARED_PATH", PRIVATE_PATH . '/shared');

  // Assign the root URL to a PHP constant
  // * Do not need to include the domain
  // * Use same document root as webserver
  // * Can set a hardcoded value:
  // define("WWW_ROOT", '/~kevinskoglund/chain_gang/public');
  // define("WWW_ROOT", '');
  // * Can dynamically find everything in URL up to "/public"
  $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
  $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  define("WWW_ROOT", $doc_root);

  require_once('functions.php');
  require_once('status_error_functions.php');
  require_once('db_credentials.php');
  require_once ('shared/database_functions.php');
  require_once ('validation_functions.php');

//Load all classes in the directory class:
  foreach(glob('classes/*.class.php') as $file){
    require_once($file);//loop through all classes in class directory and require them all!
  }
  // Load class definitions manually

  // Autoload class definitions
//even though you are loading all classes it is still a
//good practice to have the autoload function as well:
function my_autoload($class){
    if(preg_match('/\A\w+\Z/', $class)){
      include('classes/'. $class . '.class.php');
    }
}
spl_autoload_register('my_autoload');

  //in initialize.php we need a variable $database
//and then in all other pages where we load this initialize.php
//I will be able to use database connection variable!.
//var database becomes an object that is initialized by calling a
//function db_connect
  $database = db_connect();
  //send this database connection to databaseobject class
  //by passing this connection as a variable in this function
  //set database. in such way the database object class and all
 //subsequent classes get to know
  //about the database connection.
  DatabaseObject::set_database($database);

?>
