<body>
    <link rel="stylesheet" href="css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <?php
        if ($_SERVER['PHP_SELF'] == '/index.php') {
            $mainun = true;
        } elseif ($_SERVER['REQUEST_URI'] == '/Main'){
            $mainun = true;
        } elseif ($_SERVER['REQUEST_URI'] == '/Notes'){
            $noteun = true;;
        } elseif ($_SERVER['REQUEST_URI'] == '/About'){
            $aboutun = true;;
        }
    ?>

    <div class="header">
        <div class="section">
            <h1 class="logo">ORGANIZER</h1>
        </div>
        
        <div class="section">
            <div class="hbutton <?= $mainun ? 'mainun' : '' ?>"><a href="Main">Main</a></div>
            <div class="hbutton <?= $noteun ? 'notesun' : '' ?>"><a href="Notes">Notes</a></div>
            <div class="hbutton <?= $aboutun ? 'aboutun' : '' ?>"><a href="About">About</a></div>
            <button class="hbutton"><a href="login.php" class="login">Login</a></button>
        </div>
    </div>
</body>