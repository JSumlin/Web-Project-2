<?php
    session_start();
    include("common.php");
    $GAME_OVER = false;
    $body_parts = ["none", "head", "body", "left_arm", "right_arm", "left_leg", "right_leg"];
    
    if(isset($_POST["letter_guess"])) {
        $letter = isset($_POST["letter_guess"]) ? $_POST["letter_guess"] : null;
        addUsedLetter($letter);
        if(isLetterCorrect($letter) ) {
            addLetter($letter);
            print_r(getAllCorrectLetter());
            if(isWordComplete()){
                $GAME_OVER = true;
                gameCompleted();
                $_SESSION["score"]++;
                
            }
        }
        else{
            if(!isBodyComplete()){
                $_SESSION["incorrect_guess"]++;
                addPart();
                if(isBodyComplete()){
                    gameCompleted();
                }
            }
        }
    }

    if(isset($_POST["new_word"])){
        reStart();
    }

    if(isset($_POST["main_menu"])){
        reStart();
        header("location:main.php");
        exit;
    }

    if(isset($_POST["log_out"])){
        session_destroy();
        header("location:login.php");
        exit;
    }

    if(isset($_POST["save"])){
        if(isset($_SESSION["user_name"])){
            $file_name = 'leaderboard.txt';
            $user_name = $_SESSION["user_name"];
            $score = $_SESSION["score"];
            
            $file = file($file_name, FILE_IGNORE_NEW_LINES);
        
            $write = fopen($file_name, "w");

            foreach($file as $line){
                if(!strstr($line, $user_name)){
                    fputs($write, "$line\n");
                }
            }
            fclose($write);

            $append = fopen($file_name, "a") or die('Cannot open file ' . $file_name);
            fwrite($append, "$user_name,$score\n");
            fclose($append);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman Game: game</title>
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

    <div class="game"> 
        <div class="hangman">
            <p>Welcome, <?php echo $_SESSION["user_name"] ?></p>
            <p>Level: <?php echo $_SESSION["level"] ?></p>
            <p>Score: <?php echo $_SESSION["score"] ?> </p> <br>
            <img src=" <?php echo getCurrentPic(getCurrentPart()) ?>" alt="hangman"> <br><br>
        </div>
        <div class="display">
            <div class="letter">
<?php           $guess = getCurrentWord();
                $max_guess = strlen($guess);
                    
                for($i =0; $i < $max_guess; $i++): 
                    $letter = $guess[$i] ?>
<?php               if(in_array($letter, getAllCorrectLetter())): ?>
                        <span class="underline"> <?php echo $letter ?></span>
<?php               else: ?>
                        <span class="underline">&nbsp;&nbsp;&nbsp;</span>
<?php               endif; ?>
<?php           endfor; ?>
                <br>
            </div>
                <p>Incorrect guesses: <?php  echo $_SESSION["incorrect_guess"]; ?> / 6 </p> <br>
                <p> Guess a letter</p>
            <div class="keyboard">
             
                <form action="" method="post">
<?php               for($i = 1; $i <= 26; $i++): 
                        $letter = chr($i + 64);
                        
                        if(!gameCompleted()) {
                            if(in_array($letter, getAllUsedLetter())){
?>
                                <button disabled name="letter_guess" value="<?php echo $letter ?>"> <?php echo $letter ?> </button>
                        
<?php                       }
                            else{ ?>
                                <button name="letter_guess" value="<?php echo $letter ?>"> <?php echo $letter ?> </button>
<?php                       }
                        }
                        else{ ?>
                            <button disabled name="letter_guess" value="<?php echo $letter ?>"> <?php echo $letter ?> </button>
<?php                   }
                    endfor; ?>    
                </form>
                <form action="" method="post">
                    <input type="submit" name="main_menu" value="Main Menu">
                    <input type="submit" name="log_out" value="Log Out">
                    <input type="submit" name="save" value="Save">
                </form>
            </div> 
            <?php if(gameCompleted()): ?>
                    <h2>Game Completed</h2> <br>
            <?php endif; ?>
            <?php if($GAME_OVER && gameCompleted()): ?>
                <h4>You Found the word <?php echo $_SESSION["word"] ?> </h4>  <br>
                <form action="" method="post">
                    <input type="submit" name="new_word" value="New Word">
                    <input type="submit" name="main_menu" value="Main Menu">
                    <input type="submit" name="log_out" value="Log Out">
                    <input type="submit" name="save" value="Save">
                </form>
                
            <?php elseif(!$GAME_OVER && gameCompleted()): ?>
                <h4>You Not Found the word <?php echo $_SESSION["word"] ?></h4><br>
                <form action="" method="post">
                    <input type="submit" name="new_word" value="New Word">
                    <input type="submit" name="main_menu" value="Main Menu">
                    <input type="submit" name="log_out" value="Log Out">
                    <input type="submit" name="save" value="Save">
                </form>
            <?php endif; ?>
        </div>
    </div>     
</body>
</html>

