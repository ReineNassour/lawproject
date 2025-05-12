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
    <link href="../css/indexmanager.css" rel="stylesheet">

    <style>
        #notification {
    display: none;
    position: fixed;
    top: 20px;
    right: 20px;
    background: red;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 18px;
}
    </style>

<body>


<?php
include 'headerM.php';
?>



    <div class="wrapper">
        <!-- Main Content Start -->
        <div class="container dashboard-container">
           
            <!-- Cases Table -->
            <div class="card shadow-sm mb-4">
            <div class="d-flex justify-content-center">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-2">All Accepted Cases</h1>
        </div>
    </div>
</div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <?php
                        $sql = "SELECT * FROM `case` where status='Accepted' ORDER BY startdate DESC";
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
                                    <th>Payment</th>
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
                                    

                                        <?php
$sql2="SELECT * FROM `ccontract` where caseid='".$row['id']."'";
$res2=$conn->query($sql2);
$row2=$res2->fetch_assoc();
if($res2->num_rows > 0){
                                        ?>
                                        <td>
                                            <a href="Managerpayment.php?pid=<?= $row['id'] ?>" class="btn btn-info btn-action">
                                                <i class="fas fa-money-bill-wave mr-1"></i> Payment
                                            </a>
                                        </td>
                                        <?php } else { ?>
                                            <td>
                                    No Payment Contract Was Made
                                            </td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Content End -->

         <!-- Status Card -->
         <div class="row mb-4" >
                <div class="col-md-4 mb-4">
                    <div class="card status-card accepted-card">
                        <div class="card-body text-center">
                            <div class="status-icon text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h5 class="card-title">Accepted Cases</h5>
                            <?php
                            $sql11 = "SELECT * FROM `case` where status='Accepted'";
                            $res11 = $conn->query($sql11);
                            $t11 = 0;
                            while ($row11 = $res11->fetch_assoc()) {
                                $t11++;
                            }
                            ?>
                            <p class="display-4 font-weight-bold"><?php echo $t11; ?></p>
                            <small class="text-muted">Currently active</small>
                        </div>
                    </div>
                </div>
           


            <!-- Smaller Doughnut Chart for Accepted Cases -->
<div class="col-md-4 mb-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-center">Accepted Cases</h5>
            <canvas id="acceptedCasesChartSmall" width="600" height="60"></canvas> <!-- Smaller size -->
        </div>
    </div>
</div>
</div>

<script>
    // Fetch the data for the chart
    fetch("getdataapi.php")
        .then(response => response.json())
        .then(data => {
            console.log(data); // Check the data in console

            // Create the Doughnut chart with a smaller size
            const ctx = document.getElementById('acceptedCasesChartSmall').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'doughnut',  // Changed to doughnut chart
                data: {
                    labels: ['Accepted Cases'],
                    datasets: [{
                        data: [data.count, 100 - data.count], // Display the count vs the rest as 100 - count
                        backgroundColor: ['#28a745', '#e9ecef'], // Green for accepted, gray for the rest
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    cutoutPercentage: 80, // Makes the doughnut hole larger for a more compact look
                    plugins: {
                        tooltip: {
                            enabled: false // Disable tooltip if you want a cleaner look
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data for the chart:', error));
</script>
   

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