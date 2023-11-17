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
    <link rel="icon" href="image/x-icon" href="hangman_noose.jpeg">
</head>
<body>
    <h1>
        <span class="title">H</span>
        <span class="title">A</span>
        <span class="title">N</span>
        <span class="title">G</span>
        <span class="title">M</span>
        <span class="title">A</span>
        <span class="title">N</span>
    </h1>

    <div class="login">
        
        <form action="" method="post">
            <h2>Login</h2>
<?php       if(isset($_POST["Submit"])){
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
                            $file = file("leaderboard.txt", FILE_IGNORE_NEW_LINES);
                            foreach($file as $line){
                                list($name, $score) = explode(",", $line);
                                if($name == $user_name) {
                                    $_SESSION["score"] = $score;
                                    break;
                                }
                            }
                            $_SESSION["user_name"] = $user_name;
                            header("location:main.php");
                            exit;
                        
                        }
                        else{ ?>
                            <p class="error">User does not exist. Please sign up.</p>
<?php                   }   
                    }
                    
                }
                
            } ?>
            <br>    
            <h4>Name: </h4>
            <input type="text" name="user_name" placeholder="username" required> <br>
            <h4>Password:</h4>
            <input type="password" name="password" placeholder="password" required> <br>

            <input type="submit" name="Submit" value="Login">
       
            <p> Don't have an account? <a href="signup.php"> Sign up </a> </p>

        </form>
    </div>
</body>
</html>