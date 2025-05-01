<?php
// forgot_password.php
require 'config.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $new1    = $_POST['new_password'];
    $new2    = $_POST['confirm_password'];
    
    if (empty($username) || empty($new1) || empty($new2)) {
        $error = "All fields are required.";
    }
    elseif ($new1 !== $new2) {
        $error = "Passwords do not match.";
    }
    else {
        // verify username exists
        $res = $conn->query("SELECT * FROM Admins WHERE username='$username'");
        if ($res && $res->num_rows === 1) {
            // update password
            $pw = $conn->real_escape_string($new1);
            if ($conn->query("UPDATE Admins SET password='$pw' WHERE username='$username'")) {
                $success = "Password reset successfully. You may now log in.";
            } else {
                $error = "Database error: " . $conn->error;
            }
        } else {
            $error = "Username not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card shadow" style="width: 400px;">
      <div class="card-body">
        <h3 class="card-title text-center mb-4">Reset Password</h3>
        <?php if ($error): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif ($success): ?>
          <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Admin Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100" type="submit">Reset Password</button>
        </form>
        <div class="text-center mt-3">
          <a href="index.php">Back to Login</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
