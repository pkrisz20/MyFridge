<?php
  session_start();
  require_once 'dbconfig.php';

  $sql = "SELECT * FROM registered WHERE id = ".$_SESSION["id"];
  $data_query = $pdo -> prepare($sql);
  $data_query -> execute();

  if($data_query -> rowCount() == 1 && $row = $data_query -> fetch()){
    $username = $row["username"];
    $email = $row["email"];
    $name = $row["name"];
    $surname = $row["surname"];
    $mobile = $row["mobile"];
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
    <link rel="stylesheet" href="css/profile-page.css">
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
              <li class="nav-item">
                <a class="nav-link links" href="logout.php"><i class="material-icons">logout</i> Sign out</a>
              </li>

        </div>

      </div>
    </nav>
    <!--END OF NAVBAR-->

<!--EDIT PROFILE-->
    <div class="container" style="display: flex; justify-content: center;">
      <div class="row">
        <h1>PROFILE</h1>
      </div>
    </div>

    <div class="container box">
      <div class="row1">
        <div class="data">
          <h3>USERNAME</h3>
          <span><?php echo $username; ?></span>
        </div>

        <div class="data">
          <h3>EMAIL</h3>
          <span><?php echo $email; ?></span>
        </div>

        <div class="data">
          <h3>NAME</h3>
          <span><?php echo $name; ?></span>
        </div>

        <div class="data">
          <h3>SURNAME</h3>
          <span><?php echo $surname; ?></span>
        </div>

        <div class="data">
          <h3>MOBILE</h3>
          <span><?php echo $mobile; ?></span>
        </div>

      </div>
    </div>
  <!--END OF EDIT PROFILE-->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>
