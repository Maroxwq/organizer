<head><link href="/css/bootstrap.css" rel="stylesheet"></head>

<body class="bg-body-tertiary">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <main class="form-signin w-100" style="max-width: 330px;">
            <form method="POST" action="/login">
                <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>

                <?php if ($error = $this->session()->getFlash('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            <?php foreach (explode('|', $error) as $message): ?>
                            <li><?= htmlspecialchars(trim($message)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="form-floating">
                    <input name="email" type="email" class="form-control rounded-top" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating">
                    <input name="password" type="password" class="form-control rounded-bottom" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Sign in</button>
                <p class="mt-5 mb-3 text-muted text-center">&copy; 2025</p>
                <p class="text-center"><a href="/register">Register here</a></p>
            </form>
        </main>
    </div>
</body>
