<?php 
include '../db.php';

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

    <!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
</head>
<body>
    
<?php
include 'headerM.php';

$sql="SELECT * FROM cv where status='Accepted'";
$result=$conn->query($sql);

?>
<br><br>
    
  
    <div class="row status-cards mb-4">
                <div class="col-md-4 mb-4">
                    <div class="card status-card pending-card">
                        <a href="">
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
                        <a href="">
                            <div class="card-body text-center">
                                <div class="status-icon text-success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h5 class="card-title">Accepted Applicants</h5>
                                <?php
                                $sql11 = "SELECT * FROM `cv` where status='Accepted'";
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
        <div class="card status-card accepted-card">
            <a href="">
                <div class="card-body text-center">
                    <!-- Canvas for Chart -->
                    <canvas id="myChart" width="200" height="200"></canvas>
                </div>
            </a>
        </div>
    </div>

    <script>
        // Fetch data from your PHP API (replace the URL with the correct API endpoint)
        fetch('applicantsapi.php')  // Use the correct path to your PHP API
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    console.log('No data available');
                    return;
                }

                // Process the data here and update the chart
                const labels = data.map(item => `User ${item.userid}`);  // X-axis labels (User IDs)
                const values = data.map(item => item.accepted_count);      // Y-axis values (Accepted Count)

                // Create the chart
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',  // Type of chart (bar, line, pie, etc.)
                    data: {
                        labels: labels,  // X-axis labels
                        datasets: [{
                            label: 'Accepted Applications',  // Label for the dataset
                            data: values,  // Y-axis data points
                            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Bar color
                            borderColor: 'rgba(75, 192, 192, 1)', // Bar border color
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    </script> 
            </div>

            <?php
$sql9="SELECT * FROM `quiz` where status='Pending' ORDER BY id DESC LIMIT 1";
$res9=$conn->query($sql9);
if($res9->num_rows > 0){
$row9=$res9->fetch_assoc();
$quizid=$row9['id'];
    $quizdate=$row9['date'];
    $quiztime=$row9['starttime'];
    $endtime=$row9['endtime'];
?>
<div style="text-align: center;">
                <div class="alert alert-info" role="alert">
                <strong>Exam Scheduled On:</strong> <?= $quizdate ?> 
<strong>At:</strong> <?= date('h:i', strtotime($quiztime)) ?> pm 
<strong>Till:</strong> <?= date('h:i', strtotime($endtime)) ?> pm
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                                <?php
$sql33="SELECT * FROM `question` where quizid='$quizid'";
$res33=$conn->query($sql33);
if($res33->num_rows > 0){
  echo "";
} else {
    ?>
    <a href="addquiz.php?id=<?= $quizid ; ?>" class="btn btn-primary btn-action">
                                                    <i class="fas fa-file-contract mr-1"></i> Add Exam Questions
                                                </a>
    <?php
}

                                                ?>
                </div>
             </div>
             <?php
} else {
    ?>
    <div style="text-align: center;">
                <div class="alert alert-danger" role="alert">
                    <strong>No Exam Scheduled Yet.</strong>
                </div>
                <?php
}
?>

<br>
<div class="content">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>View CV</th>
                    <th>Meetings</th>
                    
                </tr>
            </thead>
            <?php
            $t=0;
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $t++;
        $id=$row['id'];
    $userid=$row['userid'];
    $sql1="SELECT * FROM user where id='$userid'";
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
                         <a href="cv.php?id=<?= $id ; ?>" class="btn btn-primary btn-action">
                                      <i class="fas fa-file-contract mr-1"></i> CV
                                        </a>
                    </td>
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
     <a href="#" onclick="joinMeeting('<?= $row6['interviewlink'] ?>', <?= $row6['id'] ?>)" class="btn btn-success btn-action">
        <?= ($row6['interviewlink']) ? "<b>Join Meeting on ".$row6['interviewdate']." at ".$row6['interviewtime']."</b>" : "Not Scheduled yet" ?>
     </a>
    </td>

<script>
function joinMeeting(link, meetingId) {
    // Send AJAX request to update meeting status
    fetch('zoomapp.php?acceptid=0&nbb=' + meetingId)
        .then(response => response.text())
        .then(() => {
            // Once status is updated, open Zoom link
            window.open(link, '_blank');
            window.location.href = 'application.php'; 
        })
        .catch(error => console.error('Error:', error));
}
</script>
        <?php
    }
} else {
    ?>
    <td><b>Not Scheduled yet</b></td>
    <?php
}
?>
                  
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


<script>
document.querySelector("form").addEventListener("submit", function (e) {
    const selected = Array.from(document.querySelectorAll(".user-checkbox:checked"))
                          .map(cb => cb.value);
    document.getElementById("selectedUsers").value = selected.join(",");
});

document.getElementById("selectAll").addEventListener("change", function () {
    const checkboxes = document.querySelectorAll(".user-checkbox");
    checkboxes.forEach(cb => cb.checked = this.checked);
});
</script>



<br><br>

</body>
</html>