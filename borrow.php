<?php
include 'header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = intval($_POST['book_id']);
    $member_id = intval($_POST['member_id']);
    $borrow_date = $conn->real_escape_string($_POST['borrow_date']);
    $due_date = $conn->real_escape_string($_POST['due_date']);

    // Check availability
    $res = $conn->query("SELECT available_copies FROM Books WHERE id=$book_id");
    if ($res->num_rows === 1) {
        $book = $res->fetch_assoc();
        if ($book['available_copies'] <= 0) {
            $error = "Selected book is not available.";
        } else {
            // Insert borrow record
            $sql = "INSERT INTO BorrowedBooks (book_id, member_id, borrow_date, due_date) VALUES ($book_id, $member_id, '$borrow_date', '$due_date')";
            if ($conn->query($sql) === TRUE) {
                // Decrement available copies
                $conn->query("UPDATE Books SET available_copies = available_copies - 1 WHERE id=$book_id");
                $success = "Book borrowed successfully.";
            } else {
                $error = "Error borrowing book: " . $conn->error;
            }
        }
    } else {
        $error = "Book not found.";
    }
}
?>

<h2>Borrow Book</h2>
<?php if ($error): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<form method="POST" action="borrow.php">
  <div class="mb-3">
    <label class="form-label">Select Book</label>
    <select name="book_id" class="form-select" required>
      <option value="">-- Choose a Book --</option>
      <?php
      // List only books that have copies available
      $res_books = $conn->query("SELECT id, title, available_copies FROM Books WHERE available_copies > 0");
      while ($b = $res_books->fetch_assoc()) {
          echo "<option value=\"" . $b['id'] . "\">" . htmlspecialchars($b['title']) . " (Available: " . $b['available_copies'] . ")</option>";
      }
      ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Select Member</label>
    <select name="member_id" class="form-select" required>
      <option value="">-- Choose a Member --</option>
      <?php
      $res_members = $conn->query("SELECT id, name FROM Members");
      while ($m = $res_members->fetch_assoc()) {
          echo "<option value=\"" . $m['id'] . "\">" . htmlspecialchars($m['name']) . "</option>";
      }
      ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Borrow Date</label>
    <input type="date" name="borrow_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Due Date</label>
    <input type="date" name="due_date" class="form-control" value="<?php echo date('Y-m-d', strtotime('+14 days')); ?>" required>
  </div>
  <button type="submit" class="btn btn-success">Borrow Book</button>
  <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</form>

<?php include 'footer.php'; ?>
