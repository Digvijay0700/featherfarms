<?php 
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "featherfarms";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to authenticate user
function authenticateUser($username, $password) {
    global $conn;

    $username = sanitize($username);
    $password = sanitize($password);

    // Query to fetch user from database
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        return $user; // Return user details if found
    } else {
        return false; // Return false if user not found
    }
}

// Example usage
$username = $_POST['username']; // Assuming username is sent via POST request
$password = $_POST['password']; // Assuming password is sent via POST request

$user = authenticateUser($username, $password);

if ($user) {
    // User authenticated successfully
    switch ($user['role']) {
        case 'admin':
            // Redirect admin to admin panel
            header("Location: admin_panel.html");
            break;
        case 'supervisor':
            // Store supervisor details in session
            $_SESSION['supervisor'] = $user;
            // Redirect supervisor to supervisor panel with username passed as a query parameter
            header("Location: supervisor_panel.php?username=$username");
            break;
        case 'farmer':
            // Redirect farmer to farmer panel
            header("Location: farmer_panel.php");
            break;
        default:
            // Redirect to a default page if role is not recognized
            header("Location: default_panel.php");
            break;
    }
} else {
    // Authentication failed, display error message using JavaScript alert
    echo "<script>alert('Invalid username or password'); window.location='login.html';</script>";
}

$conn->close();
?>
