<?php 
session_start();
include '../db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TheFirm - Case Management</title>
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

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/attindex.css" rel="stylesheet">

     <!-- Favicon -->
     <link rel="icon" href="img/favicon.ico" type="image/x-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Animation -->
<link href="lib/animate/animate.min.css" rel="stylesheet">

<!-- Carousel -->
<link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

<!-- Custom Styles -->
<link href="css/apply.css" rel="stylesheet">

<style>

   /* Ensure consistent box-sizing */
*,
*::before,
*::after {
    box-sizing: border-box;
}

/* Reduce padding and margin for the sections */
.form-section {
    padding: 20px 0;  /* Reduced vertical padding */
    margin-bottom: 20px; /* Reduced margin between sections */
}

/* Reducing margin for the .mb-4 class to reduce space between content blocks */
.mb-4 {
    margin-bottom: 10px; /* Reduced margin bottom */
}

/* Adjust padding for the .p-4 class to reduce padding inside content cards */
.p-4 {
    padding: 15px; /* Reduced padding inside content cards */
}

/* Reduce margin for the card elements */
.card {
    margin-bottom: 15px; /* Reduced space between cards */
}

/* Form container styles */
.form-container {
    background-color: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
}

/* Background color for .bg-light */
.bg-light {
    background-color: #f8f9fa !important;
}

/* Text primary color for section titles */
h4.text-primary {
    font-weight: 600;
}

/* Make each card in the sections identical */
.card-body,
.mb-4.p-4.bg-light.rounded.border.shadow-sm {
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 10px;  /* Reduced margin */
    border: 1px solid #ddd;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
}

/* Specific styles for divs inside both sections */
.p-3.bg-white.rounded.border {
    padding: 15px;
    background-color: #fff;
    border-radius: 8px;
    border: 1px solid #ddd;
}

/* Alert box for no cases found */
.alert-info {
    background-color: #d9edf7;
    color: #31708f;
    font-size: 16px;
}

/* Specific padding and background color for .p-3.bg-white */
.p-3.bg-white {
    background-color: #fff !important;
    font-size: 15px;
    border-radius: 8px;
}

</style>
    
</head>
<body>
    
<?php
include 'header.php';
$userid=$_GET['id'];
$sql1 = "SELECT * FROM `cv` WHERE userid='$userid'";
$res1 = $conn->query($sql1);
    $row1 = $res1->fetch_assoc();
    $cvid = $row1['id'];
    $univ = $row1['university'];
    $year = $row1['year'];
    $level= $row1['level'];
    $desc = $row1['description'];

    $sql = "SELECT * FROM `user` WHERE id='$userid'";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
$fname = $row['fname'];
$lname = $row['lname'];
$name= $fname . " " . $lname;
$img= $row['image'];

?>
<div style="text-align: center;">
    <h1><b>Professional Profile For : <?= $name ; ?></b></h1>
    <img src="../<?= $img ; ?>" class="img-fluid rounded-circle" style="max-width: 200px; height: auto; margin-top: 20px;">
</div>


<section class="form-section my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
            <div class="text-center mb-4">
            <h2 class="section-title">1.Reported Educational History</h2>
            </div>
                    <!-- Educational Background -->
                    <div class="mb-4 p-4 bg-light rounded border shadow-sm">
                        <h4 class="text-primary mb-3">🎓 Educational Background</h4>
                        <p><strong>University:</strong> <?= $univ; ?></p>
                        <p><strong>Graduation Year:</strong> <?= $year; ?></p>
                    </div>

                    <!-- Additional Qualifications -->
                    <div class="mb-4 p-4 bg-light rounded border shadow-sm">
                        <h4 class="text-primary mb-3">📜 Additional Qualifications</h4>
                        <p><strong>Certification Level:</strong></p>
                        <div class="p-3 bg-white rounded border"><?= nl2br($level); ?></div>
                    </div>

                    <!-- Interest in Learning -->
                    <div class="mb-4 p-4 bg-light rounded border shadow-sm">
                        <h4 class="text-primary mb-3">🚀 Learning & Career Growth</h4>
                        <p><strong>Interest in Further Learning:</strong></p>
                        <div class="p-3 bg-white rounded border"><?= nl2br($desc); ?></div>
                    </div>

                </div>
            </div>
        </div>
    
</section>

 <!-- Application 1 Content End -->

    <?php
$sql2 = "SELECT * FROM `casewon` WHERE cvid='$cvid'";
$res2 = $conn->query($sql2);
?>
<section class="form-section my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-4">
                    <h2 class="section-title">2.Reported Case History</h2>
                </div>

                <?php
                $t1 = 0;
                while ($row2 = $res2->fetch_assoc()) {
                    $t1++;
                    $year = $row2['year'];
                    $nbofcases = $row2['nbofcases'];
                    $desc = $row2['description'];
                ?>
                <div class="mb-4 p-4 bg-light rounded border shadow-sm">
                    <h4 class="text-primary mb-3">🎓 Case #<?= $t1 ?></h4>
                    <p><strong>Number of Cases:</strong> <?= $nbofcases ?></p>
                    <p><strong>Year:</strong> <?= $year ?></p>
                    <p><strong>Description:</strong></p>
                    <div class="p-3 bg-white rounded border"><?= nl2br(htmlspecialchars($desc)) ?></div>
                </div>
                <?php } ?>

                <?php if ($t1 === 0): ?>
                    <div class="alert alert-info text-center">No reported cases found for this CV.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

 <!-- Application 2 Content End -->

<?php
$sql3 = "SELECT * FROM `language` WHERE cvid='$cvid'";
$res3 = $conn->query($sql3);
$t2 = 0;
?>
<section class="form-section my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-4">
                    <h2 class="section-title">3.Reported Languages</h2>
                </div>

                <?php
                $t2 = 0;
                while ($row3 = $res3->fetch_assoc()) {
                    $t2++;
                    $lang = $row3['language'];
                    $level = $row3['level'];
                    
                ?>
                <div class="mb-4 p-4 bg-light rounded border shadow-sm">
                    <h4 class="text-primary mb-3"> Language #<?= $t2." ".$lang ?></h4>
                    <p><strong>Level:</strong> <?= $level ?></p>
                    </div>
                <?php } ?>

                <?php if ($t2 === 0): ?>
                    <div class="alert alert-info text-center">No reported cases found for this CV.</div>
                <?php endif; ?>

           </div>
        </div>
    </div>
</section>


<!-- Application 3 Content End -->

<?php
$sql4 = "SELECT * FROM `techskills` WHERE cvid='$cvid'";
$res4 = $conn->query($sql4);
?>
<section class="form-section my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-4">
                    <h2 class="section-title">4.Reported Technical Skills</h2>
                </div>

                <?php
                while ($row4 = $res4->fetch_assoc()) {
                    
                    $desc = $row4['description'];
                    $pew = $row4['p/e/w'];
                    
                ?>
                <div class="mb-4 p-4 bg-light rounded border shadow-sm">
                <h4 class="text-primary mb-3">Level of proficiency in PowerPoint, Excel, and Word: <span style="color: black;"><?= $pew ?></span></h4>
                    <p><strong>Other software skills known:</strong> <?= $desc ?></p>
                    </div>
                <?php } ?>

              

           </div>
        </div>
    </div>
</section>

<div style="text-align: center;">
<a href="applicants.php" class="btn btn-primary btn-action">
         Back
                                        </a>
</div>

    <!-- Form Section End -->


   
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

   




</body>