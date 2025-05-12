<?php
session_start();
include 'db.php';
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

    <!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .wrapper {
            flex: 1 0 auto;
            padding: 20px 0;
            background-color: #f8f9fa;
        }

        .dashboard-container {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dashboard-title {
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 2rem;
            position: relative;
            padding-bottom: 15px;
        }

        .dashboard-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, #007bff, #00c6ff);
            border-radius: 2px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px 25px;
            border-radius: 15px 15px 0 0 !important;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #2c3e50;
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 15px;
            border: none;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .table td {
            padding: 18px 15px;
            vertical-align: middle;
            border-color: rgba(0, 0, 0, 0.03);
            font-size: 0.95rem;
        }

        .btn-action {
            padding: 8px 20px;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #00c6ff);
            border: none;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #007bff);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
        }

        .case-description {
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #6c757d;
        }

        .table-responsive {
            border-radius: 15px;
            background-color: white;
        }

        #notification {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(45deg, #dc3545, #ff6b6b);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .footer {
            flex-shrink: 0;
            background: #2c3e50 !important;
            padding: 20px 0;
            width: 100%;
            margin-top: auto;
        }

        .footer p {
            margin: 0;
            color: #ffffff;
        }

        .footer a {
            color: #00c6ff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #007bff;
        }
    </style>

<body>


<?php
include 'headerC.php';
?>

    <div class="wrapper">
        <!-- Main Content Start -->
        <div class="container dashboard-container">
            <h2 class="dashboard-title">Payments</h2>

            <!-- Cases Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">All Payments</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <?php
                        $sql = "SELECT * FROM `ccontract` where status='Accepted'";
                        $result = $conn->query($sql);
                        ?>

                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client Name</th>
                                    <th>Email</th>
                                    <th>Case Type</th>
                                    <th>Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $TOT = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $status = $row['status'];
                                    $caseid = $row['caseid'];
                                    $contractid= $row['id'];
                                    $TOT++;

                                    $sql5 = "SELECT * FROM `case` WHERE id = '$caseid'";
                                    $res5 = $conn->query($sql5);
                                    $row5 = $res5->fetch_assoc();
                                    $id = $row5['categoryid'];
                                    $userid = $row5['userid'];

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
                                        <td><?= $row3['name']." Case" ?></td>
                                        <td>
                                            <a href="cashierpayment.php?id=<?= $contractid; ?>" class="btn btn-primary btn-action">
                                                <i class="fas fa-file-contract mr-1"></i> Payment Contract
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