<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TheFirm - Client Contract</title>
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
    <link href="../css/contract.css" rel="stylesheet">
    
    <style>
        .contract-card {
    text-align: right;
    direction: rtl;
}

.contract-card .form-group {
    text-align: right;
}

.contract-card label,
.contract-card input,
.contract-card ul.contract-list {
    text-align: right;
    direction: rtl;
}

    </style>

</head>

<body>

<?php
include 'header.php';
include 'db.php';
?>

<?php
// Session check and data preparation
if (isset($_SESSION['attorney'])) {
    $attname = $_SESSION['attorney']['fullName'];
    $attemail = $_SESSION['attorney']['email'];

    $sql2 = "SELECT * FROM user where email='$attemail'";
    $res2 = $conn->query($sql2);
    $row2 = $res2->fetch_assoc();
    $address = $row2['address'];

    $id = $_GET['id'];
    $sql = "SELECT * FROM `case` where id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $caseid= $row['id'];
    $userid = $row['userid'];

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
                    <a href="payment.php?id=<?= $caseid ; ?>" class="btn btn-black">
                        <i class="fas fa-credit-card mr-2"></i> Payment
                    </a>
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
                        <div style="display: flex; justify-content: center;" class="mt-4 no-print">
                            <button type="button" class="btn btn-black" onclick="window.print()">
                                <i class="fas fa-print mr-2"></i> Print Contract
                            </button>
                        </div>
                    </form>
                </div>

  

<div id="content" class="no-print upload-section">
    <h3>Upload and Send Contract</h3>
    <form action="updateimagecontract" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group file-upload">
                    <label class="file-upload-label" for="contractFile">
                        <i class="fas fa-file-upload mr-2"></i>Upload The Case Contract:
                    </label>
                    <input class="form-control" type="file" name="uploadfile" id="contractFile" required />
                </div>
            </div>
        </div>

        <input type="hidden" name="id" value="<?= $caseid; ?>">

        <div class="form-group mt-4">
            <button class="btn btn-black" type="submit" name="enter">
                <i class="fas fa-paper-plane mr-2"></i>Send Documents
            </button>
        </div>
    </form>
</div>


            <!-- Main Content End -->

            <!-- Footer Start -->
            <div class="footer bg-dark text-white py-4 mt-5 no-print">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">
                            <p class="m-0">&copy; 2025 TheFirm. All Rights Reserved.</p>
                        </div>
                        <div class="col-md-6 text-center text-md-right">
                            <p class="m-0">Designed by <a href="#" class="text-white">LegalTech Solutions</a></p>
                        </div>
                    </div>
                </div>
            </div>
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

<?php
} // End of session check
?>