<?php
require 'config.php';
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        $sql = "SELECT * FROM Admins WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows === 1) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - Library System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('https://images.unsplash.com/photo-1581093588401-ff05a2861c30?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
      background-size: cover;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.55);
      z-index: 0;
    }

    .login-wrapper {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 400px;
    }

    .card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 1rem;
      padding: 2rem;
    }

    .btn-primary {
      background-color: #0069d9;
      border-color: #0062cc;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .text-shadow {
      text-shadow: 1px 1px 2px #000;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>
  <div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="login-wrapper">
      <div class="card shadow-lg">
        <h3 class="card-title text-center mb-4">📚 Admin Login</h3>
        <?php if ($error): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
          </div>
          <button class="btn btn-primary w-100" type="submit">Login</button>
          <div class="text-center mt-3">
            <a href="forgot_password.php">Forgot password?</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
