<?php
/**
 * Created by PhpStorm.
 * User: farfa
 * Date: 29/09/2018
 * Time: 18:46
 */
class ParseCSV{

    public static $delimiter = ',';
    private $filename;
    private $header;
    private $data = [];
    private $row_count = 0;

    //instantiate class and set its filename at the same time:
    public function __construct($filename='')
    {
       if($filename != ''){//if filename is not = nothing
           $this->file($filename);
           //call a function that is called file (below)
       }
    }
    //function to check if the file actually exists and is readable:
    public function file($filename){
        if(!file_exists($filename)){
            echo "File does not exist";
            return false;
        } elseif(!is_readable($filename)){
            echo "File is not readable";
            return false;
        }
        $this->filename = $filename;
        return true;
    }
//public function parse that takes the filename from above
//and return back the data from it.
    public function parse(){
        //check if the file has been set or not first:
        if(!isset($this->filename)){
            echo "File not set.";
            return false;
        }
        //clear any previous result:
        $this->reset();
        //start parsing:
        $file = fopen($this->filename, 'r');
        while(!feof($file)){ //while you dont reach the end of file
          $row = fgetcsv($file, 0, self::$delimiter);
          if($row ==[NULL]||$row === FALSE){
              continue; //dont mind if row is empty, just continue
          }
          //what happens if row is not a header:
            if(!$this->header){
              $this->header = $row;
            }
            //if you come accross header *usualy first row
            //then with array_combine function combine
            //the header with every piece of data into assoc
            //array
            else {
                $this->data[] = array_combine($this->header, $row);
                $this->row_count++;
            }
        }
        fclose($file);
        return $this->data;

        //fgetcsv returns a line from a file and parse it as
        //a comma delimited set of text
        //3arguments to pass: 1. file handle
        //2. length (unlimited is 0) and 3. delimiter usually comma.
        //it reads and parses line in file
        //and returns an array of fields.


    }

    //I have no way of getting to this data value and read it easily.
    //so I need another function:
    public function last_results(){
        return $this->data;
    }

    //I dont want anyone to access row count and be able to change it (set it)
    //but I want to be able to read it (to know it)
    //therefore I need a method that puts out the number
    //of rows:

    public function row_count(){
        return $this->row_count;
    }

    //if I call the parse function twice it adds up to the
    //data thats already there. Its not good so I need a
    //function that resets the values to emptyness
    //and I can use this function if I want to parse
    //data again from the same file:
    //btw I need to use this method in the parsing
    //method to clear any preset data just in case!
    private function reset(){
        $this->header = NULL;
        $this->data =[];
        $this->row_count = 0;
    }
}