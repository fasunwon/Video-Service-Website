<?php
session_start();
if (isset($_POST['uname']) && isset($_POST['pass'])) {
    include "../db_conn.php";
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $data = "uname=" . $uname;
    if (empty($uname)) {
        $message = "Username is required!";
        header("Location: ../login.php?error=$message&$data");
    } else if (empty($pass)) {
        $message = "Password is required!";
        header("Location: ../login.php?error=$message&$data");
    } else {
        $sql = "SELECT * FROM users WHERE Username = '$uname'";
        $stmt = $connection->query($sql);
        $row = $stmt->fetch_assoc();
        if ($stmt->num_rows == 1) {
            $firstname = $row['FirstName'];
            $lastname = $row['LastName'];
            $username = $row['Username'];
            $emailaddress = $row['Email'];
            $passfield = $row['Password'];
            $id = $row['ID'];
            $verified = $row['Verified'];
            $date = $row['CreateDate'];
            $date = strtotime($date);
            $date = date('M d Y', $date);
            if ($verified == 1) {
                if ($username === $uname && password_verify($pass, $passfield)) {
                    $_SESSION['ID'] = $id;
                    $_SESSION['Username'] = $username;
                    header('Location: ../home.php');
                    exit;
                } else {
                    $message = "Incorrect Username or Password";
                    header("Location: ../login.php?error=$message&$data");
                    exit;
                }
            } else {
                $message = "This account is not VERIFIED! Email was sent to $emailaddress on $date";
                header("Location: ../login.php?error=$message&$data");
                exit;
            }
        } else {
            $message = "User not registered!";
            header("Location: ../login.php?error=$message&$data");
            exit;
        }
    }
} else {
    header('Location: ../login.php?error=error');
    exit;
}
