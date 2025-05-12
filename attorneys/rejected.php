<?php
session_start();
include 'db.php';
include 'header.php';

$id=$_SESSION['attorney']['id'];
            
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TheFirm - Rejected Cases</title>
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
    <link href="../css/reject.css" rel="stylesheet">

    
</head>

<body>
    <div class="wrapper">
        <!-- Main Content Start -->
        <div class="container dashboard-container">
            <h2 class="dashboard-title">Rejected Cases</h2>

            <!-- Status Cards -->
            <div class="row status-cards mb-4">
                <div class="col-md-4 mb-4">
                    <div class="card status-card pending-card">
                        <a href="pending.php">
                            <div class="card-body text-center">
                                <div class="status-icon text-warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h5 class="card-title">Pending Cases</h5>
                                <?php
                                $sql10 = "SELECT * FROM `case` where status='Pending'  AND attid='$id' ORDER BY startdate DESC";
                                $res10 = $conn->query($sql10);
                                $t10 = 0;
                                while ($row10 = $res10->fetch_assoc()) {
                                    $t10++;
                                }
                                ?>
                                <p class="display-4 font-weight-bold"><?php echo $t10; ?></p>
                                <small class="text-muted">Awaiting review</small>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card status-card accepted-card">
                        <a href="accepted.php">
                            <div class="card-body text-center">
                                <div class="status-icon text-success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h5 class="card-title">Accepted Cases</h5>
                                <?php
                                $sql11 = "SELECT * FROM `case` where status='Accepted'  AND casestatus='Pending' AND attid='$id'";
                                $res11 = $conn->query($sql11);
                                $t11 = 0;
                                while ($row11 = $res11->fetch_assoc()) {
                                    $t11++;
                                }
                                ?>
                                <p class="display-4 font-weight-bold"><?php echo $t11; ?></p>
                                <small class="text-muted">Currently active</small>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card status-card rejected-card">
                        <a href="rejected.php">
                            <div class="card-body text-center">
                                <div class="status-icon text-danger">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <h5 class="card-title">Rejected Cases</h5>
                                <?php
                                $sql12 = "SELECT * FROM `case` where status='Rejected' AND attid='$id'";
                                $res12 = $conn->query($sql12);
                                $t12 = 0;
                                while ($row12 = $res12->fetch_assoc()) {
                                    $t12++;
                                }
                                ?>
                                <p class="display-4 font-weight-bold"><?php echo $t12; ?></p>
                                <small class="text-muted">Not proceeding</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Cases Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Rejected Cases</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <?php
                        $sql = "SELECT * FROM `case` where status='Rejected' AND attid='$id'";
                        $result = $conn->query($sql);
                        ?>

                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client Name</th>
                                    <th>Email</th>
                                    <th>Case Type</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $TOT = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['categoryid'];
                                    $status = $row['status'];
                                    $userid = $row['userid'];
                                    $TOT++;

                                    $sql = "SELECT * FROM user WHERE id = '$userid'";
                                    $res1 = $conn->query($sql);
                                    $row1 = $res1->fetch_assoc();

                                    $sql3 = "SELECT * FROM category WHERE id = '$id'";
                                    $res3 = $conn->query($sql3);
                                    $row3 = $res3->fetch_assoc();
                                ?>
                                    <tr>
                                        <td><?= $TOT ?></td>
                                        <td><?= $row1['fname'] . " " . $row1['lname'] ?></td>
                                        <td><?= $row1['email'] ?></td>
                                        <td><?= $row3['name'] ?></td>
                                        <td><?= date('M d, Y', strtotime($row['startdate'])) ?></td>
                                        <td class="case-description" title="<?= $row['description'] ?>"><?= $row['description'] ?></td>
                                        <td>
                                            <span class="status-badge status-rejected">
                                                <i class="fas fa-times mr-1"></i> Rejected
                                            </span>
                                        </td>
                                        <td>
                                            <a href="rejectCase.php?acceptid=1&nbb=<?= $row['id'] ?>" class="btn btn-success btn-action">
                                                <i class="fas fa-check mr-1"></i> Accept
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Template Javascript -->
    <script>
        // Enable tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            // Add description tooltips for truncated text
            $('.case-description').tooltip();
        });

        // Initialize CounterUp
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
    </script>
</body>

</html>