<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <div>
    <h1>Welcome to the Login Page</h1>
    <p>Please enter your credentials to access your account.</p>
  </div>
  <div class="loginform">
    <h1>Login</h1>
    <form action="login.php" method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

  </div>
</body>
</html>