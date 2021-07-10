<?php

// Include config file
require_once "dbconfig.php";

// Define variables and initialize with empty values
$registered = false;
$username = $password = $email = $name = $surname = $mobile = "";
$username_err = $password_err = $email_err = $name_err = $surname_err = $mobile_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM registered WHERE username = :username";

        if($stmt = $pdo -> prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    if(empty(trim($_POST["email"]))){
        $username_err = "Please enter your email adress.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM registered WHERE email = :email";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    //Validate name
    if(empty(trim($_POST["name"]))){
      $name_err = "Please enter your name.";
    }  else{
        $name = trim($_POST["name"]);
    }

    //Validate surname
    if(empty(trim($_POST["surname"]))){
      $surname_err = "Please enter your surname.";
    }  else{
      $surname = trim($_POST["surname"]);
    }

    //Validate mobile
    if(empty(trim($_POST["mobile"]))){
      $mobile_err = "Please enter your mobile number.";
    }  else{
      $mobile = trim($_POST["mobile"]);
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($email_err) && empty($name_err) && empty($surname_err) && empty($mobile_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO registered (username, password, email, name, surname, mobile, is_admin) VALUES (:username, :password, :email, :name, :surname, :mobile, :admin)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":surname", $param_surname, PDO::PARAM_STR);
            $stmt->bindParam(":mobile", $param_mobile, PDO::PARAM_STR);
            $stmt->bindParam(":admin", 0, PDO::PARAM_INT);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Create hashed password
            $param_email = $email;
            $param_name = $name;
            $param_surname = $surname;
            $param_mobile = $mobile;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Set on true if executes
                $registered = true;
            } else{
                echo "Oops! Something went wrong. Please try again.";
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
    <link rel="stylesheet" href="css/register.css">

    <title>Register</title>
  </head>

  <body>

    <div class="back-icon">
      <a href="index.php"><i class="fa fa-arrow-left"></i>Back to the Home Page</a>
    </div>

    <div class="d-flex justify-content-center align-items-center register-container">

      <form class="login-form text-center" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

          <h1 class="mb-3 font-weight-light text-uppercase">Register</h1>
          <?php

            if($registered === true){
              echo '<p> You have been registered </p>';
            }

          ?>

          <div class="form-group">
            <label>USERNAME:</label>
              <input name="username" type="text" class="form-control rounded-pill form-control-lg <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php if($registered === true){ echo ''; } else { echo $username; } ?>" placeholder="Type your username here...">
              <span class="invalid-feedback"><?php echo $username_err; ?></span>
          </div>

          <div class="form-group">
            <label>PASSWORD:</label>
              <input name="password" type="password" class="form-control rounded-pill form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php if($registered === true){ echo ''; } else { echo $password; } ?>" placeholder="Type your password here...">
              <span class="invalid-feedback"><?php echo $password_err; ?></span>
          </div>

          <div class="form-group">
            <label>NAME:</label>
              <input name="name" type="text" class="form-control rounded-pill form-control-lg <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php if($registered === true){ echo ''; } else { echo $name; } ?>" placeholder="Type your name here...">
              <span class="invalid-feedback"><?php echo $name_err; ?></span>
          </div>

          <div class="form-group">
            <label>SURNAME:</label>
              <input name="surname" type="text" class="form-control rounded-pill form-control-lg <?php echo (!empty($surname_err)) ? 'is-invalid' : ''; ?>" value="<?php if($registered === true){ echo ''; } else { echo $surname; } ?>" placeholder="Type your surname here...">
              <span class="invalid-feedback"><?php echo $surname_err; ?></span>
          </div>

          <div class="form-group">
            <label>E-MAIL:</label>
              <input name="email" type="email" class="form-control rounded-pill form-control-lg <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php if($registered === true){ echo ''; } else { echo $email; } ?>" placeholder="Type your e-mail address here...">
              <span class="invalid-feedback"><?php echo $email_err; ?></span>
          </div>

          <div class="form-group">
            <label>MOBILE:</label>
              <input name="mobile" type="text" class="form-control rounded-pill form-control-lg <?php echo (!empty($mobile_err)) ? 'is-invalid' : ''; ?>" value="<?php if($registered === true){ echo ''; } else { echo $mobile; } ?>" placeholder="Type your phone number here...">
              <span class="invalid-feedback"><?php echo $mobile_err; ?></span>
          </div>

          <input type="submit" name="submit" value="CREATE ACCOUNT" class="btn rounded-pill btn-lg btn-custom btn-block text-uppercase" />

          <p class="mt-3 font-weight-normal">Already have an account? <a href="login.php"><strong>Sign in!</strong></a></p>
      </form>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>
