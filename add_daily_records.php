<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Farmer</title>
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
          Select Farmer
        </div>
        <div class="card-body">
          <form action="insert_daily_records.php" method="post" enctype="multipart/form-data" onsubmit="return submitForm()">
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
            <div class="form-group">
            <label for="totalBirds">Total Birds</label>
             <input type="text" class="form-control" id="totalBirds" name="totalBirds" readonly>
            </div>

            <div class="form-group">
              <label for="feedReceived">Feed Received</label>
              <select class="form-control" id="feedReceivedSelect" name="feedReceivedSelect" onchange="toggleFeedReceivedInput()">
                <option value="no">No</option>
                <option value="yes">Yes</option>
              </select>
            </div>
            <div class="form-group" id="feedReceivedInput" style="display: none;">
              <label for="feedReceivedAmount">Feed Received Amount (kg)</label>
              <input type="number" step="0.01" class="form-control" id="feedReceivedAmount" name="feedReceivedAmount">
            </div>
            <div class="form-group" id="uploadReceipt" style="display: none;">
              <label for="receiptFile">Upload Receipt</label>
              <input type="file" class="form-control-file" id="receiptFile" name="receiptFile">
            </div>
            <!-- Rest of the form fields -->
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
              </div>
              <div class="form-group">
                <label for="mortality">Mortality</label>
                <input type="number" class="form-control" id="mortality" name="mortality" required>
              </div>
              <div class="form-group">
                <label for="feedConsumption">Feed Consumption (kg)</label>
                <input type="number" step="0.01" class="form-control" id="feedConsumption" name="feedConsumption" required>
              </div>
              <div class="form-group">
                <label for="feedBalance">Feed Balance (kg)</label>
                <input type="number" step="0.01" class="form-control" id="feedBalance" name="feedBalance" required>
              </div>
              <div class="form-group">
                <label for="feedPerBird">Feed Per Bird (g)</label>
                <input type="number" step="0.01" class="form-control" id="feedPerBird" name="feedPerBird" required>
              </div>
              <div class="form-group">
                <label for="actualBirdWeight">Actual Bird Weight (kg)</label>
                <input type="number" step="0.01" class="form-control" id="actualBirdWeight" name="actualBirdWeight" required>
              </div>
              <div class="form-group">
                <label for="fcr">FCR</label>
                <input type="number" step="0.01" class="form-control" id="fcr" name="fcr" required>
              </div>
              <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
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
            document.getElementById("totalBirds").value = batchDetails.total_birds;
          } else {
            console.error("Failed to fetch batch details: " + xhr.status);
          }
        }
      };
      xhr.send();
    }
  }

  function toggleFeedReceivedInput() {
    var feedReceivedSelect = document.getElementById("feedReceivedSelect");
    var feedReceivedInput = document.getElementById("feedReceivedInput");
    var uploadReceipt = document.getElementById("uploadReceipt");

    if (feedReceivedSelect.value === "yes") {
      feedReceivedInput.style.display = "block";
      uploadReceipt.style.display = "block";
    } else {
      feedReceivedInput.style.display = "none";
      uploadReceipt.style.display = "none";
    }
  }
  function submitForm() {
    // Validate form fields
    var feedReceivedSelect = document.getElementById("feedReceivedSelect").value;
    var feedReceivedAmount = document.getElementById("feedReceivedAmount").value;

    if (feedReceivedSelect === "yes" && feedReceivedAmount === "") {
      alert("Please enter the feed received amount.");
      return false; // Prevent form submission
    }

    // Form is valid, submit the form
    return true;
  }

</script>
</body>
</html>
