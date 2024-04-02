<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Group</title>
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
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Create New Group</h5>
        </div>
        <div class="card-body">
          <form action="group.php" method="post">
            <div class="form-group">
              <label for="groupName">Group Name</label>
              <input type="text" class="form-control" id="groupName" name="groupName" placeholder="Enter Group Name" required>
            </div>
            <div class="form-group">
                <label for="Taluka">Taluka</label>
                <select class="form-control" id="Taluka" name="Taluka">
                  <option value="">Select Taluka</option>
                  <option value="Shirur">Shirur</option>
                </select>
              </div>
            <div class="form-group">
              <label for="village">Village</label>
              <select class="form-control" id="village" name="village">
                <?php include 'fetch_cities.php'; ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Group</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
