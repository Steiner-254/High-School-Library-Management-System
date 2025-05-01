<?php
include 'header.php';

$error = '';
$success = '';

// Get book ID from URL
$id = intval($_GET['id']);

// Fetch book details
$res = $conn->query("SELECT * FROM Books WHERE id=$id");
if ($res->num_rows !== 1) {
    echo "<div class='alert alert-danger'>Book not found.</div>";
    include 'footer.php';
    exit;
}
$book = $res->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $publisher = $conn->real_escape_string($_POST['publisher']);
    $year = intval($_POST['year']);
    $total_copies = intval($_POST['total_copies']);
    $available_copies = intval($_POST['available_copies']);

    // Ensure available_copies is not greater than total_copies
    if ($available_copies > $total_copies) {
        $error = "Available copies cannot exceed total copies.";
    } elseif (empty($title) || empty($author) || $total_copies <= 0) {
        $error = "Title, author, and total copies are required, and copies must be > 0.";
    } else {
        // Update book record
        $sql = "UPDATE Books SET 
                    title='$title', author='$author', publisher='$publisher', 
                    year=$year, total_copies=$total_copies, available_copies=$available_copies 
                WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $success = "Book updated successfully.";
        } else {
            $error = "Error updating book: " . $conn->error;
        }
    }
}
?>

<h2>Edit Book</h2>
<?php if ($error): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<form method="POST" action="edit_book.php?id=<?php echo $id; ?>">
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($book['title']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Author</label>
    <input type="text" name="author" class="form-control" value="<?php echo htmlspecialchars($book['author']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Publisher</label>
    <input type="text" name="publisher" class="form-control" value="<?php echo htmlspecialchars($book['publisher']); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Year</label>
    <input type="number" name="year" class="form-control" value="<?php echo $book['year']; ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Total Copies</label>
    <input type="number" name="total_copies" class="form-control" min="1" value="<?php echo $book['total_copies']; ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Available Copies</label>
    <input type="number" name="available_copies" class="form-control" min="0" value="<?php echo $book['available_copies']; ?>" required>
  </div>
  <button type="submit" class="btn btn-success">Update Book</button>
  <a href="books.php" class="btn btn-secondary">Back to Books</a>
</form>

<?php include 'footer.php'; ?>
