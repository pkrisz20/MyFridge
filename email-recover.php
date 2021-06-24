<?php

  $con = mysqli_connect("localhost", "root", "", "recipe");
  $email_sent = false;

  if(isset($_POST["reset-request"])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);

    $emailquery = "SELECT * FROM registered WHERE email = '$email' ";
    $uniq_id = uniqid();
    $token_query = "UPDATE registered SET token = '$uniq_id' WHERE email = '$email' ";

    $query = mysqli_query($con, $emailquery);
    $query2 = mysqli_query($con, $token_query);

    $emailcount = mysqli_num_rows($query);
    $link = "https://localhost/Chole%20projekt/reset-password.php";

    if($emailcount) {

      $userdata = mysqli_fetch_array($query);

      $username = $userdata['username'];
      $token = $userdata['token'];

      $header = "From: MyFridge <myfridge20@gmail.com>\n";
      $header .= "X-Sender: myfridge20@gmail.com\n";
      $header .= "X-Mailer: PHP/" . phpversion();
      $header .= "X-Priority: 1\n";
      $header .= "Reply-To: myfridge20@gmail.com\r\n";
      $header .= "MIME-Version: 1.0\r\n";
      $header .= "Content-Type: text/html; charset=UTF-8\r\n";

      $message = "
                <html>
                <body>
                <h1>Password reset</h1>
                <p>If you want to reset your password, then click on the link below.</p>
                <p> "." <a href='$link'>".$link."</a></p>
                <p> Your verification code: ".$uniq_id."</p>
                </body>
                </html>
                ";
      $to = $email;
      $subject = "Reset Password";
      if(mail($to, $subject, $message, $header)) {
        $email_sent = true;
      } else {
          echo "Email sending was failed";
      }
  }
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

    <div class="back-icon">
        <a calss="col-6" href="login.php"><i class="fa fa-arrow-left"></i>Back to Log In</a>
    </div>

    <div class="d-flex justify-content-center align-items-center login-container">

        <form class="login-form text-center" action="<?php //echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <h1 class="mb-3 font-weight-light text-uppercase">RESET PASSWORD</h1>

            <?php
                if($email_sent) {
                  echo '<p>Check your email!</p>';
                }
             ?>

            <div class="form-group">
                <label>EMAIL:</label>
                <input type="email" name="email" required class="form-control rounded-pill mb-4 form-control-lg" placeholder="Type your email address here...">
            </div>

            <input type="submit" name="reset-request" value="SEND" class="btn rounded-pill btn-lg btn-custom btn-block"/>

        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>
