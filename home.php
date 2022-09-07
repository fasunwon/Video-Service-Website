<?php
session_start();
if (isset($_SESSION['ID']) && isset($_SESSION['Username'])) {

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
                <a class="navbar-brand">Video Service</a>
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
        <div class="container text-center">
            <div class="row">
                <?php
                $key = "b4ca88cf5c705a9ffc2e28e98d05ca5a";
                $json = file_get_contents("https://api.themoviedb.org/3/movie/popular?api_key=$key&language=en-US&page=1");
                $result = json_decode($json, true);
                $json2 = file_get_contents("https://api.themoviedb.org/3/movie/popular?api_key=$key&language=en-US&page=2");
                $result2 = json_decode($json2, true);
                for ($x = 0; $x <= count($result['results']) - 1; $x++) {
                    echo ("<div class=\"col col-md-2\"><a href=\"details.php?id=" . $result['results'][$x]['id'] . "\"><img class=\"img-thumbnail\" src='https://image.tmdb.org/t/p/original" . $result['results'][$x]['poster_path'] . "'/></a></div>");
                }
                for ($x = 0; $x <= count($result2['results']) - 1; $x++) {
                    echo ("<div class=\"col col-md-2\"><a href=\"details.php?id=" . $result2['results'][$x]['id'] . "\"><img class=\"img-thumbnail\" src='https://image.tmdb.org/t/p/original" . $result2['results'][$x]['poster_path'] . "'/></a></div>");
                }
                ?>
            </div>
            <br>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } else {
    header('Location: login.php');
    exit;
} ?>