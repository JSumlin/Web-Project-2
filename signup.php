<?
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman Game: Sign up</title>
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
        <h2>Sign up</h2>
<?php
        if(isset($_POST["Submit"])) {
            if(isset($_POST["user_name"]) && preg_match('/^.+$/', $_POST["user_name"])){
                if(isset($_POST["password"]) && preg_match('/^.+$/', $_POST["password"])){
                    if(isset($_POST["re_password"]) && $_POST["re_password"] == $_POST["password"]){
                        $user_name = $_POST["user_name"];
                        $password = $_POST["password"];
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

                        if($user_exist){ ?>
                        <p class="error">User already exist. Please enter another username.</p>
                            
                        <?php
                        }
                        else {
                        $file = fopen('users.txt', 'a') or die('Cannot open file ' . $file_name);
                        fwrite($file, "$user_name,$password\n");
                        fclose($file); ?>
                        <p>Successfully sign up. Please login in. </p>
 <?php                   }
                    }
                    else{ ?>
                    <p class="error"> Not match password</p>
                    
 <?php                   }
                }
                
            }
            

        }
    ?>
        Name: <input type="text" name="user_name" placeholder="username" required> <br>
        Password: <input type="text" name="password" placeholder="password" required><br>
        Confirm password: <input type="text" name="re_password" size="16" placeholder="confirm password" required> <br>
        <input type="submit" name="Submit" value="Sign up">
        <p>Already have an account? <a href="login.php">Login in</a></p>
        

    </form>

    
    </div>
</body>
</html>