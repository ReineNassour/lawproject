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

    
    
</head>
<body>
    
<?php
include 'header.php';

$sql="SELECT * FROM cv where status='Pending'";
$result=$conn->query($sql);

?>
<br><br>
    
  
    <div class="row status-cards mb-4">
                <div class="col-md-4 mb-4">
                    <div class="card status-card pending-card">
                        <a href="applicants.php">
                            <div class="card-body text-center">
                                <div class="status-icon text-warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h5 class="card-title">Pending Applicants</h5>
                                <?php
                                $sql10 = "SELECT * FROM `cv` where status='Pending'";
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
                                <h5 class="card-title">Accepted Applicants</h5>
                                <?php
                                    $sql11="SELECT * FROM `cv` where status='Accepted' AND userid NOT IN (SELECT userid FROM `attorneys`)";
                                    $res11=$conn->query($sql11);
                                    $t11=0;
                                    while($row11=$res11->fetch_assoc()){
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
                                <h5 class="card-title">Rejected Applicants</h5>
                                <?php
                                $sql12 = "SELECT * FROM `cv` where status='Rejected'";
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

<br>
<div class="content">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>View CV</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php
            $t=0;
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $t++;
        $id=$row['id'];
    $userid=$row['userid'];
    $sql1="SELECT * FROM user WHERE id='$userid'";
    $result1=$conn->query($sql1);
    while($row2=$result1->fetch_assoc()){
        $id=$row2['id'];
        $fname=$row2['fname'];
        $lname=$row2['lname'];
        $name=$fname." ".$lname;    
        $email=$row2['email'];
            ?>
            <tbody>
                <tr>
                    <td> <?= $t ; ?> </td>
                    <td> <?= $name ; ?> </td>
                    <td> <?= $email ; ?> </td>
                    <td> 
                         <a href="cv.php?id=<?= $id ; ?>" class="btn btn-primary btn-action">
                                      <i class="fas fa-file-contract mr-1"></i> CV
                                        </a>
                    </td>

                    <td>
                    <div class="d-flex gap-2">
    <!-- Accept Form -->
    <form action="sendemailAccepted.php" method="post">
        <?php $adname = $_SESSION['admin']['fullName']; ?>
        <input type="hidden" name="adname" value="<?= $adname; ?>">
        <input type="hidden" name="userid" value="<?= $row2['id']; ?>">
        <input type="hidden" name="cvid" value="<?= $row['id']; ?>">
        <input type="hidden" name="email" value="<?= $row2['email']; ?>">
        <input type="hidden" name="name" value="<?= $name; ?>">
        <button type="submit" class="btn btn-success btn-action">
            <i class="fas fa-check mr-1"></i> Accept
        </button>
    </form>

    <!-- Reject Form -->
    <form action="sendemailRejected.php" method="post">
    <?php $adname = $_SESSION['admin']['fullName']; ?>
        <input type="hidden" name="adname" value="<?= $adname; ?>">
        <input type="hidden" name="userid" value="<?= $row2['id']; ?>">
        <input type="hidden" name="cvid" value="<?= $row['id']; ?>">
        <input type="hidden" name="email" value="<?= $row2['email']; ?>">
        <input type="hidden" name="name" value="<?= $name; ?>">
        <button type="submit" class="btn btn-danger btn-action">
            <i class="fas fa-check mr-1"></i> Reject
        </button>
    </form>
</div>

   
                    </td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
            <?php
}
}
}
?>
        </table>
    </div>
</div>

<br><br>

<?php
include 'footer.php';
?>

</body>
</html>