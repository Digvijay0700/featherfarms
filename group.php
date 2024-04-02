<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO groups (group_name, city, village, created_at) VALUES (?, ?, ?, ?)");

    // Check if statement preparation failed
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Initialize variables with form data
    $group_name = $_POST["groupName"];
    $city = $_POST["Taluka"];
    $village = $_POST["village"];
    $created_at = date("Y-m-d H:i:s");

    // Bind parameters to statement
    $stmt->bind_param("ssss", $group_name, $city, $village, $created_at);

    // Check if parameter binding failed
    if (!$stmt) {
        die("Error binding parameters: " . $stmt->error);
    }

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "<script>alert('Group Created Successfully'); window.location='admin_panel.html';</script>";
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
