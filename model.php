<?php

require_once "database.php";

error_reporting(E_ALL|E_STRICT);

class Entry extends Database {
    public function __construct() {
      parent::__construct();
    }
  
    public function create($first_name, $last_name, $phone_number) {
      $sql = "INSERT INTO entries (first_name, last_name, phone_number) VALUES ('$first_name', '$last_name', '$phone_number')";
  
      if (mysqli_query($this->connection, $sql)) {
        return true;
      } else {
        return false;
      }
    }
  
    public function search($numbers) {
      // $number = $numbers; 
      // function keypad_number_to_name($number) {
        // Define a mapping of numbers to letters
        $keypad_map = array(
            '2' => 'ABC', '3' => 'DEF', '4' => 'GHI',
            '5' => 'JKL', '6' => 'MNO', '7' => 'PQRS',
            '8' => 'TUV', '9' => 'WXYZ'
        );
    
        // All possible combinations of letters for the input number
        function generate_names($number, $keypad_map, $current_name = '') {
            // Base case: If the number is empty, add the current name to the list of names and return it
            if ($number === '') {
                return array($current_name);
            }
    
            // Recursive case: Generate all possible names for the current digit and the remaining digits
            $digit = $number[0];
            $letters = $keypad_map[$digit];
            $names = array();
            foreach (str_split($letters) as $letter) {
                $new_name = $current_name . $letter;
                $remaining_names = generate_names(substr($number, 1), $keypad_map, $new_name);
                $names = array_merge($names, $remaining_names);
            }
            return $names;
        }
    
        // Generate all possible names for the input number and return them
        $names = generate_names($numbers, $keypad_map);
    //     return $names;
    // }
    
    // $names = keypad_number_to_name($number);
      foreach($names as $val){
        $sql = "SELECT * FROM entries WHERE first_name LIKE '$val%' OR last_name LIKE '$val%'";
        $result = mysqli_query($this->connection, $sql);
    
        $entries = array();
    
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $entries[] = $row;
          }
          return $entries;
        }
      }
    }
  }
?>