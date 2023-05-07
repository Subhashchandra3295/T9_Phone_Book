<?php
require_once "model.php";
require_once "index.php";
$entry = new Entry();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["addcontact"]))
    {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $phone_number = $_POST["phone_number"];

        $result = $entry->create($first_name, $last_name, $phone_number);

        if ($result) {
            echo "Entry created successfully.";
            header ("location: index.php");
            exit();
        } else {
            echo "Error creating entry.";
        }
    }    
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["search"]))
    {
        $numbers = $_GET["numbers"];

        $results = $entry->search($numbers);

        if (!is_null($results) && count($results) > 0) {
            echo "<table>";
            echo "<tr><th>First Name</th><th>Last Name</th><th>Phone Number</th></tr>";

            foreach ($results as $result) {
            echo "<tr>";
            echo "<td>" . $result["first_name"] . "</td>";
            echo "<td>" . $result["last_name"] . "</td>";
            echo "<td>" . $result["phone_number"] . "</td>";
            echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No entries found.";
        }
    }
}
?>