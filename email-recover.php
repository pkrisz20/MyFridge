<?php

  $con = mysqli_connect("localhost", "root", "", "recipe");

  require 'PHPMailer/PHPMailerAutoload.php';

  $email_sent = false;
  $mail = new PHPMailer;
  $mail->IsSMTP(); // telling the class to use SMTP
  $mail->SMTPAuth = true; // enable SMTP authentication
  $mail->SMTPSecure = "tls"; // sets the prefix to the servier
  $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
  $mail->Port = 587; // set the SMTP port for the GMAIL server
  $mail->Username = "myfridge20@gmail.com"; // GMAIL username
  $mail->Password = "MyFridge2021"; // GMAIL password



  if(isset($_POST["reset-request"])) {
    ini_set("SMTP","ssl://smtp.gmail.com");
    ini_set("smtp_port","587");
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $emailquery = "SELECT * FROM registered WHERE email = '$email' ";
    $uniq_id = uniqid();
    $token_query = "UPDATE registered SET token = '$uniq_id' WHERE email = '$email' ";

    $query = mysqli_query($con, $emailquery);
    $query2 = mysqli_query($con, $token_query);
    $emailcount = mysqli_num_rows($query);
    $link = "https://localhost/MyFridge/reset-password.php";

      if($emailcount) {

        $userdata = mysqli_fetch_array($query);


        $message = "If you want to reset your password, then click on the link below.\n
                    Password reset:" .$link."\n
                    Your verification code: ".$uniq_id;

      $mail->AddAddress($email, "You");
      $mail->SetFrom("myfridge20@gmail.com", 'MyFridge');
      $mail->Subject = "Password reset";
      $mail->Body = $message;
      // var_dump($mail->Send());
      if($mail->Send()){
          $email_sent = true;
      }
    }
  }

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://use.fontawesome.com/1d8204edd4.js%22%3E"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="css/resetpassword.css">

    <title>Reset Password</title>

  </head>

  <body>

    <div class="back-icon">
        <a calss="col-6" href="login.php"><i class="fa fa-arrow-left"></i>Back to Log In</a>
    </div>

    <div class="d-flex justify-content-center align-items-center login-container">

        <form class="login-form text-center" method="POST">
            <h1 class="mb-3 font-weight-light text-uppercase">RESET PASSWORD</h1>

            <?php

                if(isset($_POST["reset-request"])) {

                  if($email_sent){
                    echo "The mail was sent successfully to your email address!";
  
                  }
                  else {
                      echo "Email sending was failed!";
                  }
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