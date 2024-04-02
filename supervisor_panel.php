<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Supervisor Dashboard</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      padding: 0;   
      background-image: url('https://www.stabilitamerica.com/wp-content/uploads/2021/08/Livestock-Roofing-Cladding-1024x682.jpg');
      background-repeat: no-repeat;
      background-size: cover;
      background-attachment: fixed;
    }
    .card-container {
      position: relative;
      height: 400px;
      padding: 0;
    }
    .card {
      margin-top: 30px;
      height: 190px;
      margin-bottom: 50px;
    }
    .card-title {
      text-align: center;
    }
    .center-btn {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
    .card-title {
      display: flex;
      margin-top: 20px;
      font-size: 30px;
      justify-content: center;
    }
    #btn1 {
      font-size: 20px;
    }
    #btn2 {
      font-size: 20px;
    }
    #btn3 {
      font-size: 20px;
    }
    #btn4 {
      font-size: 20px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<?php
          session_start();
          if(isset($_GET['username'])) {
            $username1 = $_GET['username']; // Retrieve username from URL parameter
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "featherfarms";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }
            // Prepare and execute SQL query to fetch supervisor details
            $stmt = $conn->prepare("SELECT fname FROM supervisor WHERE id = ?");
            if (!$stmt) {
              die("Error preparing statement: " . $conn->error);
            }
            $stmt->bind_param("s", $username1); // Bind the parameter to the statement
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $supervisor_name = $row["fname"];
              // Display supervisor name and ID
              echo "<a class='navbar-brand' href='#'>Hello $supervisor_name [$username1]</a>";
            } else {
              echo "Supervisor not found!";
            }
            // Close statement and connection
            $stmt->close();
            $conn->close();
          } else {
            // Handle case when username is not provided
            echo "Username not provided!";
          }
        ?>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="navbar-brand">
        
      </li>
    </ul>
  </div>
</nav>

<div class="container card-container">
  <div class="row">
    <div class="col-md-6">
      <!-- Card 1 -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Daily Records</h5>
          <div class="center-btn">
            <button type="submit" id="btn1" class="btn btn-primary" onclick="redirectToPage('add_daily_records.php?username=<?php echo $username1; ?>')">Add</button>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="card">
  <div class="card-body">
    <h5 class="card-title">Add Farmers</h5>
    <div class="center-btn">
      <button type="button" id="btn3" class="btn btn-primary" onclick="redirectToPage('add_farmer.php?username=<?php echo $username1; ?>')">ADD</button>
    </div>
  </div>
</div>

      <!-- Card 3 -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Manage Visits</h5>
          <div class="center-btn">
            <button type="submit" id="btn2" class="btn btn-primary">Change</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-6">
      <!-- Card 4 -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">View Reports</h5>
          <div class="center-btn">
            <button type="submit" id="btn3" class="btn btn-primary" onclick="redirectToPage('View_daily_records_supp.php?username=<?php echo $username1; ?>')">View</button>
          </div>
        </div>
      </div>
      <!-- Card 5 -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">View Supervisors Attendance</h5>
          <div class="center-btn">
            <button type="submit" id="btn4" class="btn btn-primary">View</button>
          </div>
        </div>
      </div>
      <!-- Card 6 -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Change Batch</h5>
          <div class="center-btn">
            <button type="submit" id="btn4" class="btn btn-primary">Change</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    function redirectToPage(page) {
      window.location.href = page; // Redirect to the specified page
    }
  </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
