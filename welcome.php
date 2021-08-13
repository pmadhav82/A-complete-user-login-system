<?php

session_start();

if(empty($_SESSION["name"])){
    header("location:login.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome_page</title>
<link rel = "stylesheet" href ="style/register.css">
<style>
.greeting {
  width: 450px;
    height: 200px;
font-size:30px;
}
    </style>
</head>
<body>
    <div class ="container">
    <h1> Welcome to my page </h1> 
    <div class = "greeting">
        <?php

echo "Hello Mr.".$_SESSION["name"];
echo "<br>";
echo "Your email id is: ". $_SESSION["email"];

        ?>
        </div>

</div>
    <button ><a href = "logout.php"/>Logout</button>
    
</body>
</html>