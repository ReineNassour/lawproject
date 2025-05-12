<?php
session_start();
include 'checkStatus.php';
include 'db.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TheFirm | Case Booking</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Law Firm, Legal Services, Attorneys, Book Case" name="keywords">
    <meta content="Book a consultation with our expert attorneys" name="description">

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
    <link href="css/book.css" rel="stylesheet">
    <link href="css/apply.css" rel="stylesheet">


<style>
     .page-header {
    height: 200px;
    display: flex;
    align-items: center; 
    justify-content: center;
   
    padding: 20px 0;
}

      #canvas {
  border: 2px solid #000;
  background-color: #fff;
  touch-action: none; /* Prevent scrolling on touch devices while drawing */
}

#signature-pad {
  text-align: center;
  margin-top: 20px;
}

</style>

</head>

<body>
    <!-- Header included here -->
    <?php include 'header.php'; ?>

    <!-- Page Header Start -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                
               
            </div>
        </div>
    </div>
    <!-- Page Header End -->


<?php



$caseid=$_GET['id'];

$sql3 = "SELECT * FROM `ccontract` where caseid='$caseid'";
    $res3 = $conn->query($sql3);
    if ($res3->num_rows == 0) {
       
        ?>
        <div class="row">
                        <div class="col-12">
                            <div class="application-message">
                                <i class="fas fa-hourglass-half"></i>
                                <h1>This Case Has No Case Contract Yet, Please Wait.</h1>
                                <p class="mb-4">You have already submitted a Case and Your Attorney is currently Preparing The Contract. Please be patient as we process It.</p>
                                <a href="track.php" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
        <br><br><br>
        <?php
        include 'footer.php';
        exit;
    } else{
    $row3 = $res3->fetch_assoc();
$status=$row3['status'];
if ($status == 'Accepted') {

    $sql = "SELECT * FROM `case` where id='$caseid'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $userid = $row['userid'];
    $attid=$row['attid'];

    $sql2 = "SELECT * FROM user where id='$attid'";
    $res2 = $conn->query($sql2);
    $row2 = $res2->fetch_assoc();
    $address = $row2['address'];
    $attname = $row2['fname'] . " " . $row2['lname'];

    $sql1 = "SELECT * FROM `user` where id='$userid'";
    $res1 = $conn->query($sql1);
    $row1 = $res1->fetch_assoc();
    $fname = $row1['fname'];
    $lname = $row1['lname'];
    $email = $row1['email'];
?>

   

        <div class="wrapper">
            <!-- Main Content Start -->
            <div class="container dashboard-container">
                <div class="contract-header">
                    <h2>
                        <i class="fas fa-file-contract mr-2"></i>
                        Case Contract For: <?php echo htmlspecialchars($fname . " " . $lname); ?>
                    </h2>
                </div>

                <div class="contract-card">
                    <form method="post" dir="rtl">
                        <p>
                            <strong style="font-size: 20px;">وكالة قانونية</strong>
                            <br><br>
                            أنا الموقع أدناه:
                            <br>
                        <div class="form-group">
                            <label>:الاسم</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($row1['fname'] . " " . $row1['lname']); ?>" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>:رقم الهوية</label>
                            <input type="text" name="id_number" value="" placeholder="[رقم الهوية]" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>:العنوان</label>
                            <input type="text" name="address" value="<?= htmlspecialchars($row1['address']); ?>" readonly class="form-control">
                        </div>
                        <br>
                        أوكل بموجب هذه الوثيقة:
                        <br>
                        <div class="form-group">
                            <label>:أستاذ/أستاذة</label>
                            <input type="text" name="attorney_name" value="<?= htmlspecialchars($attname); ?>" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>:العنوان</label>
                            <input type="text" name="attorney_address" placeholder="<?= htmlspecialchars($address); ?>" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>:رقم الهاتف</label>
                            <input type="text" name="attorney_phone" placeholder="<?= htmlspecialchars($row2['phonenum']); ?>" class="form-control">
                        </div>
                        <br>
                        لتمثيلي في الأمور التالية:
                        <ul class="contract-list">
                            <li>تقديم الدعاوى أو الدفاع عنها أمام المحاكم المختصة.</li>
                            <li>التوقيع على جميع المستندات القانونية المتعلقة بالقضية/القضايا.</li>
                            <li>التفاوض في تسوية القضايا أو الاتفاقيات.</li>
                            <li>التوقيع على عقود واتفاقيات باسم الموكل.</li>
                        </ul>
                        <div class="form-group">
                            <label>:المدة</label>
                            <input type="text" name="duration" value="" placeholder="[حدد المدة]" class="form-control">
                        </div>
                        <br>
                        الشروط: لا يوجد شروط إضافية أو قيود على نطاق التفويض، ويمكن للمحامي اتخاذ جميع الإجراءات القانونية اللازمة بناءً على تقديره.
                        <br><br>
                        <label>:التوقيع</label>

                       
                        <br><br>
                        <div class="form-group">
                            <label>:الاسم</label>
                            <input type="text" name="sign_name" value="<?= htmlspecialchars($row1['fname'] . " " . $row1['lname']); ?>" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>:التاريخ</label>
                            <input type="text" name="sign_date" value="<?= htmlspecialchars($row['startdate']); ?>" readonly class="form-control">
                        </div>
                        </p>
                        
                    </form>
                </div>

  <?php
    } else {
       ?>

                     <div class="row">
                        <div class="col-12">
                            <div class="application-message">
                                <i class="fas fa-hourglass-half"></i>
                                <h1>Your Case Contract Is Not Accepted Yet, Please Wait.</h1>
                                <p class="mb-4">Your Case Contract has Not Been Accepted yet. Your Attorney is Currently Working On it. Please wait while we complete the process.</p>
                                <a href="track.php" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>

       <?php
    }
}
    ?>
    
            <!-- Main Content End -->
<br><br><br><br><br><br><br>
           <?php
            include 'footer.php';
           ?>
            <!-- Footer End -->
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>

        <!-- Template Javascript -->
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </body>

    </html>
</body>

</html>