<?php
session_start();
include 'header.php';
include 'db.php';

$id=$_SESSION['attorney']['id'];
                ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TheFirm - Accepted Cases</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Law Firm Case Management" name="keywords">
    <meta content="Case Management System for Law Firms" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS (Bootstrap 5) -->
<!-- Include Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/accases.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .session-card { margin-bottom: 20px; }
    </style>
    
</head>
<body>


<?php
$caseid = $_GET['id'];
$sql1 = "SELECT * FROM `session` WHERE caseid='$caseid' ORDER BY id DESC";
$res1 = $conn->query($sql1);

if ($row1 = $res1->fetch_assoc()) { 
    $sessionid = $row1['id'];
?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="addhistory.php" method="post">
            <input type="hidden" name="sessionid" value="<?= htmlspecialchars($sessionid); ?>">
            <input type="hidden" name="caseid" value="<?= htmlspecialchars($caseid); ?>">
        
                <div class="mb-3">
                    <label for="details" class="form-label fw-bold">Session Details</label>
                    <textarea name="details" id="details" rows="5" class="form-control" placeholder="Write session details here..."></textarea>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                
            </form>
        </div>
    </div>
</div>

<?php
}

$sql2 = "SELECT * FROM `session` WHERE caseid='$caseid' ";
$res2 = $conn->query($sql2);
if($res2->num_rows > 0) {
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="sessionTable">
                    <thead>
                        <tr>
                            <th>Session's number</th>
                            <th>Details</th>
                            <th>Session's Date</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $t=0;
while ($row2 = $res2->fetch_assoc()) {
    $t++;
    $sessionid=$row2['id'];

$sql3 = "SELECT * FROM `history` WHERE sessionid='$sessionid' ";
$res3 = $conn->query($sql3);
while ($row3 = $res3->fetch_assoc()) {

                        ?>
                       <tr>
                        <td><?= $t ; ?></td>

                        <td><?= $row3['content'] ; ?></td>
                          
                        <td><?= $row2['date'] ; ?></td>

                       </tr>
                    </tbody>
                    <?php
                     }
                    }
                } else {
                    ?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="sessionTable">
                    <thead>
                        <tr>
                            <th>Session's number</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       <tr>
                        <td></td>

                        <td></td>
                          
                        <td>

                        
                        </td>
                       </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php

                }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>






</body>                