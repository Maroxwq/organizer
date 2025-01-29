<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="/css/newStyle.css"> -->
    <link rel="stylesheet" href="/css/bootstrap.css">
    <title><?=$title ?? 'Organizer'?></title>
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid d-flex align-items-center">
            <a class="navbar-brand text-dark fs-2 p-0" href="/notes">ORGANIZER</a>

            <div class="d-flex">
                <a href="/about" class="nav-link active text-dark pb-0 fs-5">About</a>
                <a href="/notes" class="nav-link active text-dark pb-0 fs-5">Notes</a>
            </div>

            <a href="/login" class="btn btn-dark ms-auto" style="width: 100px;">Login</a>
        </div>
    </nav>
    <div class="container">
        <?= $content ?>
    </div>
</body>
</html>
