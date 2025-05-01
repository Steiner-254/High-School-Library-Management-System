<?php
include 'header.php';

// Handle return action
if (isset($_GET['return_id'])) {
    $return_id = intval($_GET['return_id']);
    // Fetch the borrowed record to get book_id
    $res = $conn->query("SELECT book_id FROM BorrowedBooks WHERE id=$return_id");
    if ($res->num_rows === 1) {
        $book = $res->fetch_assoc();
        $book_id = $book['book_id'];
        // Update return_date to today
        $conn->query("UPDATE BorrowedBooks SET return_date=CURDATE() WHERE id=$return_id");
        // Increment book's available copies
        $conn->query("UPDATE Books SET available_copies = available_copies + 1 WHERE id=$book_id");
    }
    // Redirect to avoid resubmission
    header("Location: return.php");
    exit;
}

// Fetch all borrowed books not returned
$sql = "SELECT bb.id, b.title, m.name AS member_name, bb.borrow_date, bb.due_date
        FROM BorrowedBooks bb
        JOIN Books b ON bb.book_id = b.id
        JOIN Members m ON bb.member_id = m.id
        WHERE bb.return_date IS NULL";
$result = $conn->query($sql);
?>

<h2>Borrowed Books (Return)</h2>

<?php if ($result && $result->num_rows > 0): ?>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>Book Title</th>
      <th>Member</th>
      <th>Borrow Date</th>
      <th>Due Date</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $today = date('Y-m-d');
    while ($row = $result->fetch_assoc()):
      $is_overdue = ($today > $row['due_date']);
    ?>
    <tr class="<?php echo $is_overdue ? 'table-danger' : ''; ?>">
      <td><?php echo htmlspecialchars($row['title']); ?></td>
      <td><?php echo htmlspecialchars($row['member_name']); ?></td>
      <td><?php echo $row['borrow_date']; ?></td>
      <td><?php echo $row['due_date']; ?></td>
      <td>
        <?php if ($is_overdue): ?>
          <span class="text-danger">Overdue</span>
        <?php else: ?>
          <span class="text-success">On Time</span>
        <?php endif; ?>
      </td>
      <td>
        <a href="return.php?return_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary"
           onclick="return confirm('Mark this book as returned?');">Return</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php else: ?>
  <p>No books are currently borrowed.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
