<?
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman Game: Sign up</title>
</head>
<body>
    <h1>Hangman Game</h1>
    <img src="hangman.avif" alt="hangman">
    <h2>Sign up:</h2>
    <form action="" method="post"> 
        Name: <input type="text" name="user_name" size="16"> <br>
        Password: <input type="text" name="password" size="16"><br>
        Re-enter password: <input type="text" name="re_password" size="16"> <br>
        <input type="submit" name="Submit" value="Sign up">
    </form>

    <?php
        if(isset($_POST["Submit"])) {
            if(isset($_POST["user_name"]) && preg_match('/^.+$/', $_POST["user_name"])){
                if(isset($_POST["password"]) && preg_match('/^.+$/', $_POST["password"])){
                    if(isset($_POST["re_password"]) && $_POST["re_password"] == $_POST["password"]){
                        $file_name = 'users.txt';
                        $file = fopen($file_name, 'a') or die('Cannot open file ' . $file_name);
                        $user_name = $_POST["user_name"];
                        $password = $_POST["password"];
                        fwrite($file, "$user_name,$password\n");
                        fclose($file);
                        echo "Successfully sign up. ";
                        echo "Please, <a href='login.php'> login in</a>";
                    }
                    else{
                        echo "Not matches password";
                    }
                }
                else{
                    echo "Please, enter your password";
                }
            }
            else{
                echo "Please, enter your name";
            }

        }
    ?>
</body>
</html>