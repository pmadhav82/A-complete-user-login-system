



<?php
require("config.php"); 
  $erros = array();
 

if($_SERVER["REQUEST_METHOD"]=="POST"){



    $name= mysqli_real_escape_string($conn,$_POST["name"]);
    $email= mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,$_POST["pwd"]);
    $passwordrepet = mysqli_real_escape_string($conn,$_POST["pwd-repeat"]);



 
//validate userName

if(empty($name)){
    array_push($erros,"*Enter your name");
}
elseif (!preg_match('/^[a-zA-Z]/',$name)){
    array_push($erros,"*Name only contain letters");
}else
{
    $sql = "select id from admin where email = ?";
    if($stmt = mysqli_prepare($conn,$sql)){
        mysqli_stmt_bind_param($stmt,"s",$email);
        mysqli_stmt_execute($stmt);

        //store result
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1){
            array_push($erros,"*This email id has been registered already");
        }else
        $name= mysqli_real_escape_string($conn,$_POST["name"]);
    }
    mysqli_stmt_close($stmt);

}

//validate password
if(strlen($passwordrepet)<6){
    array_push($erros,"*Password must be longer than six characters");
}
elseif ($password !== $passwordrepet){
    array_push($erros,"*Password is not match");
}else {
    $password = mysqli_real_escape_string($conn,$_POST["pwd"]);
}
//validate E-mail
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    $email= mysqli_real_escape_string($conn,$_POST["email"]);
}else {
    array_push($erros,"*Email is not valid");

}
//proced to insert data in database only if there are no errors
if(count($erros) == 0){
$hash_password = password_hash($password, PASSWORD_DEFAULT);
$sql = "insert into admin(name,email,password) values (?,?,?)";

if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($stmt,"sss",$name,$email,$hash_password);

    //if success direct to login page
  if (mysqli_stmt_execute($stmt)){
    session_start();
    $_SESSION["loggedin"] == true;
    $_SESSION["name"] = $name;
    $_SESSION["email"] = $email;
    $_SESSION["id"] = $id;
    header("location:welcome.php");
  }else {
      echo "Something went wrong.. try again latter..";
  }
  mysqli_stmt_close($stmt);

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
    <title>Sing_Up_page</title>
    <link rel = "stylesheet" href = "register.css"/>
</head>
<body>

    <div class = "container">
        
    <h1>Sing Up </h1>
<div class = "error">
 <?php
 foreach($erros as $erro){
     echo $erro. "<br>";
 }
 ?>
    </div>
<form action = "register.php" method = "post">
    
    <label for ="name">Name: </label>
    <input type = "text" name = "name" placeholder = "Enter your name..." required>
    

    <label for ="email">Email: </label>
    <input type = "text" name = "email" placeholder = "Enter your email..." required>


    <label for ="pwd"> Password: </label>
    <input type = "password" name = "pwd" placeholder = "Enter your password..." required>


    <label for ="pwd-repeat">Confirm Password: </label>
    <input type = "password" name = "pwd-repeat" placeholder = "Confirm your password..." required>

<input type = "submit" value = "Sing up">
</form>

<a href = "login.php">Already have an account?</a>
</div>

    
</body>
</html>

