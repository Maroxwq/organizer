<form method="POST" action="/register">
    <h1 class="h3 mb-3 fw-normal text-center">Register</h1>

    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                <?php foreach ((array)$errors as $error): ?>
                    <li><?= htmlspecialchars(is_array($error) ? implode(' | ', $error) : $error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-floating">
        <input name="email" class="form-control rounded-top" id="floatingEmail" placeholder="name@example.com" value="<?= htmlspecialchars($email ?? '') ?>">
        <label for="floatingEmail">Email address</label>
    </div>
    <div class="form-floating">
        <input name="password" type="password" class="form-control rounded-bottom" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Register</button>
    <p class="mt-5 mb-3 text-muted text-center">&copy; 2025</p>
    <p class="text-center"><a href="/login">Sign in here</a></p>
</form>
