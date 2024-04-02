<?php
// Check if group name is provided
if (isset($_GET['group_name'])) {
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

    // Prepare and execute SQL query to fetch supervisors for the selected group
    $groupName = $_GET['group_name'];
    $sql = "SELECT id, fname FROM supervisor WHERE group_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $groupName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch supervisors as an associative array
    $supervisors = array();
    while ($row = $result->fetch_assoc()) {
        $supervisors[] = $row;
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($supervisors);

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // No group name provided, return empty response
    echo json_encode([]);
}
?>
