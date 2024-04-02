<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve supervisor ID
    $supervisor_id = $_POST['username'];

    // Retrieve form data
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $taluka = $_POST['taluka'];
    $village = $_POST['village'];
    $poultry_size = $_POST['poultry_size'];
    $adhar_number = $_POST['adhar_number'];
    $pan_number = $_POST['pan_number'];
    $group_name = $_POST['group_name'];

    // File upload paths
    $poultry_photo_path = 'uploads/' . basename($_FILES['poultry_photo']['name']);
    $adhar_photo_path = 'uploads/' . basename($_FILES['adhar_photo']['name']);
    $pan_photo_path = 'uploads/' . basename($_FILES['pan_photo']['name']);
    $farmer_photo_path = 'uploads/' . basename($_FILES['farmer_photo']['name']);

    // Move uploaded files to destination folder
    move_uploaded_file($_FILES['poultry_photo']['tmp_name'], $poultry_photo_path);
    move_uploaded_file($_FILES['adhar_photo']['tmp_name'], $adhar_photo_path);
    move_uploaded_file($_FILES['pan_photo']['tmp_name'], $pan_photo_path);
    move_uploaded_file($_FILES['farmer_photo']['tmp_name'], $farmer_photo_path);

    // Database connection
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

    // Prepare SQL statement to insert farmer data into database
    $sql = "INSERT INTO farmers (fname, mname, lname, dob, mobile, email, taluka, village, poultry_size, poultry_photo, adhar_number, adhar_photo, pan_number, pan_photo, farmer_photo, group_name, supervisor_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssss", $fname, $mname, $lname, $dob, $mobile, $email, $taluka, $village, $poultry_size, $poultry_photo_path, $adhar_number, $adhar_photo_path, $pan_number, $pan_photo_path, $farmer_photo_path, $group_name, $supervisor_id);
    
    if ($conn->query($sql) === TRUE) {
        // Fetch the ID of the inserted farmer
        $farmer_id = $conn->insert_id;
        $username = $farmer_id;
        $password =  $mobile;
    
    
        $user_sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'farmer')";
        $user_stmt = $conn->prepare($user_sql);
        $user_stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        echo "<script>alert('Farmer added successfully');</script>";
        echo "<script>window.location.href = 'supervisor_panel.php?username=" . $_POST['username'] . "';</script>";

    } else {
        echo "Error adding supervisor to users table: " . $user_stmt->error;
    }
} else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>