<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Farmer</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
</head>
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
</style>
<body>

<div class="container mt-5">
<div class="p-4 rounded bg-light">
  <h2 class="mb-4">Add Farmer</h2>
  <form action="submit_farmer.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="username" value="<?php echo isset($_GET['username']) ? $_GET['username'] : ''; ?>">
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="fname">First Name</label>
        <input type="text" class="form-control" id="fname" name="fname" required>
      </div>
      <div class="form-group col-md-4">
        <label for="mname">Middle Name</label>
        <input type="text" class="form-control" id="mname" name="mname">
      </div>
      <div class="form-group col-md-4">
        <label for="lname">Last Name</label>
        <input type="text" class="form-control" id="lname" name="lname" required>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="dob">Date of Birth</label>
        <input type="date" class="form-control" id="dob" name="dob" required>
      </div>
      <div class="form-group col-md-4">
        <label for="mobile">Mobile Number</label>
        <input type="text" class="form-control" id="mobile" name="mobile" required>
      </div>
      <div class="form-group col-md-4">
        <label for="email">Email Address</label>
        <input type="email" class="form-control" id="email" name="email">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="taluka">Taluka</label>
        <select class="form-control" id="taluka" name="taluka" required>
          <option value="Shirur">Shirur</option>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="village">Village</label>
        <select class="form-control" id="village" name="village" required>
          <!-- Fetch villages from database dynamically -->
          <?php
          echo $username1;
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

          // Fetch villages from database
          $sql = "SELECT name FROM cities";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
              echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
            }
          } else {
            echo "<option>No villages found</option>";
          }
          $conn->close();
          ?>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="poultry_size">Poultry Size</label>
        <input type="text" class="form-control" id="poultry_size" name="poultry_size" required>
      </div>
    </div>
    <div class="form-group">
      <label for="poultry_photo">Poultry Photograph</label>
      <input type="file" class="form-control-file" id="poultry_photo" name="poultry_photo" required>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="adhar_number">Adhar Card Number</label>
        <input type="text" class="form-control" id="adhar_number" name="adhar_number" required>
      </div>
      <div class="form-group col-md-4">
        <label for="adhar_photo">Adhar Card Photo</label>
        <input type="file" class="form-control-file" id="adhar_photo" name="adhar_photo" required>
      </div>
      <div class="form-group col-md-4">
        <label for="pan_number">PAN Card Number</label>
        <input type="text" class="form-control" id="pan_number" name="pan_number" required>
      </div>
    </div>
    <div class="form-group">
      <label for="pan_photo">PAN Card Photo</label>
      <input type="file" class="form-control-file" id="pan_photo" name="pan_photo" required>
    </div>
    <div class="form-group">
      <label for="farmer_photo">Farmer Photo</label>
      <input type="file" class="form-control-file" id="farmer_photo" name="farmer_photo" required>
    </div>
    <div class="form-group">
      <label for="group_name">Group Name</label>
      <select class="form-control" id="group_name" name="group_name" required>
        <!-- Fetch group names from database dynamically -->
        <?php
        // Replace database credentials with your own
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

        // Fetch group names from database
        $sql = "SELECT group_name FROM groups";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // Output data of each row
          while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["group_name"] . "'>" . $row["group_name"] . "</option>";
          }
        } else {
          echo "<option>No groups found</option>";
        }
        $conn->close();
        ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
