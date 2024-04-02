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

    // Prepare and bind SQL statement to insert supervisor
    $stmt = $conn->prepare("INSERT INTO supervisor (fname, mname, lname, email, mobile, dob, photo, group_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Initialize variables with form data
    $fname = $_POST["fname"];
    $mname = isset($_POST["mname"]) ? $_POST["mname"] : "";
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $dob = $_POST["dob"];
    $photo = $_FILES["photo"]["name"];
    $group_id = $_POST["batch"]; // Get the selected group ID from the dropdown

    // Fetch the group name associated with the selected ID
    $group_name = "";
    $group_stmt = $conn->prepare("SELECT group_name FROM groups WHERE id = ?");
    $group_stmt->bind_param("i", $group_id);
    $group_stmt->execute();
    $group_result = $group_stmt->get_result();

    if ($group_result->num_rows > 0) {
        $row = $group_result->fetch_assoc();
        $group_name = $row["group_name"];
    } else {
        die("Error fetching group name: " . $conn->error);
    }

    // Close group statement
    $group_stmt->close();

    // Bind parameters to statement
    $stmt->bind_param("ssssssss", $fname, $mname, $lname, $email, $mobile, $dob, $photo, $group_name); // Use group name instead of group ID

    if (!$stmt) {
        die("Error binding parameters: " . $stmt->error);
    }

    // Execute SQL statement to insert supervisor
    if ($stmt->execute()) {
        // Get the ID generated for the inserted supervisor
        $supervisor_id = $stmt->insert_id;

        // Insert supervisor into the users table with supervisor ID as username
        $user_password = $mobile; // Set password as mobile number
        $user_sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'supervisor')";
        $user_stmt = $conn->prepare($user_sql);
        $user_stmt->bind_param("ss", $supervisor_id, $user_password);
        
        if ($user_stmt->execute()) {
            echo "<script>alert('Supervisor added successfully');</script>";
        } else {
            echo "Error adding supervisor to users table: " . $user_stmt->error;
        }
        
        // Close user statement
        $user_stmt->close();
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
