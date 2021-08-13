


<?php

require("config.php"); 
  $erros = array();
 

if($_SERVER["REQUEST_METHOD"]=="POST"){



    $name= mysqli_real_escape_string($conn,$_POST["name"]);
    $email= mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,$_POST["pwd"]);
    $passwordrepet = mysqli_real_escape_string($conn,$_POST["pwd-repeat"]);



    
if(empty($name)){
    array_push($erros,"*Enter your name");
}
elseif (!preg_match('/^[a-zA-Z]/',$name)){
    array_push($erros,"*Name only contain letters");
}



if(strlen($passwordrepet)<6){
    array_push($erros,"*Password must be longer than six characters");
}
elseif ($password !== $passwordrepet){
    array_push($erros,"*Password is not match");
}
else { 
    // confirm name and email is matched with database.
    $sql = "select * from admin where email =?";

    if($stmt = mysqli_prepare($conn,$sql)){
mysqli_stmt_bind_param($stmt,"s",$email);
 mysqli_stmt_execute($stmt);
 mysqli_stmt_store_result($stmt);
 if(mysqli_stmt_num_rows($stmt) ==1){
     mysqli_stmt_bind_result($stmt, $dbid,$dbname,$dbemail,$dbpassword);
     mysqli_stmt_fetch($stmt);
     if($name !=$dbname){
        array_push($erros,"*Name, register in this email is not match");
     }
     if($email != $dbemail){
        array_push($erros,"*Email is not match");
     }

     if($name == $dbname && $email == $dbemail){

        $sql = "update admin set password =? where email =?";

        if($stmt = mysqli_prepare($conn,$sql)){
mysqli_stmt_bind_param($stmt,"ss",$password,$email);

$password = password_hash($password,PASSWORD_DEFAULT);
if(mysqli_stmt_execute($stmt)){
    header("location:login.php");
}

        }else {
            echo $dbname.$dbemail;
            array_push($erros,"*Could not complete your request");
        }


     }else {
         array_push($erros,"*Invalid Email id");
     }
 }else {
    array_push($erros,"*Invalid input");
}


    } 
}

mysqli_close($conn);

}




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password_reset_page</title>
    <link rel = "stylesheet" href = "register.css">
</head>
<body>
    


<div class = "container">
        
        <h1>Reset your password </h1>
    <div class = "error">
     <?php
     foreach($erros as $erro){
         echo $erro. "<br>";
     }
     ?>
        </div>
    <form action = "resetpassword.php" method = "post">
        
        <label for ="name">Name: </label>
        <input type = "text" name = "name" placeholder = "Enter your name..." required>
        
    
        <label for ="email">Email: </label>
        <input type = "text" name = "email" placeholder = "Enter your email..." required>
    
    
        <label for ="pwd"> New Password: </label>
        <input type = "password" name = "pwd" placeholder = "Enter your new password..." required>
    
    
        <label for ="pwd-repeat">Confirm  New Password: </label>
        <input type = "password" name = "pwd-repeat" placeholder = "Confirm your new password..." required>
    
    <input type = "submit" value = "Reset">
    </form>
    
    <a href = "login.php">Sing in witch different account</a>
    </div>
    


</body>
</html>