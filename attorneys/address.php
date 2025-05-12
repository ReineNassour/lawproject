<?php 
session_start();
include 'db.php';

$att = $_SESSION['attorney']['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = trim($_POST['message']);
    $caseid = $_POST['caseid'];
    $x = trim($_POST['x']);
    $y = trim($_POST['y']);
    $userid = $_POST['userid'];
    $addressid = $_SESSION['last_address_id'] ?? null;

    error_log(" START - message: $message");

    if (preg_match('/the address of your session\s*:\s*(.*?)\s*city:\s*(.*?)\s*building:\s*(.*?)\s*street:\s*(.*?)(?:\s|$)/i', $message, $matches)){
       $details = $conn->real_escape_string(trim($matches[1]));
        $city = $conn->real_escape_string(trim($matches[2]));
        $building = $conn->real_escape_string(trim($matches[3]));
        $street = $conn->real_escape_string(trim($matches[4]));

        error_log(" Address matched: [$details], [$city], [$building], [$street]");

        if ($details && $city && $building && $street) {
            $sqlAddress = "INSERT INTO address (x, y, details, city, building, street) 
                           VALUES ('$x', '$y', '$details', '$city', '$building', '$street')";
            if ($conn->query($sqlAddress) === TRUE) {
                $addressid = $conn->insert_id;
                $_SESSION['last_address_id'] = $addressid;
                error_log(" Inserted Address ID: $addressid");
            } else {
                error_log(" Address Insert Error: " . $conn->error);
                exit("Error inserting address.");
            }
        } else {
            error_log(" One of the address parts was empty.");
        }
    } else {
        error_log(" Address regex did NOT match input: $message");
    }

    error_log(" Address ID in session: $addressid");

    if (!$addressid) {
        exit("Error: No valid address ID found in session.");
    }

    sleep(1);
    $sqlCheck = "SELECT id FROM address WHERE id = '$addressid'";
    $resCheck = $conn->query($sqlCheck);
    if ($resCheck->num_rows == 0) {
        exit("Error: Address ID does not exist in address table.");
    }

    if (preg_match('/your session is on:\s*date:\s*(\d{4}-\d{2}-\d{2})\s*time:\s*(\d{2}:\d{2})\s*(.*?)(?:with the judge:|$)/i', $message, $matches)) {
        $date = trim($matches[1]);
        $time = trim($matches[2]);
        $sessionDetails = $conn->real_escape_string(trim($matches[3]));

        $sqlSession = "INSERT INTO session (date, time, details, caseid, addressid) 
                       VALUES ('$date', '$time', '$sessionDetails', '$caseid', '$addressid')";
        if (!$conn->query($sqlSession)) {
            error_log(" Session Insert Error: " . $conn->error);
            exit("Error inserting session.");
        } else {
            error_log(" Session inserted successfully.");
        }
    } else {
        error_log(" Session regex did not match. Input was: " . $message);
    }

    if (preg_match('/with the judge:\s*(.+)/i', $message, $matches)) {
        $name = trim($matches[1]);
    
        $sqljudge = "INSERT INTO judge (name, caseid) 
                     VALUES ('$name', '$caseid')";
    
        if (!$conn->query($sqljudge)) {
            error_log(" Judge Insert Error: " . $conn->error);
            exit("Error inserting judge.");
        } else {
            error_log(" Judge inserted successfully.");
        }
    }

    header("Location: accepted.php?pid=$userid");
    exit();
}
?>