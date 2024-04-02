<?php
// Check if the farmer ID is provided
if (isset($_GET['farmer_id']) && !empty($_GET['farmer_id'])) {
    // Get the selected farmer ID
    $farmerId = intval($_GET['farmer_id']);

    // Connect to your database
    $conn = new mysqli("localhost", "root", "", "featherfarms");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch active batch details for the selected farmer
    $sql = "SELECT batch_id, total_birds FROM batches WHERE farmer_id = ? AND batch_status = 'active'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $farmerId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a batch is found
    if ($result->num_rows > 0) {
        $batchDetails = $result->fetch_assoc();

        // Close the database connection
        $stmt->close();
        $conn->close();

        // Return batch details as JSON response
        header('Content-Type: application/json');
        echo json_encode($batchDetails);
    } else {
        // If no active batch is found, return an empty response
        echo json_encode(array());
    }
} else {
    // If no farmer ID is provided, return an empty response
    echo json_encode(array());
}
?>
