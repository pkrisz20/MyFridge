<?php

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
}

// Include config file
require_once "dbconfig.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST['password']);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM registered WHERE username = :username";

        if($stmt = $pdo->prepare($sql)){

            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST['username']);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row['id'];
                        $username = $row['username'];
                        $hashed_password = $row['password'];
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "This username doesn't exist.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://use.fontawesome.com/1d8204edd4.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">

    <title>Login</title>
  </head>

  <body>

    <div class="back-icon">
      <a calss="col-6" href="index.php"><i class="fa fa-arrow-left"></i>Back to the Home Page</a>
    </div>

    <div class="d-flex justify-content-center align-items-center login-container">

      <form class="login-form text-center" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <h1 class="mb-3 font-weight-light text-uppercase">Login</h1>

        <?php
            if(!empty($login_err)){
                echo '<p>' . $login_err . '</p>';
            }
        ?>

          <div class="form-group">
              <label>USERNAME:</label>
              <input name="username" type="text" class="form-control rounded-pill form-control-lg <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Type your username here...">
              <span class="invalid-feedback"><?php echo $username_err; ?></span>
          </div>

          <div class="form-group">
            <label>PASSWORD:</label>
              <input name="password" type="password" class="form-control rounded-pill form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Type your password here...">
              <span class="invalid-feedback"><?php echo $password_err; ?></span>
          </div>

          <div class="forgot-link form-group d-flex justify-content-between align-items-center">
            <?php
              if(isset($_GET["newpwd"])) {
                if($_GET["newpwd"] == "passwordupdated") {
                  echo '<p class="signupsuccess">Your password has been reset!</p>';
                }
              }
             ?>
              <a href="email-recover.php">Forgot Password?</a>
          </div>

          <input type="submit" value="SIGN IN" name="submit" class="btn rounded-pill btn-lg btn-custom btn-block" />
          <p class="mt-3 font-weight-normal">Don't have an account yet? <a href="register.php"><strong>Register Now!</strong></a></p>

      </form>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>
