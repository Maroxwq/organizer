<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        if ($_SERVER['REQUEST_URI'] == '/index.php') {
            $mainun = true;
        } elseif ($_SERVER['REQUEST_URI'] == '/notes.php'){
            $noteun = true;;
        } elseif ($_SERVER['REQUEST_URI'] == '/about.php'){
            $aboutun = true;;
        }
    ?>

    <div class="header">
        <div class="section">
            <h1 class="logo">ORGANIZER</h1>
        </div>
        
        <div class="section">
            <div class="hbutton <?= $mainun ? 'mainun' : '' ?>"><a href="index.php">Main</a></div>
            <div class="hbutton <?= $noteun ? 'notesun' : '' ?>"><a href="notes.php">Notes</a></div>
            <div class="hbutton <?= $aboutun ? 'aboutun' : '' ?>"><a href="about.php">About</a></div>
            <button class="hbutton"><a href="login.php" class="login">Login</a></button>
        </div>
    </div>
</body>
</html>