<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Daily Records</title>
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
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          View Daily Records
        </div>
        <div class="card-body">
          <form action="" method="post">
            <div class="form-group">
              <label for="farmer">Select Farmer</label>
              <select class="form-control" id="farmer" name="farmer" onchange="fetchBatchDetails()">
                <option value="">Select Farmer</option>
                <?php
                // Check if the 'username' parameter exists and is not empty
                if (isset($_GET['username']) && !empty($_GET['username'])) {
                  // Assuming 'username' contains supervisor ID
                  $supervisorId = intval($_GET['username']);

                  // Connect to your database
                  $conn = new mysqli("localhost", "root", "", "featherfarms");

                  // Check the connection
                  if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                  }

                  // Fetch farmers associated with the supervisor
                  $sql = "SELECT id, fname FROM farmers WHERE supervisor_id = ?";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("i", $supervisorId);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  // Display the list of farmers
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['fname'] . "</option>";
                  }

                  // Close the database connection
                  $stmt->close();
                  $conn->close();
                }
                ?>
              </select>
            </div>
            <div class="form-group">
             <label for="batchId">Batch ID</label>
               <input type="text" class="form-control" id="batchId" name="batchId" readonly>
            </div>
            <!-- Rest of the form fields -->
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Display table for daily records -->
  <div class="row justify-content-center mt-5">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">
          Daily Records
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Total Birds</th>
                  <th>Daily Mortality</th>
                  <th>Cum Mortality</th>
                  <th>Mortality Percentage</th>
                  <th>Feed Received</th>
                  <th>Daily Consumption</th>
                  <th>Cum Consumption</th>
                  <th>Feed Balance (kg)</th>
                  <th>Feed Per Bird (g)</th>
                  <th>Actual Bird Weight (kg)</th>
                  <th>FCR</th>
                  <th>Remarks</th>
                </tr>
              </thead>
              <tbody>
              <?php 

// Function to fetch daily records based on batch ID
function fetchDailyRecords($batchId) {
    // Connect to your database
    $conn = new mysqli("localhost", "root", "", "featherfarms");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL query to fetch daily records
    $sql = "SELECT * FROM daily_records WHERE batch_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $batchId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Array to store daily records
    $dailyRecords = array();

    // Fetch and store daily records
    while ($row = $result->fetch_assoc()) {
        $dailyRecords[] = $row;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    return $dailyRecords;
}

// Assuming this PHP file is included in the main script
// You can call this function where you want to display daily records
// For example, within the HTML form section

// Check if the form is submitted
 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['batchId'])) {
   $batchId = $_POST['batchId'];

   // Fetch daily records based on the submitted batch ID
   $dailyRecords = fetchDailyRecords($batchId);

   // Display daily records in the table
   foreach ($dailyRecords as $record) {
     echo "<tr>";
     echo "<td>" . $record['date'] . "</td>";
     echo "<td>" . $record['total_birds'] . "</td>";
     echo "<td>" . $record['mortality'] . "</td>";
     echo "<td>" . $record['feed_received'] . "</td>";
     echo "<td>" . $record['feed_consumption'] . "</td>";
     echo "<td>" . $record['feed_balance'] . "</td>";
     echo "<td>" . $record['feed_per_bird'] . "</td>";
     echo "<td>" . $record['actual_bird_weight'] . "</td>";
     echo "<td>" . $record['fcr'] . "</td>";
     echo "<td>" . $record['remarks'] . "</td>";
     echo "</tr>";
   }
 }
 ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function fetchBatchDetails() {
    var farmerDropdown = document.getElementById("farmer");
    var selectedFarmer = farmerDropdown.value;
    if (selectedFarmer !== "") {
      // Make AJAX request to fetch active batch details of the selected farmer
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "fetch_batch_details.php?farmer_id=" + encodeURIComponent(selectedFarmer), true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            var batchDetails = JSON.parse(xhr.responseText);
            document.getElementById("batchId").value = batchDetails.batch_id;
            // Make the Batch ID field readonly
            document.getElementById("batchId").setAttribute("readonly", true);
          } else {
            console.error("Failed to fetch batch details: " + xhr.status);
          }
        }
      };
      xhr.send();
    }
  }
</script>

</body>
</html>
