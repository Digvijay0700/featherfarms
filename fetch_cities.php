<?php
// Database connection parameters
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

// SQL query to fetch cities
$sql = "SELECT id, name FROM cities";
$result = $conn->query($sql);

// Check if query executed successfully
if ($result && $result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
    }
} else {
    echo '<option value="">No cities found</option>';
}

// Close connection
$conn->close();
?>
