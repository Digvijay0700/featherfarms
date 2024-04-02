<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $farmer_id = $_POST['farmer']; // Assuming 'farmer' is the name attribute of the select input for farmer
    $total_birds = $_POST['totalBirds']; // Assuming 'totalBirds' is the name attribute of the input for total birds
    
    // Get the current date
    $assignment_date = date("Y-m-d H:i:s"); // Current date and time in YYYY-MM-DD HH:MM:SS format

    // Validate form data (you may add more validation as per your requirements)

    // Perform database insertion
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
    $stmt = $conn->prepare("INSERT INTO batches (farmer_id, total_birds, assignment_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $farmer_id, $total_birds, $assignment_date);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "<script>alert('Batch Assigned successfully');</script>";
        echo "<script>window.location.href = 'admin_panel.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
