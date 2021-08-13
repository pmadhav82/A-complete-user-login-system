<?php

//check if user is already logged in,if yes then direct to welcome page
session_start();

if(isset($_SESSION["name"])){
    header("location:welcome.php");
    exit();
}

require("config.php");
$errors = array();

if($_SERVER["REQUEST_METHOD"]=="POST"){

$username=mysqli_real_escape_string($conn,$_POST["username"]);
$password =mysqli_real_escape_string($conn,$_POST["password"]);

if(empty($username)&& empty($password)){
    array_push($errors,"*Please enter your email and password");
}
//validate credentials
else {
    $sql = "select * from admin where email =?";

    if($stmt = mysqli_prepare($conn,$sql)){
 mysqli_stmt_bind_param($stmt,"s",$username);
 if(mysqli_stmt_execute($stmt)){
     mysqli_stmt_store_result($stmt);
     //check if username exists ,if yes veryfi the password
      if(mysqli_stmt_num_rows($stmt) ==1){
          mysqli_stmt_bind_result($stmt,$id,$name,$email,$hashed_password);
          if(mysqli_stmt_fetch($stmt)){
        
              if(password_verify($password, $hashed_password) && count($errors)==0){
                session_start();
                $_SESSION["loggedin"] == true;
                $_SESSION["name"] = $name;
                $_SESSION["email"] = $email;
                $_SESSION["id"] = $id;
                header("location:welcome.php");

              }else {
                array_push($errors,"Invalid Password");
               
            }
          }


      }else {
        array_push($errors,"Invalid input");
      }
 }

    }else {
        array_push($errors,"Invalid email or password");
    }
}
}






?>












<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login_page</title>
    <link rel = "stylesheet" href = "style/style.css"/>
</head>
<body>
    <h1>Login Page </h1>
<div class = "login">

    <h1>Login</h1>
<div class = "errors">
    <?php
foreach($errors as $error){
    echo $error . "<br>";
}
    ?>
</div>

<form action = "login.php" method = "post">
    <label for "username">
        <i class="fas fa-user"></i>
</label>
<input type = "text" name = "username" placeholder = "Enter your email..." required>

<label for "password">
        <i class = "fas fa-lock"></i>
</label>
<input type = "password" name = "password" placeholder = "Enter your password.." required/>

<input type = "submit" value = "Login">
</form>
<div class = "forgot">
<a href = "resetpassword.php">Forgot Password? </a>
<a href = "register.php">Create an Account </a>

</div>

</div>
    
</body>
</html>
