<?php
// Check if supervisor ID is provided
if (isset($_GET['username']) && !empty($_GET['username'])) {
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

    // Prepare and execute SQL query to fetch farmers for the selected supervisor
    $supervisorId = $_GET['supervisor_id'];
    $sql = "SELECT id, fname FROM farmers WHERE supervisor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $supervisorId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch farmers as an associative array
    $farmers = array();
    while ($row = $result->fetch_assoc()) {
        $farmers[] = $row;
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($farmers);

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // No supervisor ID provided, return empty response
    echo json_encode([]);
}
?>
