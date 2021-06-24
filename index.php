<?php

  session_start();
  require_once 'dbconfig.php';

  //select cards by category
  if($_GET != NULL){
  if($_GET["category"]){
    $select_recipes = "SELECT * from recipes WHERE recipes.recipes_category_id = (SELECT recipes_category_id FROM recipes_categories WHERE recipes_category_name = '".$_GET["category"]."')";
  }
}

else{
  $select_recipes = "SELECT * from recipes";
}

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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/duotone.css" integrity="sha384-R3QzTxyukP03CMqKFe0ssp5wUvBPEyy9ZspCB+Y01fEjhMwcXixTyeot+S40+AjZ" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css" integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">

    <title>Main Page</title>

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
              <a class="nav-link links" href="index.php"><i class="material-icons">home</i> Home</a>
            </li>

          <!--LOGIN-->
            <li class="nav-item">
              <a class="nav-link links" href="login.php"><i class="material-icons">account_circle</i>
                <?php if($_SESSION == NULL){
                    echo "Login";
                }
                else{
                    echo $_SESSION["username"];
                } ?> </a>
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

    <div class="container-fluid">
      <div class="row">

        <!--PRODUCT CARD-->
        <?php

          //select comments and ratings
          for($i=0;$i< count($rows);$i++){
            $select_comments_and_ratings = "SELECT ROUND(AVG(comments_and_ratings.rating)) from comments_and_ratings JOIN recipes
              ON recipes.recipes_id = comments_and_ratings.recipe_id WHERE recipe_id = :id";

            $comments_and_ratings_query = $pdo -> prepare($select_comments_and_ratings);
            $comments_and_ratings_query -> bindValue(":id", $rows[$i]["recipes_id"]);
            $comments_and_ratings_query -> execute();

            if($comments_and_ratings_query -> rowCount() > 0){
                $rows1 = $comments_and_ratings_query -> fetch();

              }
            echo '
            <div class="col-md-3">
              <div class="card mt-3">
                <div class="product-1 align-items-center p-2 text-center">
                  <img src="'. $rows[$i]["recipes_image"] . '" alt="recept" class="rounded mb-3" width="250" height="250">
                  <h5>'. $rows[$i]["recipes_name"] . '</h5>

                  <div class="mt-3 info">
                    <span class="text1">' . $rows[$i]["recipes_description"] . '</span>
                  </div>
                  <div class="cost mt-3 text-dark">
                    <span>$' . $rows[$i]["recipes_price"] . '</span>
                    <div class="star mt-3 align-items-center">
                    ';

                    for($j=0;$j<$rows1["ROUND(AVG(comments_and_ratings.rating))"];$j++){

                      echo '
                        <i class="fas fa-star"></i>';
                    }
                    echo '
                    </div>
                  </div>
                </div>

                <!--BUTTON FOR CARD-->
                <a href="details.php?id='. $rows[$i]["recipes_id"] .'" class="details-link">
                <div class="p-3 button text-center text-dark mt-3 cursor">
                  <span class="details-text text-uppercase">Details</span>
                </div></a>
              </div>
            </div>
            ';
          }
         ?>

      </div>
    </div>
    <!--END OF CONTAINER FOR PRODUCTS-->

  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>
