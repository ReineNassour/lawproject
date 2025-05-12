<?php
include 'db.php';

// Get the caseId from the URL
$caseId = isset($_GET['caseId']) ? $_GET['caseId'] : null;

// Check if the case exists and is marked as 'Won'
if ($caseId) {
    $sql = "SELECT * FROM `case` WHERE id='$caseId' AND casestatus='Won'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Case is won, show the congratulations message
        $case = $result->fetch_assoc();
        // You can also fetch other case details if needed
    } else {
        // Case not found or not won
        $case = null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            overflow: hidden;
            margin: 0;
            height: 100vh;
            position: relative;
        }

        .congratulations-div {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }

        .congratulations-div h3 {
            font-size: 2rem;
            color: blue;
        }

        .congratulations-div p {
            font-size: 1.2rem;
            color: #333;
        }

        /* Party Popper Animation */
        .party-popper {
            position: absolute;
            font-size: 70px;
            top: 30%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 999;
        }

        /* Confetti (Paper) Effect */
        .confetti {
            position: absolute;
            width: 10px; /* Paper width */
            height: 25px; /* Paper height (taller pieces) */
            opacity: 1;
            animation: confettiFall 6s infinite;
            border-radius: 5px; /* Slightly rounded edges for paper effect */
        }

        /* Randomized Colors for Confetti */
        .confetti:nth-child(1) { background-color: #ff6347; } /* Tomato Red */
        .confetti:nth-child(2) { background-color: #ffb6c1; } /* Light Pink */
        .confetti:nth-child(3) { background-color: #f0e68c; } /* Khaki Yellow */
        .confetti:nth-child(4) { background-color: #32cd32; } /* Lime Green */
        .confetti:nth-child(5) { background-color: #add8e6; } /* Light Blue */
        .confetti:nth-child(6) { background-color: #ff4500; } /* Orange Red */
        .confetti:nth-child(7) { background-color: #dda0dd; } /* Plum Purple */
        .confetti:nth-child(8) { background-color: #ff1493; } /* Deep Pink */
        .confetti:nth-child(9) { background-color: #ffff00; } /* Yellow */
        .confetti:nth-child(10) { background-color: #00ff7f; } /* Spring Green */
        .confetti:nth-child(11) { background-color: #ff5733; } /* Orange */
        .confetti:nth-child(12) { background-color: #8a2be2; } /* Blue Violet */
        .confetti:nth-child(13) { background-color: #20b2aa; } /* Light Sea Green */
        .confetti:nth-child(14) { background-color: #ff4500; } /* Red-Orange */
        .confetti:nth-child(15) { background-color: #7fff00; } /* Chartreuse */
        .confetti:nth-child(16) { background-color: #f4a300; } /* Golden */
        .confetti:nth-child(17) { background-color: #90ee90; } /* Light Green */
        .confetti:nth-child(18) { background-color: #ff8c00; } /* Dark Orange */
        .confetti:nth-child(19) { background-color: #ff99cc; } /* Pale Pink */
        .confetti:nth-child(20) { background-color: #f08080; } /* Light Coral */
        .confetti:nth-child(21) { background-color: #d3d3d3; } /* Light Grey */
        .confetti:nth-child(22) { background-color: #b0e0e6; } /* Powder Blue */
        .confetti:nth-child(23) { background-color: #c71585; } /* Medium Violet Red */
        .confetti:nth-child(24) { background-color: #bc8f8f; } /* Rosy Brown */
        .confetti:nth-child(25) { background-color: #2e8b57; } /* Sea Green */
        .confetti:nth-child(26) { background-color: #4169e1; } /* Royal Blue */
        .confetti:nth-child(27) { background-color: #dda0dd; } /* Plum */
        .confetti:nth-child(28) { background-color: #ffb6c1; } /* Light Pink */
        .confetti:nth-child(29) { background-color: #4682b4; } /* Steel Blue */
        .confetti:nth-child(30) { background-color: #a52a2a; } /* Brown */
        .confetti:nth-child(31) { background-color: #ff6347; } /* Tomato */
        .confetti:nth-child(32) { background-color: #b22222; } /* Firebrick */
        .confetti:nth-child(33) { background-color: #c71585; } /* Medium Violet Red */
        .confetti:nth-child(34) { background-color: #20b2aa; } /* Light Sea Green */
        .confetti:nth-child(35) { background-color: #f5f5f5; } /* White Smoke */
        .confetti:nth-child(36) { background-color: #000080; } /* Navy Blue */
        .confetti:nth-child(37) { background-color: #f0f8ff; } /* Alice Blue */
        .confetti:nth-child(38) { background-color: #ff4500; } /* Orange Red */
        .confetti:nth-child(39) { background-color: #32cd32; } /* Lime Green */
        .confetti:nth-child(40) { background-color: #ff1493; } /* Deep Pink */
        .confetti:nth-child(41) { background-color: #ff8c00; } /* Dark Orange */
        .confetti:nth-child(42) { background-color: #ffff00; } /* Yellow */
        .confetti:nth-child(43) { background-color: #00ff7f; } /* Spring Green */
        .confetti:nth-child(44) { background-color: #ff6347; } /* Tomato Red */
        .confetti:nth-child(45) { background-color: #ffb6c1; } /* Light Pink */
        .confetti:nth-child(46) { background-color: #f0e68c; } /* Khaki Yellow */
        .confetti:nth-child(47) { background-color: #32cd32; } /* Lime Green */
        .confetti:nth-child(48) { background-color: #add8e6; } /* Light Blue */
        .confetti:nth-child(49) { background-color: #ff4500; } /* Orange Red */
        .confetti:nth-child(50) { background-color: #dda0dd; } /* Plum Purple */

        .confetti:nth-child(51) { background-color: #ff1493; } /* Deep Pink */
        .confetti:nth-child(52) { background-color: #ff8c00; } /* Dark Orange */
        .confetti:nth-child(53) { background-color: #ffff00; } /* Yellow */
        .confetti:nth-child(54) { background-color: #00ff7f; } /* Spring Green */
        .confetti:nth-child(55) { background-color: #ff6347; } /* Tomato Red */
        .confetti:nth-child(56) { background-color: #ffb6c1; } /* Light Pink */
        .confetti:nth-child(57) { background-color: #f0e68c; } /* Khaki Yellow */
        .confetti:nth-child(58) { background-color: #32cd32; } /* Lime Green */
        .confetti:nth-child(59) { background-color: #add8e6; } /* Light Blue */
        .confetti:nth-child(60) { background-color: #ff4500; } /* Orange Red */
    
       /* Confetti Animation */
@keyframes confettiFall {
    0% {
        transform: translate(0, 0) rotate(0deg);
        opacity: 1;
    }
    25% {
        transform: translate(80px, -80px) rotate(90deg); /* Increased movement */
        opacity: 1;
    }
    50% {
        transform: translate(0, -160px) rotate(180deg); /* Increased movement */
        opacity: 0.8;
    }
    75% {
        transform: translate(-80px, -80px) rotate(270deg); /* Increased movement */
        opacity: 1;
    }
    100% {
        transform: translate(0, 0) rotate(360deg);
        opacity: 1;
    }
}

/* Reduce animation duration */
.confetti:nth-child(odd) {
    animation-duration: 3s; /* Faster */
}

.confetti:nth-child(even) {
    animation-duration: 4s; /* Faster */
    animation-delay: 0.5s;
}

        .back-link {
        text-decoration: none; /* Removes the underline from the link */
    }

    /* Styling for the button */
    .back-button {
        background-color: #007bff; /* Blue background color */
        color: white; /* White text color */
        border: none; /* Removes the border */
        padding: 10px 20px; /* Padding inside the button */
        font-size: 16px; /* Font size */
        cursor: pointer; /* Pointer cursor on hover */
        border-radius: 5px; /* Rounded corners */
        transition: background-color 0.3s ease; /* Smooth transition for background color change */
    }

    /* Hover effect for the button */
    .back-button:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }
    </style>
</head>
<body>

<!-- Congratulations Div (Centered) -->
<div id="congratulationsDiv" class="congratulations-div">
<a href="index.php" class="back-link">
    <button class="back-button">Back</button>
</a><br><br>


<h3>🎉 Case Closed Successfully 🎉</h3>
<p>Thank you for trusting us — your case has now been officially finished.</p>
<h5>'The Firm'</h5>

</div>

<!-- Party Popper Icon -->
<div class="party-popper">🎉</div>

<!-- Floating Confetti (60 pieces) -->
<?php
for ($i = 0; $i < 60; $i++) {
    echo "<div class='confetti' style='top: " . rand(10, 90) . "%; left: " . rand(5, 95) . "%;'></div>";
}
?>

<script>
    // Show floating confetti for 40 seconds
    setTimeout(function() {
        const confetti = document.querySelectorAll('.confetti');
        confetti.forEach(function(piece) {
            piece.style.animationPlayState = 'paused'; // Stop the confetti animation after 40 seconds
        });
    }, 70000); // 70000ms = 70 seconds
</script>

</body>
</html>
