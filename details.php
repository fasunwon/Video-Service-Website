<?php
session_start();
if (isset($_SESSION['ID']) && isset($_SESSION['Username'])) {
    $movieID = $_GET['id'];
    $key = "b4ca88cf5c705a9ffc2e28e98d05ca5a";
    $json = file_get_contents("https://api.themoviedb.org/3/movie/$movieID?api_key=$key&language=en-US");
    $result = json_decode($json, true);
    $videojson = file_get_contents("https://api.themoviedb.org/3/movie/$movieID/videos?api_key=$key&language=en-US");
    $videocontent = json_decode($videojson, true);

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
        <br>
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success text-center" role="alert">
                <?php echo $_GET['success']; ?>
            </div>
        <?php } ?>
        <div class="container text-left">
            <div class="row">
                <div class="col col-md-4">
                    <img class="img-thumbnail" src="https://image.tmdb.org/t/p/original/<?= $result['poster_path']; ?>" />
                </div>
                <div class="col col-md-8">
                    <h1><?= $result['title']; ?></h1>
                    <p><?= $result['overview']; ?></p>
                    <strong>Genres: </strong>
                    <?php
                    for ($x = 0; $x < count($result['genres']); $x++) { ?>
                        <label class="border bg-info rounded p-1 text-white"><?= $result['genres'][$x]['name']; ?></label>
                    <?php } ?>
                    <p><strong>Movie length: </strong><?= $result['runtime']; ?>mins</p>
                    <p><strong>Release Date: </strong><?= date('jS \of F Y', strtotime($result['release_date'])); ?></p>
                    <i><strong>"<?= $result['tagline']; ?>"</strong></i>
                    <p></p>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe width="425" height="250" class="rounded embed-responsive-item" src="https://www.youtube.com/embed/<?= $videocontent['results'][0]['key']; ?>" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <form method="post" action="php/addmovies.php">
                <input type="text" style="visibility:hidden;" class="form-control" name="movieid" value=<?= $movieID ?> />
                <div class=" d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger" role="button" style="width: 100%;">Add to List</button>
                </div>
            </form>
        </div>
        <br>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } else {
    header('Location: login.php');
    exit;
} ?>