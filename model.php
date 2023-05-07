<?php

// Require the "database.php" file that defines the "Database" class
require_once "database.php";

// Enable all error reporting
error_reporting(E_ALL|E_STRICT);

// Define a new class named "Entry" that extends the "Database" class
class Entry extends Database {
    // Define a constructor method that calls the parent constructor
    public function __construct() {
      parent::__construct();
    }
  
    // Define a method named "create" that inserts a new entry into the "entries" table
    public function create($first_name, $last_name, $phone_number) {
      // Build the SQL query string with the input data
      $sql = "INSERT INTO entries (first_name, last_name, phone_number) VALUES ('$first_name', '$last_name', '$phone_number')";
  
      // Execute the query using the mysqli_query() function and return true if successful, false otherwise
      if (mysqli_query($this->connection, $sql)) {
        return true;
      } else {
        return false;
      }
    }
  
    // Define a method named "search" that searches for entries in the "entries" table based on a phone number input
    public function search($numbers) {
        
        // Define a mapping between numbers and letters on a phone keypad
        $keypad_map = array(
            '2' => 'ABC', '3' => 'DEF', '4' => 'GHI',
            '5' => 'JKL', '6' => 'MNO', '7' => 'PQRS',
            '8' => 'TUV', '9' => 'WXYZ'
        );
    
        // Define a helper function named "generate_names" that generates all possible names for a given phone number
        function generate_names($number, $keypad_map, $current_name = '')
        {
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
    
        // Generate all possible names for the input number using the "generate_names" function
        $names = generate_names($numbers, $keypad_map);

        // Build an array of "LIKE" expressions based on the generated names and the "first_name" and "last_name" fields
        foreach ($names as $name) {
            $likeExpressions[] = "first_name LIKE '$name%' OR last_name LIKE '$name%'";
        }
        
        // Join the "LIKE" expressions with "OR" to create the "WHERE" clause of the SQL query
        $whereClause = implode(' OR ', $likeExpressions);
        
        // Build the SQL query string using the "WHERE" clause and execute the query using the mysqli_query() function
        $sql = "SELECT * FROM entries WHERE $whereClause";
        $result = mysqli_query($this->connection, $sql);
    
        // Build an array of entries based on the query results and return it
        $entries = array();
    
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $entries[] = $row;
          }
          return $entries;
        }
      }
  }
?>