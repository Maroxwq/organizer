<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title><?= $title ?? 'Organizer' ?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-lg">
        <div class="container-fluid d-flex align-items-center">
            <a class="navbar-brand fs-2 p-0" href="/notes">ORGANIZER</a>

            <div class="d-flex">
                <a href="/about" class="nav-link active pb-0 fs-5">About</a>
                <a href="/notes" class="nav-link active pb-0 fs-5">Notes</a>
                <a href="/posts" class="nav-link active pb-0 fs-5">Forum</a>
            </div>

            <?php if ($this->webUser()->isAuthenticated()): ?>
                <div class="dropdown ms-auto">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">Hello, <?= htmlspecialchars($this->webUser()->getIdentity()->getName()) ?></button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/logout">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="/login" class="btn btn-dark ms-auto" style="width: 100px;">Login</a>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container">
        <?= $content ?>
    </div>
</body>
</html>
