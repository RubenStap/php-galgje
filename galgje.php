<?php
session_start();


$woord = "";
if (isset($_SESSION['try'])) {
    $try = $_SESSION['try'];
} else {
    $_SESSION['try'] = 1;
    $try = 1;
}

if ($try == 6) {
    echo "<h1>Je hebt verloren!</h1>";
    echo "<h2>Het woord was: " . $_SESSION['woord'] . "</h2>";
    session_destroy();
    header("Refresh:5; url=index.php", true, 303);
} elseif (isset($_SESSION['responses']) && !in_array("&nbsp;", $_SESSION['responses'])) {
    echo "<h1>Je hebt gewonnen!</h1>";
    session_destroy();
    header("Refresh:5; url=index.php", true, 303);
}

if (isset($_POST["reset"])) {
    session_destroy();
    header("Refresh:0; url=index.php", true, 303);
}

if (isset($_SESSION['woord'])) {
    $woord = strtolower($_SESSION['woord']);
} else {
    echo "Woord is niet ingesteld.";
}

$maxletters = strlen($woord);
$letters = "abcdefghijklmnopqrstuvwxyz";

if (!isset($_SESSION['responses'])) {
    $_SESSION['responses'] = array_fill(0, $maxletters, "&nbsp;");
}

if (isset($_GET['lp'])) {
    header("Refresh:0; url=galgje.php", true, 303);
    $gebruikteletter = strtolower($_GET['lp']);
    if (!isset($_SESSION['gebruikteletters'])) {
        $_SESSION['gebruikteletters'] = [];
    }

    if (in_array($gebruikteletter, $_SESSION['gebruikteletters'])) {
        echo "De letter " . $gebruikteletter . " is al gebruikt.";
    } else {
        $_SESSION['gebruikteletters'][] = $gebruikteletter;
        $found = false;

        for ($i = 0; $i < $maxletters; $i++) {
            if ($woord[$i] == $gebruikteletter) {
                $_SESSION['responses'][$i] = $gebruikteletter;
                $found = true;
            }
        }

        if (!$found) {
            echo "De letter " . $gebruikteletter . " zit niet in het woord.";
            $try++;
            $_SESSION['try'] = $try;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galgje</title>
    <link rel="stylesheet" href="style.css">
</head>


<body>
    <h1>Hangman the game</h1>
    <form method='post'>
    </form>
    <div class="main-container">
        <div class="main-container">

            <div class="game-picture">
                <?php
                $image = [
                    "<img src='images/galg-0.png' alt='hangman'>", "<img src='images/galg-1.png' alt='hangman'>", "<img src='images/galg-2.png' alt='hangman'>",
                    "<img src='images/galg-3.png' alt='hangman'>", "<img src='images/galg-4.png' alt='hangman'>", "<img src='images/galg-5.png' alt='hangman'>",    
                     "<img src='images/galg-6.png' alt='hangman'>",
                ];

                echo $image[$try];
                ?>
            </div>
            <div class="game-info">
                <div class="letter-buttons">
                    <form method="get">
                        <?php
                        $max = strlen($letters) - 1;

                        // Ensure $_SESSION['gebruikteletters'] is an array
                        if (!isset($_SESSION['gebruikteletters']) || !is_array($_SESSION['gebruikteletters'])) {
                            $_SESSION['gebruikteletters'] = array();
                        }

                        for ($i = 0; $i <= $max; $i++) {
                            if (in_array($letters[$i], $_SESSION['gebruikteletters'])) {
                                echo "<button disabled class='gebruikt' type='submit' name='lp' value='" . $letters[$i] . "'>" . $letters[$i] . "</button>";
                            } else {
                                echo "<button  class='speelbutton' type='submit' name='lp' value='" . $letters[$i] . "'>" . $letters[$i] . "</button>";
                            }
                        }

                        ?>
                    </form>
                </div>
            </div>

        </div>

        <div style="margin-top:20px; padding:15px; text-align:center;">
            <?php
            if (!isset($_SESSION['responses']) || !is_array($_SESSION['responses'])) {
                $_SESSION['responses'] = array_fill(0, $maxletters, "&nbsp;");
            }

            foreach ($_SESSION['responses'] as $response) {
                echo "<span style='font-size:35px; border-bottom:3px solid; margin-right:5px;'>" . $response . "</span>";
            }
            //gebruikte letters
            echo "<p>Gebruikte letters: ";
            if (isset($_SESSION['gebruikteletters'])) {
                foreach ($_SESSION['gebruikteletters'] as $gebruikteletter) {
                    echo $gebruikteletter . " ";
                }
            }
            ?>
        </div>  
        <div style="display: flex; justify-content: center;">
        <form method="post">
        <button type='submit' name='reset' class="reset_button">Reset</button>
        </form>
        </div>



</body>

</html>
