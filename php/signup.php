<?php
$regexEmail = "/^\w+@[a-zA-Z]+?.[a-zA-Z]{2,3}$/";
$regex_Pswd = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";

if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['uname'])) {
    include "../db_conn.php";
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $uname = $_POST['uname'];
    $vkey = md5(time() . $uname);
    $data = "fname=" . $fname . "&uname=" . $uname . "&lname=" . $lname . "&email=" . $email;
    if (empty($fname)) {
        $message = "First Name is required!";
        header("Location: ../index.php?error=$message&$data");
    } else if (empty($lname)) {
        $message = "Last Name is required!";
        header("Location: ../index.php?error=$message&$data");
    } else if (empty($email)) {
        $message = "Email is required!";
        header("Location: ../index.php?error=$message&$data");
    } else if (empty($pass)) {
        $message = "Password is required!";
        header("Location: ../index.php?error=$message&$data");
    } else if (empty($uname)) {
        $message = "Username is required!";
        header("Location: ../index.php?error=$message&$data");
    } else {
        if (!preg_match($regexEmail, $email)) {
            $message = "Invalid Email (needs to be test@something.com)";
            header("Location: ../index.php?error=$message&$data");
        } else if (!preg_match($regex_Pswd, $pass)) {
            $message = "Password needs to be minimum eight characters, at least one uppercase letter, one lowercase letter and one number";
            header("Location: ../index.php?error=$message&$data");
        } else {
            $initsql = "SELECT * FROM users WHERE Email = '$email' OR Username = '$uname'";
            $stmtinit = $connection->query($initsql);
            $row = $stmtinit->fetch_assoc();
            if ($stmtinit->num_rows == 1) {
                $message = "Username or Email Address already in use!";
                header("Location: ../index.php?error=$message&$data");
                exit;
            } else {
                //hash password
                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users(FirstName, LastName, Username, Email, Password, vkey) VALUES('$fname', '$lname', '$uname','$email', '$pass','$vkey')";
                $stmt = $connection->query($sql);
                //send Email Confirmation
                $to = $email;
                $subject = "Email Verification";
                //change the link to "https://fasunwonf.ursse.org/php/verify.php?vkey=$vkey"
                //change the link for local dev "http://localhost/353prog/php/verify.php?vkey=$vkey"
                $confirmationMessage = "<a href='http://localhost/353prog/php/verify.php?vkey=$vkey'>Register account</a>";
                //change it to fasunwon@fasunwonf.ursse.org
                //change for local dev ffasunwon@gmail.com
                $headers = "From:ffasunwon@gmail.com \r\n";
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                mail($to, $subject, $confirmationMessage, $headers);
                header('Location: ../login.php?success=Email verification sent, please verify your account before logging in');
                exit;
            }
        }
    }
} else {
    header('Location: ../index.php?error=error');
    exit;
}
