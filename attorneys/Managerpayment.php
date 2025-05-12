<?php
ob_start(); // Start output buffering

include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TheFirm - Payment Management</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Law Firm Case Management" name="keywords">
    <meta content="Case Management System for Law Firms" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/managerpayment.css" rel="stylesheet">

</head>
<body>

<?php
include 'headerM.php';
?>
    <div class="wrapper">
        <?php
       

        $id = $_GET['pid'];

        $sql = "SELECT * FROM ccontract where caseid='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $caseid = $row['caseid'];
        $status = $row['status'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $desc = mysqli_real_escape_string($conn, $_POST['desc']);
            $tot = $_POST['total'];
            $nbrofpay = $_POST['nbrofpay'];

            $sql1 = "UPDATE ccontract SET description='" . $desc . "',total='" . $tot . "' ,nbrofpay='" . $nbrofpay . "'  ,status='Accepted' where caseid=$id";
            $conn->query($sql1);

            header("Location: indexManager.php");
        }

        
         $sql4 = "SELECT * FROM `case` WHERE id = '$caseid'";
        $res4 = $conn->query($sql4);
        $row4 = $res4->fetch_assoc();
        $userid = $row4['userid'];
        $attid= $row4['attid'];
        $description = $row4['description'];

        $sql5 = "SELECT * FROM `user` WHERE id = '$userid'";
        $res5 = $conn->query($sql5);
        $row5 = $res5->fetch_assoc();
        $fname = $row5['fname'];
        $lname = $row5['lname'];

        $sql6 = "SELECT * FROM `user` WHERE id = '$attid'";
        $res6 = $conn->query($sql6);
        $row6 = $res6->fetch_assoc();
        $attfname = $row6['fname'];
        $attlname = $row6['lname'];
        ?>

        <!-- Main Content Start -->
        <div class="container dashboard-container">
           


            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Payment Information From: <b><?= $attfname." ".$attlname." For: ".$fname." ".$lname ; ?></b></h4><br>
                    <p class="mb-0">Description : <?= $description ; ?></p>
                </div>
                <div class="card-body">
                    <form method="post">
                        <table class="table table-custom">
                            <tr>
                                <th>Description</th>
                                <td>
                                    <input type="text" class="form-control" name="desc" value="<?= $row['description'] ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="text" class="form-control" name="total" value="<?= $row['total'] ?>" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Number Of Payments</th>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="text" class="form-control" name="nbrofpay" value="<?= $row['nbrofpay'] ?>" required>
                                    </div>
                                </td>
                            </tr>
                           
                                <th>Status</th>
                                <td>
                                    <?php
                                    if ($status == "Pending") {
                                    ?>
                                        <a href="managerpayaccept.php?acceptid=1&nbb=<?= $id; ?>" class="btn btn-success">
                                            <i class="fas fa-check mr-2"></i>Accept
                                        </a>
                                        </td>
                            </tr>
                        </table>

                        <div class="action-buttons">
                            <button type="submit" class="btn btn-custom-primary">
                                <i class="fas fa-save mr-2"></i>Update Payment Details
                            </button>
                            <a href="indexManager.php" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
                                    <?php
                                    } else if ($status == "Accepted") {
                                    ?>
                                        <span class="badge badge-success p-2">
                                            <i class="fas fa-check-circle mr-1"></i> Already Accepted
                                        </span>
                                    
                                </td>
                            </tr>
                        </table>

                        <div class="action-buttons">
                            
                            <a href="indexManager.php" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
                                    }
                                    ?>
        <!-- Main Content End -->

        <!-- Footer Start -->
        <div class="footer bg-dark text-white py-4 mt-5">
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
</body>

</html>
<?php
ob_end_flush(); // End the output buffer and send the output
?>