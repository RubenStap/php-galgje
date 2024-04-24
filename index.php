<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kies je woord</title>
    <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <header>
        <h1>Welkom bij hangman</h1>
        </header>

        <p>Wat is het woord?</p>
        <form method="POST">
            <input class="speelbutton" type="text" name="woord" />
            <button class="speelbutton" type="submit" name="speel">Speel!</button>
            <button class="speelbutton" type="submit" name="random">Random woord</button>
        </form>

        </div>
        <?php
        session_start();

        $randomwoord = ["apple", "banana", "orange", "elephant", "giraffe", "computer", "keyboard",
         "programming", "python", "language", "chocolate", "elephant", "sunshine", "moonlight", "umbrella",
          "watermelon", "happiness", "laughter", "mountain", "ocean", "adventure", "beautiful", "courage", "delicious",
           "fantastic", "inspiration", "jubilation", "kindness", "lighthouse", "magnificent", "notebook", "optimistic",
            "peaceful", "quizzical", "radiant", "spectacular", "tranquil", "universe", "vibrant", "whisper", "xylophone",
             "yesterday", "zeppelin"];

        if (isset($_POST["speel"])) {
            if (!empty($_POST["woord"])) {
                $_SESSION['woord'] = $_POST["woord"];
                echo "<p>Je hebt gekozen voor het woord: " . $_SESSION['woord'] . "</p>";
                header("Location: galgje.php");
            }
            echo "er is geen woord gekozen";
        } elseif (isset($_POST["random"])) {
            $_SESSION['woord'] = $randomwoord[rand(0, count($randomwoord) - 1)];
            header("Location: galgje.php");
            echo "<p>Je hebt gekozen voor het willekeurige woord: " . $_SESSION['woord'] . "</p>";
        }
        ?>


    </body>

</html>
