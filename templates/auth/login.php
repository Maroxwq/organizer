<?php
/** @var Org\Model\User $user */
$errors = $user->getErrors();
$this->setGlobalVar('title', 'Organizer - Login');
?>

<form method="POST" action="/login">
    <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>
    <?php if (!empty($errors['email'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars(is_array($errors['email']) ? $errors['email'][0] : $errors['email']) ?>
        </div>
    <?php endif; ?>
    <div class="form-floating mb-3">
        <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="<?= htmlspecialchars($user->getEmail()) ?>">
        <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating mb-3">
        <input name="passwordPlain" type="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted text-center">&copy; 2025</p>
    <p class="text-center"><a href="<?= $this->url('auth/register') ?>">Register here</a></p>
</form>
