<?php
session_start();
if (isset($_SESSION['ID']) && isset($_SESSION['Username'])) {
    include "db_conn.php";
    $user = $_SESSION['Username'];
    $initsql = "SELECT * FROM movies WHERE Username = '$user'";
    $stmtinit = $connection->query($initsql);
?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Video Service</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="home.php" class="navbar-brand">Video Service</a>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Hi, <?= $_SESSION['Username'] ?>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" href="mylist.php">My List</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        </br>
        <h1 class="text-center">Subscribed Movies</h1>
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success text-center" role="alert">
                <?php echo $_GET['success']; ?>
            </div>
        <?php } ?>
        <div class="container text-center">
            <div class="row">
                <?php
                if ($stmtinit->num_rows != 0) {
                    while ($row = $stmtinit->fetch_assoc()) {
                        $viewMid = $row['mid'];
                        $key = "b4ca88cf5c705a9ffc2e28e98d05ca5a";
                        $json = file_get_contents("https://api.themoviedb.org/3/movie/$viewMid?api_key=$key&language=en-US");
                        $result = json_decode($json, true);
                        echo ("<div class=\"col col-md-2\"><a href=\"detailsTwo.php?id=" . $viewMid . "\"><img class=\"img-thumbnail\" src='https://image.tmdb.org/t/p/original" . $result['poster_path'] . "'/></a></div>");
                    }
                ?>
                <?php } else {
                    echo ("<h3>You currently have nothing added!</h3>");
                } ?>
            </div>
        </div>
        <br>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } else {
    header('Location: login.php');
    exit;
} ?>