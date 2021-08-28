<?php
  session_start();
  //unset($_SESSION["groceries"]);
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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css" integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/all.min.css">

    <title>Search</title>

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
              <?php if($_SESSION["username"] == NULL){
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

    <!--SEARCH FIELD-->
    <div class="row justify-content-center">
      <div class="row col-lg-6 col-xl-4 col-md-10 col-sm-8 col-xs-8 search-recipe">
        <h1 class="mb-4">Search for recipes</h1>

        <form method="POST" action="search.php">

          <div class="mb-3">
            <label for="ingredient" class="form-label"> <h4><strong>What do you have in your fridge?</strong></h4> </label>
            <input type="text" name="ingredient" class="form-control js-ingredient-input">
            <div class="js-error mt-3 hidden" id="input-error"></div>
          </div>

          <button type="submit" name="adding" class="btn mb-3 js-add">ADD TO TABLE</button>
        </form>

      </div>
    </div>
    <!--END OF SEARCH FIELD-->

  <!--INGREDIENTS TABLE-->
<div class="row justify-content-center">
  <div class="row col-lg-6 col-xl-4 col-md-10 col-sm-8 col-xs-8 groceries-table">

    <table class="table table-striped">
      <thead>
      <tr>
        <th id="table-title" colspan="3">TABLE OF INGREDIENTS</th>
      </tr>
    </thead>

    <tbody class="js-tbody">

    </tbody>
    </table>

    <div>
      <form action="search.php" method="POST">
        <button type="submit" name="recommend" class="btn js-recommend">RECOMMEND ME RECIPES</button>
      </form>
    </div>
</div>
  <!--END OF INGREDIENTS TABLE-->

  <!--SELECT RECIPES-->
  <div class="container-fluid">
    <div class="row">
      <?php

      if(isset($_POST["recommend"])){
      //comments and ratings
      for($i = 0; $i < count($rows); $i++){
        $select_comments_and_ratings = "SELECT ROUND(AVG(comments_and_ratings.rating)) FROM comments_and_ratings JOIN recipes
          ON recipes.recipes_id = comments_and_ratings.recipe_id WHERE recipe_id = :id";

        $comments_and_ratings_query = $pdo -> prepare($select_comments_and_ratings);
        $comments_and_ratings_query -> bindValue(":id", $rows[$i]["recipes_id"]);
        $comments_and_ratings_query -> execute();

        if($comments_and_ratings_query -> rowCount() > 0){
            $rows1 = $comments_and_ratings_query -> fetch();
          }

      if(isset($_SESSION["groceries"])){

        $select_recipes = "(SELECT groceries_id FROM groceries WHERE ";

        $int = 0;
        foreach($_SESSION["groceries"] as $key) {
          if($int !== 0){
            $select_recipes = $select_recipes . " OR ";
          }
          $select_recipes = $select_recipes . " groceries_name = :groceries$int";
          $int = $int + 1;
        }
        $select_recipes = $select_recipes . ")";

        $recipes_query = $pdo -> prepare($select_recipes);

        for($k = 0; $k < $int; $k++){
          $recipes_query -> bindValue(":groceries$k", $_SESSION["groceries"][$k]);
        }
        $recipes_query -> execute();

        //fetch object
        //var_dump($select_recipes);
        if($recipes_query -> rowCount() > 0){
          $r = $recipes_query -> fetchAll();


          for($zs = 0; $zs < count($r); $zs++){

            $query_first = "SELECT recipes_id, recipes_name, recipes_image, recipes_price, recipes_description FROM recipes
            INNER JOIN ing ON recipes.recipes_id = ing.recipe_id WHERE ing.groceries_id = :id";

            // var_dump($r);
            $first_execute = $pdo -> prepare($query_first);
            $first_execute -> bindValue(":id", $r[$zs]["groceries_id"]);


            $first_execute -> execute();
            $rows2 = $first_execute -> fetchAll();

            if($i<1){

            
            while(true){
              echo '
              <div class="col-md-3">
                <div class="card mt-4">
                  <div class="product-1 align-items-center p-2 text-center">
                    <img src="'. $rows2[$i]["recipes_image"] . '" alt="recept" class="rounded mb-3" width="250" height="250">
                    <h5>'. $rows2[$i]["recipes_name"] . '</h5>

                    <div class="mt-3 info">
                      <span class="text1">' . $rows2[$i]["recipes_description"] . '</span>
                    </div>
                    <div class="cost mt-3 text-dark">
                      <span>€' . $rows2[$i]["recipes_price"] . '</span>
                      <div class="star mt-3 align-items-center">
                      ';

                      for($j = 0; $j < $rows1["ROUND(AVG(comments_and_ratings.rating))"]; $j++){

                        echo '
                          <i class="fas fa-star"></i>';
                      }
                      echo '
                      </div>
                    </div>
                  </div>

                  <!--BUTTON FOR CARD-->
                  <a href="details.php?id='. $rows2[$i]["recipes_id"] .'" class="details-link">
                  <div class="p-3 button text-center text-dark mt-3 cursor">
                    <span class="details-text text-uppercase">Details</span>
                  </div></a>
                </div>
              </div>
              ';
              break;
            }
          }
        }

          }
        }
      }
      unset($_SESSION["groceries"]);
    }
       ?>

    </div>
  </div>
  <!--END OF SELECT RECIPES-->


    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript" src="search.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
  </html>
