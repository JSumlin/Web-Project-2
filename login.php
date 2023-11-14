<?php
session_start();

$flag = FALSE;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data for user authentication
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? $_POST['remember'] : false;

    // Read user data from the file
    $file = fopen("signup.txt", 'r');
    $array = explode("\n", fread($file, filesize("signup.txt")));

    foreach ($array as $arr) {
        $fields = explode(",", $arr);

        if ($fields[2] == $username || $fields[2] == $_COOKIE['userName']) {
            $flag = true;
            $userDetails = $fields;
            break;
        }
    }

    if ($flag) {
        echo "User does not exist. Please sign up by clicking <a href='signup.php'>Sign Up!</a>";
    } else if (($username == $userDetails[2] && $password == $userDetails[3]) || ($_COOKIE["userName"] == $userDetails[2] && $_COOKIE["passWord"] == $userDetails[3])) {
        if ($remember) {
            $_SESSION['userName'] = $username;
            $_SESSION['passWord'] = $password;

            setcookie("userName", $username, time() + 3600);
            setcookie("passWord", $password, time() + 3600);
        }

        // Redirect to main.php after successful login
        header("location: main.php");
        exit;
    }
}

// For logout session
session_destroy();

setcookie("userName", "");
setcookie("passWord", "");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">

    <title>User Login</title>
</head>
<body>


<form action="" method="post">
    <div class="container">
	<h2>Login</h2>
        <label for="username">Username:</label>
        <input type="text" placeholder="Enter Username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <div class="clearfix">
            <button type="submit" class="submit" >Login</button>
            <label><br>
                <input type="checkbox" checked="checked" name="remember">Remember me
            </label>
        </div>
    </div>
</form>

</body>
</html>
