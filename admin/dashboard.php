<?php
include 'header.php';
include '../db.php';
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Dashboard</h1>

    <div class="row">
        <!-- Total Users Card -->
     <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                <a href="users.php"> <h2 class="card-title">Total Users</h2></a>  
                    <?php
                    $sql1 = "SELECT * FROM user where role=0";
                    $res1 = $conn->query($sql1);
                    $t1 = 0;
                    ?>
                    <p class="card-text display-4">
                        <?php while ($row1 = $res1->fetch_assoc()) {
                            $t1++;
                        }
                        echo $t1;
                        ?>
                    </p>
                </div>
            </div>
        </div> 

        <!-- Total Attorneys Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                  <a href="attorneys.php"> <h2 class="card-title">Total Attorneys</h2></a> 
                    <?php
                    $sql2 = "SELECT * FROM attorneys";
                    $res2 = $conn->query($sql2);
                    $t2 = 0;
                    ?>
                    <p class="card-text display-4">
                        <?php while ($row2 = $res2->fetch_assoc()) {
                            $t2++;
                        }
                        echo $t2;
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Pending Cases Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
            <div class="card-body text-center">
                  <a href="applicants.php">  <h2 class="card-title">Total Applicants</h2></a>
                    <?php
                    $sql5 = "SELECT * FROM `cv` where status='Pending'";
                    $res5 = $conn->query($sql5);
                    $t5 = 0;
                    ?>
                    <p class="card-text display-4">
                        <?php while ($row5 = $res5->fetch_assoc()) {
                            $t5++;
                        }
                        echo $t5;
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Total Accepted Cases Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h2 class="card-title">Total Accepted Cases</h2>
                    <?php
                    $sql4 = "SELECT * FROM `case` where status='Accepted'";
                    $res4 = $conn->query($sql4);
                    $t4 = 0;
                    ?>
                    <p class="card-text display-4">
                        <?php while ($row4 = $res4->fetch_assoc()) {
                            $t4++;
                        }
                        echo $t4;
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Applicants Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
            <div class="card-body text-center">
                    <h2 class="card-title">Total Pending Cases</h2>
                    <?php
                    $sql3 = "SELECT * FROM `case` where status='Pending'";
                    $res3 = $conn->query($sql3);
                    $t3 = 0;
                    ?>
                    <p class="card-text display-4">
                        <?php while ($row3 = $res3->fetch_assoc()) {
                            $t3++;
                        }
                        echo $t3;
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<br><br>

<?php
include 'footer.php';
?>

</body>
</html>
