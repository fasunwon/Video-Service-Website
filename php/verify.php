<?php
if (isset($_GET['vkey'])) {
    $vkey = $_GET['vkey'];
    include "../db_conn.php";
    $sql = "SELECT Verified,vkey FROM users WHERE Verified = 0 AND vkey = '$vkey' LIMIT 1";
    $stmt = $connection->query($sql);
    if ($stmt->num_rows == 1) {
        $update = $connection->query("UPDATE users SET verified = 1 WHERE vkey = '$vkey' LIMIT 1");
        if ($update) {
            header('Location: ../login.php?success=Account Verified! You may now log in');
            exit;
        } else {
            echo $connection->error;
        }
    } else {
        echo "This account is INVALID or already VERIFIED!";
    }
} else {
    echo "something went wrong";
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>