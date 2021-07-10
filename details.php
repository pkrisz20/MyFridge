<?php

  session_start();
  $recipes_id = $_GET["id"];
  require_once 'dbconfig.php';
  $select_recipes = "SELECT * from recipes where recipes_id = :id";

  $recipes_query = $pdo -> prepare($select_recipes);
  $recipes_query -> bindValue(":id", $recipes_id);
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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css" integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous"/>
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
              <?php if($_SESSION == NULL){
                  echo '<a class="nav-link links" href="login.php"><i class="material-icons">account_circle</i>';
                  echo 'Login';
                  echo '</a>';
              }
              else{
                echo '<a class="nav-link links" href="profile-page.php"><i class="material-icons">account_circle</i>';
                echo $_SESSION["username"];
                echo '</a>';
              } ?>
          </li>

          <!--DROPDOWN MENU-->
            <li class="nav-item dropdown links">

              <a class="nav-link dropdown-toggle links-dropdown" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="material-icons">menu_book</i> Recipes
              </a>

              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="index.php">All categories</a></li>
                <li><a class="dropdown-item" href="index.php?category=Appetiser">Appetiser</a></li>
                <li><a class="dropdown-item" href="index.php?category=Main Dishes">Main Dishes</a></li>
                <li><a class="dropdown-item" href="index.php?category=Soups">Soups</a></li>
                <li><a class="dropdown-item" href="index.php?category=Salads">Salads</a></li>
                <li><a class="dropdown-item" href="index.php?category=Desserts">Desserts</a></li>
              </ul>

            </li>
            <!--END OF DROPDOWN MENU-->

            <!--SEARCH-->
            <li class="nav-item">
              <a class="nav-link links" href="search.php"><i class="material-icons">search</i> Search for recipes</a>
            </li>
            <!--END OF SEARCH-->

            <!--LOG OUT-->
            <?php if(!($_SESSION == NULL)){ echo '
              <li class="nav-item">
                <a class="nav-link links" href="logout.php"><i class="material-icons">logout</i> Sign out</a>
              </li>'; }
            ?>

        </div>

      </div>
    </nav>
    <!--END OF NAVBAR-->

    <!--DETAILS ABOUT RECIPE-->
    <div class="container all">

        <div class="card">
          <img width="600" height="600" src = <?php echo '"' . $rows[0]["recipes_image"] . '"'; ?> class="card-img-top">

          <div class="card-body">
            <h1><?php echo $rows[0]["recipes_name"]; ?></h1>
            <p class="card-text">Description: <?php echo $rows[0]["recipes_description"]; ?></p>
            <p class="card-text">Ingredients: </p>
            <p class="card-text">Rating:
            <?php
            $select_comments_and_ratings = "SELECT ROUND(AVG(comments_and_ratings.rating)) from comments_and_ratings JOIN recipes
                  ON recipes.recipes_id = comments_and_ratings.recipe_id WHERE recipe_id = :id";

                $comments_and_ratings_query = $pdo -> prepare($select_comments_and_ratings);
                $comments_and_ratings_query -> bindValue(":id", $recipes_id);
                $comments_and_ratings_query -> execute();

                if($comments_and_ratings_query -> rowCount() > 0){
                    $rows1 = $comments_and_ratings_query -> fetch();

                  }
                  for($j = 0; $j < $rows1["ROUND(AVG(comments_and_ratings.rating))"]; $j++){

                    echo '
                      <i class="fas fa-star"></i>';
                  }
            ?>
            </p>
          </div>
        </div>

      </div>
  <!--END OF DETAILS ABOUT RECIPE-->

<div class="container">

  <!--RATING-->

  <div id="rating-div" class="stars-background bg-dark mt-3">
    <ul class="list-inline rating-list">
      <li><i class="fa fa-star gray"></i></li>
      <li><i class="fa fa-star gray"></i></li>
      <li><i class="fa fa-star gray"></i></li>
      <li><i class="fa fa-star gray"></i></li>
      <li><i class="fa fa-star gray"></i></li>
    </ul>
  </div>
  <!--END OF RATING-->

  <!--COMMENT FORM-->
  <?php
    //processing comment
    if(isset($_POST["submit"])){
      try{
        $comment = $_POST["com"];
        $sql_command = "INSERT INTO comments_and_ratings(recipe_id, username_id, comment) VALUES(:recipe_id, :username_id, :comment)";

        if(!isset($_SESSION["id"])){
          echo '<div class="mt-3 text-align-center error">If you want to comment, then please sign in! Click <a href="login.php">HERE</a></div>';
        } else {
          $query = $pdo -> prepare($sql_command);
          $query -> bindValue(":recipe_id", $recipes_id);
          $query -> bindValue(":username_id", $_SESSION["id"]);
          $query -> bindValue(":comment", $comment);
          $query -> execute();
        }
      }
      catch(Exception $e){ throw $e; }
    }

  ?>

  <form method="POST" class="form-group mt-4">
    <label for="comment" class="form-label">Comment:</label>
    <textarea class="form-control" name="com" rows="4" placeholder="Write your comment here..."></textarea>
    <button type="submit" name="submit" class="btn mt-3 btn-default">Share comment</button>
  </form>
<!--END OF COMMENT FORM-->

<!--COMMENT SECTION-->
<?php
  //select comments
  $sql = "SELECT registered.username, comments_and_ratings.comment, comments_and_ratings.rating
  FROM comments_and_ratings JOIN registered ON registered.id = comments_and_ratings.username_id WHERE recipe_id = :id";

  $sql = $pdo -> prepare($sql);
  $sql -> bindValue(":id", $recipes_id, PDO::PARAM_INT);
  $sql -> execute();
  if($sql -> rowCount() > 0){
    $rows = $sql -> fetchAll();
    for($i = 0; $i < count($rows); $i++){
      echo '
      <div class="row-comment" style="display: flex; justify-content: center; align-items: center;">

          <div style="height: 100px; width: 200px;" class="text-center col-lg-4 mt-3 mb-4 profile-name">
              <i class="material-icons profile-icon">account_circle</i> <span id="username">' . $rows[$i]["username"] . '</span>
          </div>

          <div style="height: 100px; width: 800px;" class="comment-description col-lg-8 mt-3 mb-4">
              <p class="comment">' . $rows[$i]["comment"] . '</p>
          </div>
        </div>';
    }
  }
?>
  <!--END OF COMMENT SECTION-->
</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script type="text/javascript" src="stars.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>
