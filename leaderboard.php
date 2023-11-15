<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman Game: leaderboard </title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <h1>The Hangman Game</h1>
    <div class=login>
        <h2>Leader Board</h2>
        
        <?php
            $file = file("leaderboard.txt", FILE_IGNORE_NEW_LINES);
            $array = array();
            for($i = 0; $i < count($file); $i++){
                $line = explode(",", $file[$i]);
                $array[$line[0]] = $line[1];
            }
            arsort($array);

            $html = '<table>';
            $html .= '<tr>';
            $html .= '<th> Name </th>';
            $html .= '<th> Score </th>';
            $html .= '</tr>';
        
            foreach($array as $key => $val){                
                $html .= '<tr>';
                $html .= '<td>' . $key . '</td>';
                $html .= '<td>' . $val . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';

            echo $html;      
        ?>
        
        <p> <a href="main.php"> Back to main page</a> </p>
                    

        </div>
    
</body>
</html>

