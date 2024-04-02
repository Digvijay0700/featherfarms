<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $farmerId = $_POST['farmer'];
    $batchId = $_POST['batchId']; // Corrected variable name
    $totalBirds = $_POST['totalBirds']; // Corrected variable name
    $date = $_POST['date'];
    $mortality = $_POST['mortality'];
    $feedReceived = $_POST['feedReceivedAmount'];
    $feedConsumption = $_POST['feedConsumption'];
    $feedBalance = $_POST['feedBalance'];
    $feedPerBird = $_POST['feedPerBird'];
    $actualBirdWeight = $_POST['actualBirdWeight'];
    $fcr = $_POST['fcr'];
    $remarks = $_POST['remarks'];
    $receiptFilePath = ""; // Initialize receipt file path

    // Check if feed received is 'yes'
    if ($_POST['feedReceivedSelect'] === 'yes') {
        // Handle file upload for feed receipt
        if (isset($_FILES["receiptFile"]) && $_FILES["receiptFile"]["error"] == UPLOAD_ERR_OK) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["receiptFile"]["name"]);
            if (move_uploaded_file($_FILES["receiptFile"]["tmp_name"], $targetFile)) {
                $receiptFilePath = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        } else {
            echo "No file uploaded.";
            exit;
        }
    }

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "featherfarms");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query
    $sql = "INSERT INTO daily_records (id, batch_id, total_birds, date, mortality, feed_received, feed_consumption, feed_balance, feed_per_bird, actual_bird_weight, fcr, remarks, feed_receipts) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters and execute query
        $stmt->bind_param("iisssssssssss", $farmerId, $batchId, $totalBirds, $date, $mortality, $feedReceived, $feedConsumption, $feedBalance, $feedPerBird, $actualBirdWeight, $fcr, $remarks, $receiptFilePath);
        $stmt->execute();
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
