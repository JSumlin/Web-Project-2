<?php
    session_start();

    $GAME_OVER = false;
    $_SESSION["score"] = 0;
    $body_parts = ["none", "head", "body", "left_arm", "right_arm", "left_leg", "right_leg"];
    

    

    function getCurrentWord(){
        $file = file('vocab.txt', FILE_IGNORE_NEW_LINES);
        
        if(!isset($_SESSION["word"]) && empty($_SESSION["word"])){
            if(isset($_SESSION["level"]) && $_SESSION["level"] == "Easy") {
                $rand = rand(0, 5);
                $guess = $file[$rand];
                $_SESSION["word"] = $guess;
            }
            if(isset($_SESSION["level"]) && $_SESSION["level"] == "Medium"){
                $rand = rand(6, 11);
                $guess = $file[$rand];
                $_SESSION["word"] = $guess;
            }
            if(isset($_SESSION["level"]) && $_SESSION["level"] == "Hard"){
                $rand = rand(12, 17);
                $guess = $file[$rand];
                $_SESSION["word"] = $guess;
            }
            /*$key = rand(0 , count($file) - 1);
            $_SESSION["word"] = $file[$key];*/
        }
            return $_SESSION["word"];
    }

    function getAllCurrentLetter(){
        return isset($_SESSION["responses"]) ? $_SESSION["responses"] : [];
    }

    function addLetter($letter){
        $response = getAllCurrentLetter();
        array_push($response, $letter);
        $_SESSION["responses"] = $response;
    }

    

    function isLetterCorrect($letter){
        $guess = getCurrentWord();
        $max_guess = strlen($guess);
        for($i = 0; $i < $max_guess; $i++){
            if($letter == $guess[$i]){
                return true;
            }
        }
        return false;
    }

    function isWordComplete(){
        $guess = getCurrentWord();
        $response = getAllCurrentLetter();
        $max_guess = strlen($guess);
        for($i = 0; $i < $max_guess; $i++){
            if(!in_array($guess[$i], $response)){
                return /*$_SESSION["wordcomplete"] =*/ false;
            }
        }
        return true;
    }

    function isGameComplete(){
        if(isWordComplete()){
            return true;
        }
        elseif(isBodyComplete()){
            return true;
        }
        return /*isset($_SESSION["gamecomplete"]) ? $_SESSION["gamecomplete"] :*/ false;
    }

    function gameCompleted(){
        if(isGameComplete()){
            return true;
        } 
        return /*$_SESSION["gamecomplete"] =*/ false ;
    }

    function isBodyComplete(){
        $part = getParts();
        if(count($part) <= 1) {
            return true;
        }
        return false;
    }


    function getCurrentPic($part) {
        return "hangman_" . $part . ".png";
    }

    function getParts(){
        global $body_parts;
        return isset($_SESSION["part"]) ? $_SESSION["part"] : $body_parts;
    }

    function getCurrentPart(){
        $part = getParts();
        return $part[0];
    }

    function addPart(){
        $part = getParts();
        array_shift($part);
        $_SESSION["part"] = $part;
    }

    function reStart(){ 
        unset($_SESSION["word"]);
        unset($_SESSION["part"]);
        unset($_SESSION["responses"]);
        $GAME_OVER = false;
        
        
    }

    if(isset($_POST["letter_guess"])) {
        $letter = isset($_POST["letter_guess"]) ? $_POST["letter_guess"] : null;
        addLetter($letter);
        if(isLetterCorrect($letter) ) {
            /*addLetter($letter);*/
            if(isWordComplete()){
                $GAME_OVER = true;
                gameCompleted();
                
            }
        }
        else{
            if(!isBodyComplete()){
                addPart();
                if(isBodyComplete()){
                    gameCompleted();
                }
            }
            /*else{
                gameCompleted();
            }*/
        }
    }

    

    if(isset($_POST["restart"])){
        reStart();
        //header("location:main.php");
        //exit;
    }
    if(isset($_POST["reset"])){
        unset($_SESSION["word"]);
        header("location:main.php");
        exit;
    }
    if(isset($_POST["log_out"])){
        session_destroy();
        header("location:login.php");
        exit;

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman Game: game</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<div id=container>
    <h1>Hangman Game</h1>
    <p>Welcome, <?php echo $_SESSION["user_name"] ?></p>
    <p>you pick <?php echo $_SESSION["level"] ?> level</p>
    <img width="200px" src=" <?php echo getCurrentPic(getCurrentPart()) ?>" alt="hangman"> <br><br>
    <?php
                $guess = getCurrentWord();
                echo $guess;
                $max_guess = strlen($guess);
                
                
                for($i =0; $i < $max_guess; $i++): 
                $letter = $guess[$i] ?>
                <?php if(in_array($letter, getAllCurrentLetter())): ?>
                <span id="underline"> <?php echo $letter ?></span>
                <?php else : ?>
                <span id="underline">&nbsp;&nbsp;&nbsp;</span>
                <?php endif; ?>
            <?php endfor; ?>
            <br><br>
            <p> Guess a letter</p> <br>
            <form action="" method="post">
                <?php
                    for($i = 1; $i <= 26; $i++): 
                        $letter = chr($i + 64);
                ?>
                    <span> <input type="submit" name="letter_guess" value="<?=$letter?>" > </span>
                        
                <?php
                    /*if($i % 6 == 0) {
                        echo "<br>";
                        }*/
                    endfor;
                ?>
                
                <input type="submit" name="restart" value="New Word">
                <input type="submit" name="reset" id="">
                <input type="submit" name="log_out" value="Log Out">
            </form>
            <?php if(gameCompleted()): ?>
                    <h1>Game Completed</h1>
            <?php endif; ?>
            <?php if($GAME_OVER && gameCompleted()): ?>
                <p>you won</p>
                
            <?php elseif(!$GAME_OVER && gameCompleted()): ?>
                <p>you lose</p>
            <?php endif; ?>
            
</div>             
</body>
</html>


