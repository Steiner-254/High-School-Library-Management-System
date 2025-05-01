<?php
include 'header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $publisher = $conn->real_escape_string($_POST['publisher']);
    $year = intval($_POST['year']);
    $total_copies = intval($_POST['total_copies']);
    
    // Validate required fields
    if (empty($title) || empty($author) || $total_copies <= 0) {
        $error = "Title, author, and total copies are required, and copies must be > 0.";
    } else {
        // Insert into database
        $available_copies = $total_copies;
        $sql = "INSERT INTO Books (title, author, publisher, year, total_copies, available_copies) VALUES ('$title', '$author', '$publisher', $year, $total_copies, $available_copies)";
        if ($conn->query($sql) === TRUE) {
            $success = "Book added successfully.";
        } else {
            $error = "Error adding book: " . $conn->error;
        }
    }
}
?>

<h2>Add New Book</h2>
<?php if ($error): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<form method="POST" action="add_book.php">
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Author</label>
    <input type="text" name="author" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Publisher</label>
    <input type="text" name="publisher" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Year</label>
    <input type="number" name="year" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Total Copies</label>
    <input type="number" name="total_copies" class="form-control" min="1" value="1" required>
  </div>
  <button type="submit" class="btn btn-success">Add Book</button>
  <a href="books.php" class="btn btn-secondary">Back to Books</a>
</form>

<?php include 'footer.php'; ?>
