<?php
include 'db.php';
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

    <style>
       @media print {
    /* Hide all elements with class 'no-print' */
    .no-print {
        display: none !important;
    }

    /* Ensure the title and payment details remain */
    .payment-header {
        display: block !important;
    }

    /* Remove card shadow and borders for a clean print view */
    .payment-card {
        box-shadow: none;
        border: none;
    }

    /* Ensure payment-container is printed properly */
    .payment-container {
        display: block;
    }

    /* Hide all buttons during printing except the 'Pending' or 'Accept' buttons */
    button, a.btn {
        display: none !important;
    }

    /* Keep only buttons with class 'btn-success' (Pending/Accept) visible */
    .btn-success {
        display: inline-block !important;
    }
}


    </style>
</head>
<body>

<?php

$id = $_GET['id'];

$sql1 = "SELECT * FROM `ccontract` WHERE id='$id'";
$res1 = $conn->query($sql1);
$row1 = $res1->fetch_assoc();
$caseid=$row1['caseid'];

$sql3 = "SELECT * FROM `case` WHERE id='$caseid'";
$res3 = $conn->query($sql3);
$row3 = $res3->fetch_assoc();
$userid=$row3['userid'];

$sql4 = "SELECT * FROM `user` WHERE id='$userid'";
$res4 = $conn->query($sql4);
$row4 = $res4->fetch_assoc();
$email=$row4['email'];
$fname=$row4['fname'];
$lname=$row4['lname'];
?>
<h1 style="text-align:center;">Payments Contract For : <?=  $fname." ".$lname ; ?></h1>
<?php
$sql9="SELECT * FROM `payments` WHERE ccontractid='$id'";
$res9 = $conn->query($sql9);
if($res9->num_rows == 0){
?>
<div class="container payment-container">

    <form action="paycontractProcess.php" method="post"> <!-- Moved form outside -->
        <input type="hidden" name="id" value="<?= $id; ?>">
        
        <div id="paymentWrapper">
            <div class="payment-card">
                <h2 class="payment-header">Case Payment Details</h2>
                
                <table class="payment-table">
                    <tr>
                        <th>Payment</th>
                        <td><input type="text" name="pay[]" required></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td><input type="text" name="date[]" required></td>
                    </tr>
                    
                </table>
                
                <div class="button-container">
                    <button type="button" class="btn btn-primary addPayment">Add Payment</button>
                    <button type="button" class="btn btn-danger removePayment">Remove Payment</button>
                </div>
            </div>
        </div>

        <!-- Single submit button for all payments -->
        <div class="text-center mb-4">
            <button type="submit" class="btn btn-black">
                <i class="fas fa-save mr-2"></i> SUBMIT
            </button>
        </div>
    </form>
</div>
<?php
}
 else {
       while($row9=$res9->fetch_assoc()){
            $status = $row9['status'];
            $payid = $row9['id'];
            $payment=$row9['amount'];
        ?>


<div class="container payment-container">
<?php
include 'db.php';
?>
<form action="paycontractProcess.php" method="post"> <!-- Moved form outside -->
        <input type="hidden" name="id" value="<?= $id; ?>">
        
        <div id="paymentWrapper">
            <div class="payment-card">
                <h2 class="payment-header">Case Payment Details</h2>
                
                <table class="payment-table">
                    <tr>
                        <th>Payment</th>
                        <td><input type="text" name="pay[]" placeholder="<?= $payment." $" ; ?>" required></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td><input type="text" name="date[]" placeholder="<?= $row9['date'] ; ?>" required></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                        <?php
                                    if ($status == "UnPaid") {
                                   echo "<b>UnPaid</b>";
                                    } else if ($status == "Paid") {
                                    echo "<b>Paid</b>";
                                    }
                                    ?>
                           
                        </td>
                    </tr>
                </table>
                
             
            </div>
        </div>
    </form>

</div>


        <?php
       }
}
?>

<div class="text-center mb-4">
    <a href="ccontract.php?id=<?= $caseid ; ?>" class="btn btn-black btn-action">
        <i class="fas fa-file-contract mr-1"></i> Contract
    </a>
    <button type="button" class="btn btn-black" onclick="window.print()">
        <i class="fas fa-print mr-2"></i> Print
    </button>
    <a href="payment.php?id=<?= $caseid ; ?>" class="btn btn-black btn-action">
        <i class="fas fa-file-contract mr-1"></i> Payment
    </a>
</div>


<script>

   document.addEventListener("DOMContentLoaded", function () {
    let counter = 1; // Track number of payments
    updatePaymentHeaders();
    
    document.getElementById("paymentWrapper").addEventListener("click", function (event) {
        if (event.target.classList.contains("addPayment")) {
            let wrapper = document.getElementById("paymentWrapper");
            let newPayment = wrapper.firstElementChild.cloneNode(true);
            
            // Clear input values for cloned div
            newPayment.querySelector("input[name='pay[]']").value = "";
            newPayment.querySelector("input[name='date[]']").value = "";
            
            // Update the header for the new payment card
            counter++;
            newPayment.querySelector(".payment-header").textContent = counter + getOrdinal(counter) + " Payment Details";
            
            wrapper.appendChild(newPayment);
            updatePaymentHeaders();
        }
        
        if (event.target.classList.contains("removePayment")) {
            let wrapper = document.getElementById("paymentWrapper");
            if (wrapper.children.length > 1) {
                event.target.closest(".payment-card").remove();
                counter--;
                updatePaymentHeaders();
            }
        }
    });

    function updatePaymentHeaders() {
        let paymentCards = document.querySelectorAll(".payment-card");
        paymentCards.forEach((card, index) => {
            card.querySelector(".payment-header").textContent = (index + 1) + getOrdinal(index + 1) + " Payment Details";
        });
    }
    
    function getOrdinal(n) {
        let suffixes = ["th", "st", "nd", "rd"];
        let v = n % 100;
        return suffixes[(v - 20) % 10] || suffixes[v] || suffixes[0];
    }
});

</script>

</body>
</html>
