<?php 
include '../db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Attorney Contract</title>
 <title>Kanun - Law Firm Website Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Law Firm Website Template" name="keywords">
        <meta content="Law Firm Website Template" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        
        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
  <!-- Add Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Add Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
      padding: 40px 0;
      margin: 0;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    h1 {
      color: #2c3e50;
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
      font-size: 2rem;
      position: relative;
      padding-bottom: 15px;
    }

    h1::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 4px;
      background: linear-gradient(to right, #007bff, #00c6ff);
      border-radius: 2px;
    }

    .form-group {
      margin-bottom: 25px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #34495e;
      font-weight: 500;
      font-size: 0.95rem;
    }

    .form-control {
      border: 2px solid #e9ecef;
      border-radius: 8px;
      padding: 12px 15px;
      height: auto;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    }

    textarea.form-control {
      min-height: 120px;
      resize: vertical;
    }

    .btn-submit {
      background: linear-gradient(45deg, #007bff, #00c6ff);
      border: none;
      color: white;
      padding: 12px 30px;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 500;
      width: 100%;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-submit:hover {
      background: linear-gradient(45deg, #0056b3, #007bff);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    .readonly-form .form-control {
      background-color: #f8f9fa;
      color: #495057;
      cursor: not-allowed;
    }

    .contract-status {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 30px;
      padding: 15px;
      border-radius: 8px;
      background-color: #e9ecef;
      border-left: 5px solid #007bff;
    }

    @media (max-width: 768px) {
      .container {
        padding: 20px;
        margin: 20px;
      }
      
      h1 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  
    <?php
    $id=$_GET['id'];

    $sql="SELECT * FROM `attcontract` where attid='$id'";
    $res=$conn->query($sql);
    $sql1="SELECT * FROM `user` where id='$id'";
    $res1=$conn->query($sql1);
    $row1=$res1->fetch_assoc();
    $fname=$row1['fname'];
    $lname=$row1['lname'];
    if($res->num_rows == 0){
    ?>
    <div class="container">
        <h1>Create Attorney Contract</h1>
        <div class="contract-status">
            <i class="fas fa-user-tie mr-2"></i>
            Initiating contract for <h5><?= htmlspecialchars($fname." ".$lname) ; ?></h5>
        </div>
        <form id="contractForm" method="POST" action="submitcontract.php">
            <div class="form-group">
                <label for="salary"><i class="fas fa-dollar-sign mr-2"></i>Salary:</label>
                <input type="number" class="form-control" id="salary" name="salary" required>
            </div>
            <input type="hidden" name="attid" value="<?= htmlspecialchars($id) ; ?>">
            
            <div class="form-group">
                <label for="start_date"><i class="fas fa-calendar-alt mr-2"></i>Start Date:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>

            <div class="form-group">
                <label for="expiry_date"><i class="fas fa-calendar-times mr-2"></i>Expiry Date:</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" 
                       min="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label for="nb_of_hour"><i class="fas fa-clock mr-2"></i>Number of Hours:</label>
                <input type="number" class="form-control" id="nb_of_hour" name="nb_of_hour" required>
            </div>

            <div class="form-group">
                <label for="details"><i class="fas fa-file-alt mr-2"></i>Contract Details:</label>
                <textarea class="form-control" id="details" name="details" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-file-signature mr-2"></i>Create Contract
            </button>
        </form>
    </div>
    <?php
    } else {
    ?>
    <div class="container">
        <h1>Existing Attorney Contract</h1>
        <div class="contract-status">
            <i class="fas fa-check-circle mr-2"></i>
            Contract already exists for <h5><?= htmlspecialchars($fname." ".$lname) ; ?></h5>
        </div>
        <form id="contractForm" class="readonly-form">
            <?php
            while($row=$res->fetch_assoc()){
                $salary=$row['salary'];
                $startdate=$row['startdate'];
                $expirydate=$row['expirydate'];
                $nbofhour=$row['nbofHour'];
                $details=$row['details'];
            ?>
            <div class="form-group">
                <label><i class="fas fa-dollar-sign mr-2"></i>Salary:</label>
                <input type="number" class="form-control" value="<?= htmlspecialchars($salary) ; ?>" readonly>
            </div>

            <div class="form-group">
                <label><i class="fas fa-calendar-alt mr-2"></i>Start Date:</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($startdate) ; ?>" readonly>
            </div>

            <div class="form-group">
                <label><i class="fas fa-calendar-times mr-2"></i>Expiry Date:</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($expirydate) ; ?>" readonly>
            </div>

            <div class="form-group">
                <label><i class="fas fa-clock mr-2"></i>Number of Hours:</label>
                <input type="number" class="form-control" value="<?= htmlspecialchars($nbofhour) ; ?>" readonly>
            </div>

            <div class="form-group">
                <label><i class="fas fa-file-alt mr-2"></i>Contract Details:</label>
                <textarea class="form-control" rows="4" readonly><?= htmlspecialchars($details) ; ?></textarea>
            </div>
            <?php
            }
            ?>
            <div style="text-align: center;">
            <a href="passedlawyers.php" class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>
    <?php
    }
    ?>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    document.getElementById("contractForm").addEventListener("submit", function(e) {
        const startDate = new Date(document.querySelector("[name='start_date']").value);
        const expiryDate = new Date(document.querySelector("[name='expiry_date']").value);

        if (expiryDate <= startDate) {
            e.preventDefault();
            alert("Expiry date must be after start date.");
        }
    });
    </script>
</body>
</html>
