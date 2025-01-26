<?php
include('authenticate.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voice of Change - Login & Signup</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Basic Styles */
body {
  font-family: 'Arial', sans-serif;
  background-color: #f4f4f9;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  /* max-width: 900px; */
  width: 100%;
}

.form-container {
  background-color: #fff;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
  width: 400px;
  padding: 30px;
  display: none;
  transition: all 0.3s ease;
}

.form-container h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #343a40;
}

.input-group {
  margin-bottom: 20px;
}

.input-group label {
  font-size: 1.1rem;
  color: #343a40;
  margin-bottom: 5px;
  display: block;
}

.input-group input {
  width: 100%;
  padding: 10px;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.btn {
  width: 100%;
  padding: 12px;
  background-color: #343a40;
  color: #fff;
  border: none;
  font-size: 1.2rem;
  border-radius: 5px;
  cursor: pointer;
}

.btn:hover {
  background-color: #495057;
}

.switch-form {
  text-align: center;
  margin-top: 15px;
}

.switch-form a {
  color: #343a40;
  text-decoration: none;
  font-weight: bold;
}

.switch-form a:hover {
  text-decoration: underline;
}

/* Show the active form */
#login-form-container {
  display: block;
}

#signup-form-container {
  display: none;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
  .container {
    flex-direction: column;
  }
  .form-container {
    width: fit-content;
    margin-bottom: 20px;
  }
}

  </style>
</head>
<body>
  <div class="container">
    
    <div class="form-container" id="login-form-container">
      <h2>Admin Login</h2>
      <form action="" method="POST">
        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn" name="login">Login</button>
      </form>
    </div>

</body>
</html>
