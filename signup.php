<?
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">

    <title>User Signup</title>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>

        <?php
        // Display errors if any
        if (!empty($errors)) {
            echo '<div style="color: red;">';
            foreach ($errors as $error) {
                echo $error . '<br>';
            }
            echo '</div>';
        }
        ?>

        <form class="signup-form" method="POST" action="login.php">
            <label for="name">Name:</label>
            <input type="text" name="name" size="24" placeholder="Name" required><br>
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Email" required><br>
            <label for="username">Username:</label>
            <input type="text" name="username" size="16" placeholder="Username" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" size="16" placeholder="Password" required><br>
            <label for="confirmPsw">Confirm Password:</label>
            <input type="password" name="confirm_password" size="16" placeholder="Confirm Password" required><br>

            <div class="clearfix">
                <button type="submit" class="signupbtn">Sign Up</button><br>
            </div>
            <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
        </form>
		
<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate form data
    $errors = [];

    if (empty($name) || empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    $datafile = "signup.txt"; 
    $file = fopen($datafile, 'a') or die('Cannot open file ' . $datafile);

    // Check if the username already exists
    $userExists = false;
    while (!feof($file)) {
        $line = fgets($file);
        $userdata = explode(",", $line);
        if (trim($userdata[2]) === $username) {
            $userExists = true;
            break;
        }
    }
    fclose($file);

    if ($userExists) {
        $errors[] = "This User already exists. Login or create a new user.";
    } else {
        // If no errors, perform user registration
        $newuser = array(
            $name,
            $email,
            $username,
            $password
        );

        $newuser_info = implode(",", $newuser);

        $file = fopen($datafile, 'a') or die('Cannot open file ' . $datafile);
        fwrite($file, $newuser_info . "\n");
        fclose($file);

        // Redirect to login page after successful registration
        header("Location: login.php");
        exit();
    }
}
?>
    </div>
</body>
</html>
