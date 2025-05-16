<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Organizer' ?></title>
    <link href="/css/bootstrap.css" rel="stylesheet">
</head>

<body class="bg-body-tertiary">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="w-100 p-4" style="max-width: 420px; min-height: 460px;">
            <?= $content ?>
        </div>
    </div>
</body>
</html>
