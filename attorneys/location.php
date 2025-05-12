<?php
ob_start();
session_start();
include 'header.php';
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/accases.css" rel="stylesheet">
  
    
</head>
<body>
    

<div id="map" style="height: 300px; width: 100%;"></div><br><br>

    <?php
    $id=$_GET['pid'];
    
    
    $sql = "SELECT * FROM `case` WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $caseid = $row['id'];
    $userid = $row['userid'];

    $sql1="SELECT * from user where id='$userid'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
       ?>

<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactModal<?= $caseid ?>">Send</button>

<!-- Contact Form Modal -->
<div class="modal fade" id="contactModal<?= $caseid ; ?>" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
 <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Send Location :</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        
            <div class="modal-body">
                <form method="post" action="address.php">
                    <div class="mb-3">
                    
                         <input type="hidden" name="caseid" value="<?= $caseid; ?>">
                          
                        <h3>To :</h3>
                        <input type="text" class="form-control" placeholder="<?= $row1['fname'] . " " . $row1['lname'] ?>" readonly />
                    </div>
                    <div class="mb-3">
                        <h3>Email :</h3>
                        <input type="email" class="form-control" placeholder="<?= $row1['email'] ?>" readonly />
                    </div>

                    <input type="hidden" name="caseid" value="<?= $caseid; ?>">
                    <input type="hidden" name="userid" value="<?= $row1['id']; ?>">
                    
                    <h3>X</h3>
                    <input type="text" id="latitude" name="x" placeholder="Latitude">
                    <h3>Y</h3>
                    <input type="text" id="longitude" name="y" placeholder="Longitude">

                    <div class="mb-3">
                        <h3>Message :</h3>
                        <textarea class="form-control" name="message" placeholder="the address of your session : ... city: ... building: ... street: ....
your session is on: date:... time:... Details... with the judge:..." required rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-paper-plane me-2"></i>Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
   </div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMggPVt-5XVZ-R_LUNVCjscV7JjQfYeC0&callback=initMap" async defer></script>
<script>
    function initMap() {
        let map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 37.7749, lng: -122.4194 }, // Default center (San Francisco)
            zoom: 10,
        });

        let marker = new google.maps.Marker({
            position: map.getCenter(),
            map: map,
            draggable: true,
        });

        google.maps.event.addListener(map, "click", function(event) {
            let lat = event.latLng.lat();
            let lng = event.latLng.lng();
            marker.setPosition(event.latLng);
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
        });
    }
</script>
</body>
</html>

<?php
ob_end_flush();
?>