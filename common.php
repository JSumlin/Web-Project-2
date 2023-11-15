<?php
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
        }
            return $_SESSION["word"];
    }

    function getAllCorrectLetter(){
        return isset($_SESSION["responses"]) ? $_SESSION["responses"] : [];
    }

    function addLetter($letter){
        $response = getAllCorrectLetter();
        array_push($response, $letter);
        $_SESSION["responses"] = $response;    
    }

    function getAllUsedLetter(){
        return isset($_SESSION["used_letter"]) ? $_SESSION["used_letter"] : [];
    }

    function addUsedLetter($letter){
        $response = getAllUsedLetter();
        array_push($response, $letter);
        $_SESSION["used_letter"] = $response;
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
        $response = getAllCorrectLetter();
        $max_guess = strlen($guess);
        for($i = 0; $i < $max_guess; $i++){
            if(!in_array($guess[$i], $response)){
                return false;
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
        return false;
    }

    function gameCompleted(){
        if(isGameComplete()){
            return true;
        } 
        return false ;
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
        unset($_SESSION["used_letter"]);
        unset($_SESSION["incorrect_guess"]);
        $GAME_OVER = false;
    }
?>