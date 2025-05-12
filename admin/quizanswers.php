<?php
include 'header.php';
include '../db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TheFirm | Case Studies</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Law Firm, Legal Services, Attorneys, Case Studies" name="keywords">
    <meta content="Browse our successful case studies and legal work" name="description">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/cases.css" rel="stylesheet">
    <style>
        /* Your style (kept unchanged for now) */
        .page-header {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .quiz-container {
            width: 70%;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-radius: 15px;
        }
        .quiz-card {
            border: 1px solid #e3e3e3;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: #fdfdfd;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .quiz-header {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
            text-align: center;
        }
        .quiz-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .quiz-table th {
            text-align: right;
            width: 30%;
            padding-right: 15px;
            color: #555;
            font-weight: 500;
        }
        .quiz-table td {
            text-align: left;
        }
        .quiz-table input[type="text"] {
            width: 90%;
            max-width: 600px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
            transition: border-color 0.3s;
            display: block;
            margin: 0 auto;
        }
        .quiz-table input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }
        .btn-black {
            background-color: #222 !important;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
        }
        .btn-black:hover {
            background-color: #000 !important;
        }
        .text-center button i {
            margin-right: 5px;
        }
        @media (max-width: 768px) {
            .quiz-container {
                width: 95%;
                padding: 20px;
            }
            .quiz-table input[type="text"] {
                width: 90%;
            }
            
        }
    </style>
</head>

<body>

<br><br>

<?php
$userid = $_GET['id'];

$sql4 = "SELECT * FROM `user` WHERE id='$userid'";
$res4 = $conn->query($sql4);
$row4 = $res4->fetch_assoc();
$fname = $row4['fname'];
$lname = $row4['lname'];
$email = $row4['email'];

