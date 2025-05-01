<?php
require 'config.php';  // Include database/session config

// Redirect to login if not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Library Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navigation bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Library System</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="books.php">Books</a></li>
        <li class="nav-item"><a class="nav-link" href="members.php">Members</a></li>
        <li class="nav-item"><a class="nav-link" href="borrow.php">Borrow Book</a></li>
        <li class="nav-item"><a class="nav-link" href="return.php">Borrowed Books</a></li>
        <li class="nav-item"><a class="nav-link" href="report.php">Reports</a></li>
      </ul>
      <span class="navbar-text">
        Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?> |
        <a href="logout.php" class="text-light">Logout</a>
      </span>
    </div>
  </div>
</nav>
<div class="container mt-4">
