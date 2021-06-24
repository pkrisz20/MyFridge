<?php

  session_start();
  require_once 'dbconfig.php';
    $select_recipes = "SELECT * from recipes";

    $recipes_query = $pdo -> prepare($select_recipes);
    $recipes_query -> execute();


    if($recipes_query -> rowCount() > 0){
        $rows = $recipes_query -> fetchAll();

      }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="css/details.css">
    <link rel="stylesheet" href="css/all.min.css">

    <title>Details</title>

  </head>

  <body>
    <!--NAVBAR-->

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">

      <div class="container-fluid">
        <!--LOGO-->
        <a class="navbar-brand" href="#"><img class="logo" src="images/logo.png"></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">

          <!--HOME-->
            <li class="nav-item">
              <a class="nav-link links" href="index.php"><i class="material-icons">home</i> <span>Home</span></a>
            </li>

          <!--LOGIN-->
            <li class="nav-item">
              <a class="nav-link links" href="login.php"><i class="material-icons">account_circle</i> Login</a>
            </li>

          <!--DROPDOWN MENU-->
            <li class="nav-item dropdown links">

              <a class="nav-link dropdown-toggle links-dropdown" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="material-icons">menu_book</i> Recipes
              </a>

              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="#">Appetiser</a></li>
                <li><a class="dropdown-item" href="#">Main Dishes</a></li>
                <li><a class="dropdown-item" href="#">Soups</a></li>
                <li><a class="dropdown-item" href="#">Salads</a></li>
                <li><a class="dropdown-item" href="#">Desserts</a></li>
              </ul>

            </li>
            <!--END OF DROPDOWN MENU-->

            <!--SEARCH-->
            <li class="nav-item">
              <a class="nav-link links" href="search.php"><i class="material-icons">search</i> Search for recipes</a>
            </li>
            <!--END OF SEARCH-->

        </div>

      </div>
    </nav>
    <!--END OF NAVBAR-->

    <!--DETAILS ABOUT RECIPE-->
  <div class="container all">

    <div class="card">
      <img src="images/tejszinescsirke.jpg" class="card-img-top" style="border: none;">

      <div class="card-body">
        <h1>Tejszines csirke</h1>
        <p class="card-text">Tejszines rizses csirke elkeszitese</p>
        <p class="card-text">Leiras 1</p>
        <p class="card-text">Hozzavalok</p>
        <p class="card-text">Rating</p>
      </div>
    </div>

  </div>
  <!--END OF DETAILS-->

<div class="container">

  <!--COMMENT FORM-->

  <form class="form-group mt-4">
    <label for="comment" class="form-label">Comment:</label>
    <textarea class="form-control" rows="4" placeholder="Write your comment here..." id="comment"></textarea>
    <button type="submit" name="submit" class="btn mt-3 btn-default">Share comment</button>
  </form>
<!--END OF COMMENT FORM-->

<!--COMMENT SECTION-->
  <div class="row-comment" style="display: flex; justify-content: center; align-items: center;">

    <div style="height: 100px; width: 200px;" class="text-center col-lg-4 mt-5 bg-light mb-4 profile-name">
        <i class="material-icons profile-icon">account_circle</i> <span id="username">felhasznalo</span>
    </div>

    <div style="height: 100px; width: 800px;" class="comment-description col-lg-8 mt-5 bg-light mb-4">
        <p class="comment">maga a hozzaszolas</p>
    </div>

  </div>
  <!--END OF COMMENT SECTION-->
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>
