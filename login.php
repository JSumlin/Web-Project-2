<?php
    session_start();      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman Game: Login</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<div id="container">
<div id="hangman">
    <h1>Hangman Game</h1>
    <img src="hangman.avif" alt="hangman">
</div>
<div id="keyboard">
    <h2>Login:</h2>
    <form action="" method="post">
        Name: <input type="text" name="user_name" size="16"> <br>
        Password: <input type="text" name="password" size="16"> <br>
        <input type="submit" name="Submit" value="Login">
    </form>

    <?php 
    if(isset($_POST["Submit"])) {
        if(isset($_POST["user_name"]) && preg_match('/^.+$/', $_POST["user_name"])){
            if(isset($_POST["password"]) && preg_match('/^.+$/', $_POST["password"])){
                $user_name = trim($_POST["user_name"]);
                $password = trim($_POST["password"]);
                $user_exist = false;

                $file = file("users.txt", FILE_IGNORE_NEW_LINES);
                foreach($file as $line){
                    list($name, $pass) = explode(",", $line);
                    if($name == $user_name){
                        if($pass == $password){
                            $user_exist = true;
                            break;
                        }
                        else{
                            $user_exist = false;
                        }
                        
                    }
                }

                if($user_exist){
                    $_SESSION["user_name"] = $user_name;
                    header("location:main.php");
                    exit;
                }
                else{
                    echo "Invalid Login Details";
                }
            }
            else{
                echo "Invalid Login Details";
            }
        }
        else{
            echo "Invalid Login Details";
        }
    }
    
    
    ?>
        
    
    <p> Don't have an account? <a href="signup.php"> Sign up </a> </p>
</div>
</div>
</body>
</html>