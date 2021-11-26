<?php
    $errors = [];

    $name = htmlspecialchars($_POST['name'] ?? '');
    $new = htmlspecialchars($_POST['new'] ?? '');
    $text = htmlspecialchars($_POST['text'] ?? '');
    $picture = $_POST['picture'] ?? '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($name);
        $new = trim($new);
        $text = trim($text);


        if ($name === '') {
            $errors[] = 'Bitte geben Sie einen Namen ein.';
        }
        if ($new === '') {
            $errors[] = 'Bitte geben Sie Titel ein.';
        }
        if ($text === '') {
            $errors[] = 'Bitte geben Sie einen Text ein.';
        }
        if (filter_var('keine://domain', FILTER_VALIDATE_URL) !== false & $picture !== "") {
            $errors[] = 'Bitte geben Sie eine gültige URL ein';
        }
        else{
            $dbConnection = new PDO('mysql:host=localhost;dbname=wordpress', 'root', '');
            $stmt = $dbConnection->prepare('INSERT INTO blog (created_by, post_title, post_text, picture, created_at) 
                                            VALUES (:name, :new, :text,  :picture, now())');
        

          $stmt->execute([':name' => $name, ':new' => $new, ':text' => $text, ':picture' => $picture]);
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newblog.css">
    <title>Homepage</title>
</head>
<body class = container>


    
    <div class = title>

    <h1>Blog von Janis</h1>
    <h2>Einen neuen Beitrag schreiben</h2>

    </div>

    <ul class = nav>
        <a href = "index.php"><li>Alle Blogs</li></a>
        <a href = "newblog.php"><li >Blog erstellen</li></a>
    </ul>

    <div class = blogs>

     <div class = "formular">

        <form action = "newblog.php" method = "post">

            <div class = form>
            <label for = "name">Ihr Name</label><br>
            <input type = "text" id = "name" name = "name" value="<?= $name ?? '' ?>"><br>
            </div>

            <div class = form>
            <label for = "new">Titel des Beitrags</label><br>
            <input type = "text" id = "new" name = "new" value="<?= $new ?? '' ?>"><br>
            </div>

            <div class = form>
            <label for = "text">Ihr Text</label><br>
            <textarea name="text" id="text" rows="5"></textarea>><br>
            </div>

            <div class = form>
            <label for = "picture">Bild</label><br>
            <input type = "text" id = "picture" name = "picture" value="<?= $picture ?? '' ?>"><br>
            </div>

            <div class = form>
            <input class = "btn btn.primary" type = "submit" value = "hochladen">

            <a href = "index.php">abbrechen</a>

            
            <?php if (count($errors) > 0) { ?>
                <div class="error-box">
                    <ul>
                        <?php foreach ($errors as $error) { ?>
                            <li><?= $error ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            </div>
        
                        

        </form>

     </div>

    </div>
</body>
</html>