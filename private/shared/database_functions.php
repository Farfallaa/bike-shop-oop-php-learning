<?php
/**
 * Created by PhpStorm.
 * User: farfa
 * Date: 02/10/2018
 * Time: 22:13
 */

//open connectoin and confirm if there are no errors:
function db_connect(){
    $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    confirm_db_connect($connection);
    return $connection;
}

function confirm_db_connect($connection){
    if($connection->connect_errno){
        $msg = "Database connection failed";
        $msg .= $connection->connect_error;
        $msg .= " (". $connection->connect_errno. ")";
        exit($msg);
    }
}

function db_disconnect($connection){
    if(isset($connection)){
        $connection->close();
    }
}

