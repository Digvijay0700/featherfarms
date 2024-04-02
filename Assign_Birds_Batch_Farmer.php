<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assign Birds</title>
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
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            Assign Birds
          </div>
          <div class="card-body">
            <form action="add_birds_batch.php" method="post">
              <div class="form-group">
                <label for="group">Select Group</label>
                <select class="form-control" id="group" name="group" onchange="fetchSupervisors()">
                  <option value="">Select Group</option>
                  <!-- Group options will be fetched dynamically -->
                </select>
              </div>

              <div class="form-group">
                <label for="supervisor">Select Supervisor</label>
                <select class="form-control" id="supervisor" name="supervisor" onchange="fetchFarmers()">
                  <option value="">Select Supervisor</option>
                  <!-- Supervisor options will be fetched dynamically based on the selected group -->
                </select>
              </div>

              <div class="form-group">
                <label for="farmer">Select Farmer</label>
                <select class="form-control" id="farmer" name="farmer">
                  <option value="">Select Farmer</option>
                  <!-- Farmer options will be fetched dynamically based on the selected supervisor -->
                </select>
              </div>

              <div class="form-group">
                <label for="totalBirds">Total Birds</label>
                <input type="text" class="form-control" id="totalBirds" name="totalBirds" placeholder="Enter total number of birds">
              </div>

        
              <button type="submit" class="btn btn-primary">Assign</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function fetchGroups() {
      var groupDropdown = document.getElementById("group");
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "fetch_groups.php", true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            var groups = JSON.parse(xhr.responseText);
            groups.forEach(function(group) {
              var option = document.createElement("option");
              option.text = group.group_name;
              option.value = group.group_name; // Assuming 'group_name' is the identifier for each group
              groupDropdown.add(option);
            });
          } else {
            console.error("Failed to fetch groups: " + xhr.status);
          }
        }
      };
      xhr.send();
    }

    function fetchSupervisors() {
      var groupDropdown = document.getElementById("group");
      var selectedGroup = groupDropdown.value;
      var supervisorDropdown = document.getElementById("supervisor");
      supervisorDropdown.innerHTML = '<option value="">Select Supervisor</option>';

      if (selectedGroup !== "") {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "fetch_supervisor.php?group_name=" + encodeURIComponent(selectedGroup), true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              var supervisors = JSON.parse(xhr.responseText);
              supervisors.forEach(function(supervisor) {
                var option = document.createElement("option");
                option.text = supervisor.fname;
                option.value = supervisor.id; // Assuming 'id' is the identifier for each supervisor
                supervisorDropdown.add(option);
              });
            } else {
              console.error("Failed to fetch supervisors: " + xhr.status);
            }
          }
        };
        xhr.send();
      }
    }

    function fetchFarmers() {
      var supervisorDropdown = document.getElementById("supervisor");
      var selectedSupervisor = supervisorDropdown.value;
      var farmerDropdown = document.getElementById("farmer");
      farmerDropdown.innerHTML = '<option value="">Select Farmer</option>';

      if (selectedSupervisor !== "") {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "fetch_farmer.php?supervisor_id=" + encodeURIComponent(selectedSupervisor), true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              var farmers = JSON.parse(xhr.responseText);
              farmers.forEach(function(farmer) {
                var option = document.createElement("option");
                option.text = farmer.fname;
                option.value = farmer.id; // Assuming 'id' is the identifier for each farmer
                farmerDropdown.add(option);
              });
            } else {
              console.error("Failed to fetch farmers: " + xhr.status);
            }
          }
        };
        xhr.send();
      }
    }

    // Fetch groups when the page loads
    fetchGroups();
  </script>
</body>
</html>