$sql2 = "SELECT * FROM `quiz` ORDER BY id DESC LIMIT 1";
$res2 = $conn->query($sql2);
$row2 = $res2->fetch_assoc();
$quizid = $row2['id'];
$status=$row2['status'];
if ($status == 'Pending') {
    ?>
   <div class="row">
    <div class="col-12">
        <div class="application-message text-center py-5">
            <i class="fas fa-hourglass-half fa-3x mb-4 text-muted"></i>
            <h1 class="mb-3">Check This Exam Soon</h1>
            <p class="mb-4">The Exam Will Commence Shortly.Kindly Ensure You Check And Attend It At The Scheduled Time.</p>
            <a href="accepted.php" class="btn btn-dark">Return</a>
        </div>
    </div>
</div>
<?php
    exit;
} else {
   
$sql = "SELECT * FROM `question` WHERE quizid='$quizid'";
$res = $conn->query($sql);

$sql3 = "SELECT * FROM `answers` WHERE userid='$userid'";
$res3 = $conn->query($sql3);


?>
    <div style="text-align: center; ">
        <h1>
            <?php
            echo "This Exam Record Corresponds To <strong>" . htmlspecialchars($fname) . " " . htmlspecialchars($lname) . "</strong>";
        ?>
        </h1>
    </div>

    <div class="container quiz-container">
    <form action="grade.php" method="post">
        <div id="quizWrapper">
            <?php
            if ($res3->num_rows > 0) {

                $counter = 1; 

                while ($row3 = $res3->fetch_assoc()) {
                    $answers = $row3['answer'];
                    $ansid = $row3['id'];
                    $grades = $row3['grade'];

                    $row = $res->fetch_assoc();

                    $question = $row['given'];
                    $grade = $row['grade'];
                    $questid = $row['id'];

                    if ($grades == 0) {
            ?>
                <div class="quiz-card">
                    <h2 class="quiz-header"><?= $counter . getOrdinalSuffix($counter); ?> Question</h2>
                    <table class="quiz-table">
                    <tr>
    <th>Question</th>
    <td>
        <textarea name="question[]" rows='3' cols='100' readonly><?= htmlspecialchars($question); ?></textarea>
    </td>
    <input type="hidden" name="userid" value="<?= $userid; ?>">
    <input type="hidden" name="questid[]" value="<?= $questid; ?>">
</tr>
<tr>
    <th>Answer</th>
    <td>
        <textarea name="answer[]" rows='3' cols='100' readonly><?= htmlspecialchars($answers); ?></textarea>
    </td>
</tr>
                        <tr>
                            <th>Grade</th>
                            <td><input type="number" name="grade[]" placeholder=".../<?= $grade; ?> Points"></td>
                        </tr>
                    </table>
                </div>
            <?php
                    } else {
                        echo "<div class='quiz-card'>";
                        echo "<h2 class='quiz-header'>" . $counter . getOrdinalSuffix($counter) . " Question</h2>";
                        echo "<table class='quiz-table'>";
                        echo "<tr>";
                        echo "<th>Question</th>";
                        echo "<td><textarea name='question[]' rows='3' cols='100' readonly>" . htmlspecialchars($question) . "</textarea></td>";
                        echo "<input type='hidden' name='userid' value='$userid'>";
                        echo "<input type='hidden' name='questid[]' value='$questid'>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>Answer</th>";
                        echo "<td><textarea name='answer[]' rows='3' cols='100' readonly>" . htmlspecialchars($answers) . "</textarea></td>";
                        echo "</tr>";                        
                        echo "<tr>";
                        echo "<th>Grade</th>";
                        echo "<td><input type='number' name='grade[]' value='" . htmlspecialchars($grades) . "'></td>";
                        echo "</tr>";
                        echo "</table>";
                        echo "</div>";
                    }
                    $counter++;
                }
            ?>
        </div>
        <br>
        <?php
$sql6="SELECT SUM(grade) as sum FROM `answers` WHERE userid='$userid'";
$res6=$conn->query($sql6);
$t1=0;
while($row6=$res6->fetch_assoc()){
$sum=$row6['sum'];
$sql7="SELECT grade FROM `question` WHERE quizid='$quizid'";
$res7=$conn->query($sql7);
$t2=0;
while($row7=$res7->fetch_assoc()){
    $t2+=$row7['grade'];
}
$half=$t2/2;
if($sum>$half){
?>
<div style="text-align: center; ">
    <h1>
        <?php
        echo "The Average Grade For This Exam Is : <strong>" . htmlspecialchars( $sum."/".$t2." PASSED" ) . "</strong>";
        ?>
            
        <?php
        $sql8="INSERT INTO `quizresult` (score,result,quizid,userid) VALUES ('$sum','Passed','$quizid','$userid')";
        $conn->query($sql8);
    ?>
    </h1>
    

</div>
         <?php
           } else {
            ?>
            <div style="text-align: center; ">
                <h1>
                    <?php
                    echo "The Average Grade For This Exam Is : <strong>" . htmlspecialchars( $sum." FAILED" ) . "</strong>";
                    if($sum>0){
                        $sql8="INSERT INTO `quizresult` (score,result,quizid,userid) VALUES ('$sum','Failed','$quizid','$userid')";
                        $conn->query($sql8);
                    }  
                ?>
                </h1>

            </div>
            <?php
           } }
            ?>
           
        <div class="text-center mt-4">
        <a href="accepted.php" class="btn btn-black btn-action">
        <i class="fas fa-file-contract mr-1"></i> Back</a>
            <button type="submit" class="btn btn-black">
                <i class="fas fa-save"></i> SUBMIT Grade
            </button>
        </div>
    </form>
</div>

        
<?php
} else {
?>

<div class="row">
    <div class="col-12">
        <div class="application-message text-center py-5">
            <i class="fas fa-hourglass-half fa-3x mb-4 text-muted"></i>
            <h1 class="mb-3">No Answers Submitted</h1>
            <p class="mb-4">The candidate has not provided any responses for this examination.</p>
            <a href="accepted.php" class="btn btn-dark">Return</a>
        </div>
    </div>
</div>

<?php
} } 
?>
<br><br>

<?php
function getOrdinalSuffix($number) {
    if (!in_array(($number % 100), [11, 12, 13])) {
        switch ($number % 10) {
            case 1: return "st";
            case 2: return "nd";
            case 3: return "rd";
        }
    }
    return "th";
}
?>


</body>
</html>
