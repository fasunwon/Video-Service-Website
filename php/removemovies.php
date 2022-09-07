<?php
session_start();
if (isset($_SESSION['ID']) && isset($_SESSION['Username']) && isset($_POST['movieid'])) {
    include "../db_conn.php";
    $user = $_SESSION['Username'];
    $movieID = $_POST['movieid'];
    $initsql = "SELECT * FROM movies WHERE Username = '$user' AND mid = '$movieID'";
    $stmtinit = $connection->query($initsql);
    if ($stmtinit->num_rows == 0) {
        echo "You shouldnt get here!";
        // $message = "Already Removed From your List!";
        // header("Location: ../detailsTwo.php?id=$movieID&error=$message");
        exit;
    } else {
        $sql = "DELETE FROM movies WHERE Username = '$user' AND mid = '$movieID'";
        $stmt = $connection->query($sql);
        $message = "Successfully removed!";
        header("Location: ../mylist.php?success=$message");
        exit;
    }
} else {
    echo "Error";
}
