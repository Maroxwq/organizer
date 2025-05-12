<?php
/** @var Org\Model\User $user */
$this->setGlobalVar('title', 'Organizer - Register');
?>

<form method="POST" action="/register">
    <h1 class="h3 mb-3 fw-normal text-center">Register</h1>
    <div class="form-floating mb-3">
        <input name="email" type="email" class="form-control <?= $user->hasError('email') ? ' is-invalid' : '' ?>" id="floatingEmail" placeholder="name@example.com" value="<?= htmlspecialchars($user->getEmail()) ?>">
        <label for="floatingEmail">Email address</label>
        <?php if ($user->hasError('email')): ?>
            <div class="invalid-feedback"><?= htmlspecialchars($user->getError('email')) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-floating mb-3">
        <input name="passwordPlain" type="password" class="form-control <?= $user->hasError('passwordPlain') ? ' is-invalid' : '' ?>" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
        <?php if ($user->hasError('passwordPlain')): ?>
            <div class="invalid-feedback"><?= htmlspecialchars($user->getError('passwordPlain')) ?></div>
        <?php endif; ?>
    </div>

    <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Register</button>
    <p class="mt-5 mb-3 text-muted text-center">&copy; 2025</p>
    <p class="text-center"><a href="<?= $this->url('auth/login') ?>">Sign in here</a></p>
</form>
