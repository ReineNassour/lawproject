<?php
include 'headerM.php'; 
include 'db.php';
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Attorney Contract</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .contract-form {
            max-width: 700px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .form-title {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
            color: #343a40;
        }

        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="contract-form">
    <h3 class="form-title">New Attorney Contract</h3>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="salary" class="form-label">Salary ($)</label>
            <input type="number" class="form-control" id="salary" name="salary" required min="0">
        </div>

        <div class="mb-3">
            <label for="nbofhour" class="form-label">Number of Hours</label>
            <input type="number" class="form-control" id="nbofhour" name="nbofhour" required min="0">
        </div>

        <div class="mb-3">
            <label for="startdate" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="startdate" name="startdate" required>
        </div>

        <div class="mb-3">
            <label for="enddate" class="form-label">End Date</label>
            <input type="date" class="form-control" id="enddate" name="enddate" required>
        </div>

        <div class="mb-3">
            <label for="details" class="form-label">Contract Details</label>
            <textarea class="form-control" id="details" name="details" rows="5" required></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Create Contract</button>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    $salary = $_POST['salary'];
    $nbofhour = $_POST['nbofhour'];
    $start = $_POST['startdate'];
    $end = $_POST['enddate'];
    $details = $_POST['details'];

    $stmt = $conn->prepare("INSERT INTO attcontract (salary, nbofhour, startdate, enddate, details) 
    VALUES
     ('$salary', '$nbofhour', '$start', '$end', '$details')");
    $stmt->bind_param("iisss", $salary, $nbofhour, $start, $end, $details);

    if ($stmt->execute()) {
        echo "<script>alert('Contract created successfully'); window.location.href='attorney_contract.php';</script>";
    } else {
        echo "<script>alert('Failed to create contract');</script>";
    }

    $stmt->close();
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
