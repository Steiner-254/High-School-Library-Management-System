<?php
require 'config.php';
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'header.php';

// Count total books
$res = $conn->query("SELECT COUNT(*) AS total_books FROM Books");
$books_count = $res->fetch_assoc()['total_books'];

// Count total members
$res = $conn->query("SELECT COUNT(*) AS total_members FROM Members");
$members_count = $res->fetch_assoc()['total_members'];

// Count borrowed (not returned) books
$res = $conn->query("SELECT COUNT(*) AS total_borrowed FROM BorrowedBooks WHERE return_date IS NULL");
$borrowed_count = $res->fetch_assoc()['total_borrowed'];
?>

<h2>Dashboard</h2>
<div class="row">
  <div class="col-md-4">
    <div class="card text-white bg-primary mb-3">
      <div class="card-body">
        <h5 class="card-title">Books</h5>
        <p class="card-text fs-4"><?php echo $books_count; ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-white bg-success mb-3">
      <div class="card-body">
        <h5 class="card-title">Members</h5>
        <p class="card-text fs-4"><?php echo $members_count; ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-white bg-warning mb-3">
      <div class="card-body">
        <h5 class="card-title">Books Borrowed</h5>
        <p class="card-text fs-4"><?php echo $borrowed_count; ?></p>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
