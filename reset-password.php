<?php
  $password_updated = false;
  $is_empty = false;
  $con = mysqli_connect("localhost", "root", "", "recipe");

  if(isset($_POST["reset-password"]) && isset($_POST["new-password"]) && isset($_POST["email"]) && isset($_POST["code"])) {

    $new_pass = mysqli_real_escape_string($con, password_hash($_POST['new-password'], PASSWORD_DEFAULT));

    $email = mysqli_real_escape_string($con, $_POST['email']);

    $code = mysqli_real_escape_string($con, $_POST['code']);

    $sql_command = "UPDATE registered SET password = '$new_pass' WHERE token = '$code' AND email = '$email' ";

    $query = mysqli_query($con, $sql_command);

    if($query) {
      $password_updated = true;
    }

  }
  else {
    $is_empty = true;
  }

?>

<!doctype html>
 <html lang="en">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <script src="https://use.fontawesome.com/1d8204edd4.js"></script>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
     <link rel="stylesheet" href="css/resetpassword.css">

     <title>Reset Password</title>

   </head>

   <body>

     <div class="d-flex justify-content-center align-items-center login-container">

         <form class="login-form text-center col-3 col-sm-3" action="reset-password.php" method="POST">
             <h1 class="mb-3 font-weight-light text-uppercase">SET A NEW PASSWORD</h1>

             <?php
               if($is_empty) {
                 echo '<p>You have to fill each field!</p>';
               }
                 if($password_updated) {
                   echo '<p>Your password is updated successfully! Now you can close this tab and sign in with your new password!</p>';
                 }
              ?>

              <div class="form-group">
                  <label>YOUR E-MAIL:</label>
                  <input type="email" name="email" required class="form-control rounded-pill form-control-lg" placeholder="Type your email address here...">
              </div>

             <div class="form-group">
                 <label>NEW PASSWORD:</label>
                 <input type="password" name="new-password" required class="form-control rounded-pill form-control-lg" placeholder="Type your new password here...">
             </div>

             <div class="form-group">
                 <label>CONFIRM PASSWORD:</label>
                 <input type="password" name="confirm-password" required class="form-control rounded-pill form-control-lg" placeholder="Type your password again here...">
             </div>

             <div class="form-group">
                 <label>VERIFICATION CODE:</label>
                 <input type="text" name="code" required class="form-control rounded-pill form-control-lg" placeholder="Type your verification code here...">
             </div>

             <input type="submit" name="reset-password" value="CONFIRM" class="mt-3 btn rounded-pill btn-lg btn-custom btn-block"/>

             <p class="mt-3 font-weight-normal"><a href="login.php"><strong>Sign in!</strong></a></p>
         </form>

     </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
   </body>
 </html>
