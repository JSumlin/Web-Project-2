<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles-menu.css">
</head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman Game</title>

    <body>
    
    <?php
        // Initialize the word and guesses
        $word = "hangman";
        $correctGuesses = [];
        $incorrectGuesses = [];

        // Process the form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $selectedLetter = strtoupper($_POST["letter"]);

            // Validate the selected letter
            if (ctype_alpha($selectedLetter)) {
                if (in_array($selectedLetter, str_split($word))) {
                    $correctGuesses[] = $selectedLetter;
                } else {
                    $incorrectGuesses[] = $selectedLetter;
                }
            }
        }
    ?>

    <h1>Hangman Game</h1>

    <div id="word-container">
        <?php
            // Display the word with guessed letters
            foreach (str_split($word) as $letter) {
                if (in_array(strtoupper($letter), $correctGuesses)) {
                    echo $letter . ' ';
                } else {
                    echo in_array(strtoupper($letter), $correctGuesses) ? $letter . ' ' : '_ ';
                }
            }
        ?>
    </div>

    <div id="guesses-container">
        <p>Correct Guesses: <?php echo implode(', ', $correctGuesses); ?></p>
        <p>Incorrect Guesses: <?php echo implode(', ', $incorrectGuesses); ?></p>
    </div>

    <div id="alphabet-container">
        <form method="post">
            <?php
                // Display the alphabet for letter selection
                foreach (range('A', 'Z') as $letter) {
                    $disabled = in_array($letter, array_merge($correctGuesses, $incorrectGuesses)) ? 'disabled' : '';
                    echo "<button class='letter $disabled' name='letter' value='$letter'>$letter</button>";
                }
            ?>
        </form>
    </div>

    <div id="result">
        <?php
            // Check if the word is guessed
            $wordGuessed = true;
            foreach (str_split($word) as $letter) {
                if (!in_array(strtoupper($letter), $correctGuesses)) {
                    $wordGuessed = false;
                    break;
                }
            }

            // Display the result
            if ($wordGuessed) {
                echo "<p>Congratulations! You guessed the word!</p>";
            } else {
                echo "<p>Keep trying!</p>";
            }
        ?>
    </div>
    
    </body>
</html>