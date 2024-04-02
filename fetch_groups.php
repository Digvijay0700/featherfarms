<?php
// Define database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "featherfarms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute SQL query to fetch all groups
$sql = "SELECT DISTINCT group_name FROM groups"; // Assuming the table name is 'groups'
$result = $conn->query($sql);

// Check if query execution was successful
if ($result) {
    // Fetch results as an associative array
    $groups = array();
    while ($row = $result->fetch_assoc()) {
        $groups[] = $row;
    }
    
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($groups);
} else {
    echo "Error fetching groups: " . $conn->error;
}

// Close connection
$conn->close();
?>
