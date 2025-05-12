<?php
include 'db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $desc = $_POST['desc'];
    $nbrofpay = $_POST['nbrofpay'];
    $tot = $_POST['total'];

    $desc = $conn->real_escape_string($desc);


    $sql = "INSERT INTO ccontract (description,total,nbrofpay,status,caseid)
            VALUES ('" . $desc . "', '" . $tot . "', '" . $nbrofpay . "','Pending','" . $id . "')";
    $conn->query($sql);


    header("Location: accepted.php");
    exit;
}


include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <title>TheFirm - Payment</title>
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
    <link href="../css/payment.css" rel="stylesheet">
 
</head>

<body>

<?php
$sql1 = "SELECT * FROM `case` WHERE id='$id'";
$res1 = $conn->query($sql1);
$row1 = $res1->fetch_assoc();

$userid=$row1['userid'];
$sql2 = "SELECT * FROM user WHERE id='$userid'";
$res2 = $conn->query($sql2);
$row2 = $res2->fetch_assoc();

?>

    <div class="container payment-container">
        <?php
        $sql4 = "SELECT * FROM ccontract WHERE caseid='$id'";
        $res4 = $conn->query($sql4);
        $row4 = $res4->fetch_assoc();
        $status = isset($row4['status']) ? $row4['status'] : '';

        if ($status == 'Accepted') {
            echo '<div class="payment-card">';
            echo '<h2 class="payment-header">Payment Details</h2>';
            echo '<p>' . htmlspecialchars($row1['description']) . '</p>';
            echo '<div class="status-badge status-accepted"><i class="fas fa-check-circle mr-2"></i>Status: ' . $status . '</div>';
         ?>
         
            <form method="post">
                <table class="payment-table">
                    <tr>
                        <th>Description</th>
                        <td><input type="text" name="desc" value="<?= htmlspecialchars($row4['description']) ?>" required></td>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <td><input type="number" name="bef" value="<?= htmlspecialchars($row4['total']) ?>" required></td>
                    </tr>
                    <tr>
                        <th>Number Of Payments</th>
                        <td><input type="text" name="aft" value="<?= htmlspecialchars($row4['nbrofpay']) ?>" required></td>
                    </tr>
                    
                </table>
                <!-- Print Button -->
                <div class="text-center mt-4">
                <a href="ccontract.php?id=<?= $id ; ?>" class="btn btn-black"><i class="fas fa-file-contract mr-1"></i> Case Contract</a>
                    
                    <a href="paycontract.php?id=<?= $row4['id'] ; ?>" class="btn btn-black"> <i class="fas fa-credit-card mr-2"></i>Payment Contract</a>
                </div>
            </form>
        
                                              
         <?php
            echo '</div>';
        } else {
        ?>
            <div class="payment-card">
                 <h2 class="payment-header">Payment Details</h2>
                 <?php
                echo '<div class="btn btn-black"><i class="fas fa-check-circle mr-2"></i>Status: ' . $status . '</div>';
                ?><br><br>
                <p><?=  $row1['description'] ; ?></p>
                <form action="" method="post">
                    <table class="payment-table">
                        <tr>
                            <th>Description</th>
                            <td><input type="text" name="desc" required></td>
                        </tr>
                        <tr>
                            <th>Total Amout</th>
                            <td><input type="number" name="total" required></td>
                        </tr>
                        <tr>
                            <th>Number Of Payments</th>
                            <td><input type="text" name="nbrofpay" required></td>
                        </tr>
                        
                    </table>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-black">
                            <i class="fas fa-save mr-2"></i> SUBMIT
                        </button>
                    </div>
                    <a href="ccontract.php?id=<?= $id ; ?>" class="btn btn-black btn-action">
                     <i class="fas fa-file-contract mr-1"></i> Contract</a>
                </form>
            </div>
        <?php
        }
        ?>
    </div>
</body>

</html>