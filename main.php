<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman Game: Main </title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<h1> The Hangman Game </h1>
    <div class="login">   
        <h2>Welcome, <?php echo $_SESSION["user_name"] ?></h2>

        <p>Pick a level </p>
        <form action="" method="post">
            <input type="submit" name="easy" value="Easy">
            <input type="submit" name="medium" value="Medium">
            <input type="submit" name="hard" value="Hard">

            <p> <a href="leaderboard.php"> Leader board</a></p>
        </form>
    

    </div>   

</body>
</html>

<?php
    if(isset($_POST["easy"])){
        $_SESSION["level"] = $_POST["easy"];
        header("location:game.php");
        exit;
    }

    if(isset($_POST["medium"])) {
        $_SESSION["level"] = $_POST["medium"];
        header("location:game.php");
        exit;
    }
    
    if(isset($_POST["hard"])) {
        $_SESSION["level"] = $_POST["hard"];
        header("location:game.php");
        exit;
    }
?>