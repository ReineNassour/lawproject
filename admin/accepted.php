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

    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    
</head>
<body>
    
<?php
include 'header.php';

$sql="SELECT * FROM cv where status='Accepted'";
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

    <form action="sendquizdate.php" method="post" class="container mb-4">
      <div class="form-row align-items-end">

    <!-- Quiz Date -->
    <div class="form-group col-md-3">
      <label for="quiz_date">Quiz Date</label>
      <input type="date" name="quiz_date" id="quiz_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
    </div>

    <!-- Quiz Start Time -->
    <div class="form-group col-md-3">
      <label for="quiz_time">Start Time</label>
      <input type="time" name="quiz_time" id="quiz_time" class="form-control" required>
    </div>

    <!-- Quiz End Time -->
    <div class="form-group col-md-3">
      <label for="endtime">End Time</label>
      <input type="time" name="endtime" id="endtime" class="form-control" required>
    </div>

    <!-- Submit Button -->
    <div class="form-group col-md-3">
      <button type="submit" class="btn btn-primary btn-block">Set Quiz Date</button>
    </div>

  </div>
</form>

<?php
$sql4="SELECT * FROM `quiz`  ORDER BY id DESC LIMIT 1";
$res4=$conn->query($sql4);

if ($res4->num_rows > 0) {
    $row4 = $res4->fetch_assoc();
    $quizid = $row4['id'];
    $quizdate = $row4['date']; // Format: Y-m-d (assuming)
    $starttime = $row4['starttime']; // Format: H:i
    $endtime = $row4['endtime'];     // Format: H:i
    $status=$row4['status'];
    // Combine date and time
    $endDateTimeStr = $quizdate . ' ' . $endtime;
    $endDateTime = new DateTime($endDateTimeStr);
    $currentDateTime = new DateTime();

     // Exam is over
    if ($currentDateTime > $endDateTime) {
       if($status=='Pending'){
        $updateStatusSql = "UPDATE `quiz` SET status = 'Finished' WHERE id = '$quizid'";
        $conn->query($updateStatusSql); 
        ?>

        <div style="text-align: center;">
            <div class="alert alert-warning" role="alert">
                <strong>The Exam Has Ended.</strong>
            </div>
        </div> 
        
        <?php
       } else{
          ?>
        <div style="text-align: center;">
            <div class="alert alert-warning" role="alert">
                <strong>The Exam Has Ended.</strong>
            </div>
        </div>
        <?php
   } } else {
        // Exam still upcoming or ongoing
        ?>
        <div style="text-align: center;">
        <div class="alert alert-info" role="alert">
    <strong>Exam Scheduled On:</strong> <?= $quizdate ?> 
    <strong>At:</strong> <?= date('H:i', strtotime($starttime)) ?> pm
    <strong>Till:</strong> <?= date('H:i', strtotime($endtime)) ?> pm
</div>

        </div>
        <?php
    }
}
?>


<br>
<div class="content">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Send</th>
                    <th>Action</th>
                    <th>Details</th>
                </tr>
            </thead>
            <?php
            $t=0;
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $t++;
        $cvid=$row['id'];
    $userid=$row['userid'];
    
    $sql7="SELECT * FROM `quizresult` where quizid='$quizid' AND userid='$userid'";
    $res7=$conn->query($sql7);

    if($res7->num_rows == 0){ 

    $sql1="SELECT * FROM user WHERE id='$userid' AND role=0";
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

                    <td> 
                    <!-- Send Message Button -->
                 <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendMessageModal<?= $userid . '_' . $cvid ?>">
                                                    Send
                                                </button>

                                                <!-- Send Message Modal -->
                                                <div class="modal fade" id="sendMessageModal<?= $userid . '_' . $cvid ?>" tabindex="-1" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" style="max-width: 500px;">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="sendMessageModalLabel">Type Here</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="message.php">
                                                                    <input type="hidden" name="cvid" value="<?= $cvid; ?>">
                                                                    <input type="hidden" name="userid" value="<?= $userid; ?>">

                                                                    <div class="mb-3">
                                                                        <h3>To:</h3>
                                                                        <input type="text" class="form-control" value="<?= $name ?>" readonly />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <h3>Email:</h3>
                                                                        <input type="email" class="form-control" value="<?= $email ?>" readonly />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <h3>Message:</h3>
                                                                        <textarea class="form-control" name="message" placeholder="....." required rows="5"></textarea>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">
                                                                        <i class="fa fa-paper-plane me-2"></i>Send Message
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                     </div>
                                              </div>
                                            </td>

                    
                    
                    <td>    
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
                    </td>

                    <td>

<!-- Details Button -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModal<?=  $userid . '_' . $cvid ?>">Details</button>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal<?=  $userid . '_' . $cvid ?>" tabindex="-1" aria-labelledby="detailsModalLabel<?=  $userid . '_' . $cvid ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel<?=  $userid . '_' . $cvid ?>">More Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        
             <div class="modal-body">
                <form method="post" action="">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            
                                            <th>Meeting Status</th>
                                            <th>Quiz Answers</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                           
                                            <!-- Additional columns for meeting status, session address, contract, case result -->
                                            <?php
$sql6 = "SELECT * FROM `application` WHERE userid='$userid'";
$res6 = $conn->query($sql6);

if ($res6->num_rows > 0) { 
    $row6 = $res6->fetch_assoc();
    if ($row6['interviewStatus'] == 'Done') {
        ?>
        <td><b>Meeting Completed</b></td>
        <?php
    } else {
        ?>
        
    <td>
     <a href="#" onclick="joinMeeting('<?= $row6['interviewlink'] ?>', <?= $row6['id'] ?>)" class="btn btn-primary btn-action">
        <?= ($row6['interviewlink']) ? "<b>Join Meeting on ".$row6['interviewdate']."</b>" : "Not Scheduled yet" ?>
     </a>
    </td>

<script>
function joinMeeting(link, meetingId) {
    // Send AJAX request to update meeting status
    fetch('zoom.php?acceptid=0&nbb=' + meetingId)
        .then(response => response.text())
        .then(() => {
            // Once status is updated, open Zoom link
            window.open(link, '_blank');
            window.location.href = 'accepted.php';
        })
        .catch(error => console.error('Error:', error));
}
</script>
        <?php
    }
} else {
    ?>
    <td><b>No Meeting is Scheduled yet</b></td>
    <?php
}
?>
                                           <td>
                                           <a href="quizanswers.php?id=<?= $userid ; ?>" class="btn btn-primary btn-action">
                                      <i class="fas fa-file-contract mr-1"></i> Quiz Answers
                                        </a>
                                           </td>
                                            
                                           
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- Close modal-content -->
    </div> <!-- Close modal-dialog -->
    </div> <!-- Close modal -->


                    </td>

                </tr>
                <!-- Add more rows as needed -->
            </tbody>
            <?php
}
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