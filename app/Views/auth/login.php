<?php $session = session(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>
<body>
  <?php if ($session->getFlashdata('error')): ?>
    <div class="error"><?= esc($session->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <div>
    <h1>Welcome to the Login Page</h1>
    <p>Please enter your credentials to access your account.</p>
  </div>

  <div class="loginform">
    <h1>Login</h1>
    <form action="/login" method="post">
      <?php if (function_exists('csrf_field')) echo csrf_field(); ?>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
