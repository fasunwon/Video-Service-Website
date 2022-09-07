<?php
session_start();
if (isset($_SESSION['ID']) && isset($_SESSION['Username']) && isset($_POST['movieid'])) {
    include "../db_conn.php";
    $user = $_SESSION['Username'];
    $movieID = $_POST['movieid'];
    $initsql = "SELECT * FROM movies WHERE Username = '$user' AND mid = '$movieID'";
    $stmtinit = $connection->query($initsql);
    if ($stmtinit->num_rows == 1) {
        $message = "Already Added to your List!";
        header("Location: ../details.php?id=$movieID&error=$message");
        exit;
    } else {
        $sql = "INSERT INTO movies (mid, Username) VALUES ('$movieID', '$user')";
        $stmt = $connection->query($sql);
        $message = "Successfully added!";
        header("Location: ../mylist.php?success=$message");
        exit;
    }
} else {
    echo "Error";
}
