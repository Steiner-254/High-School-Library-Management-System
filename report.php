<?php
include 'header.php';

// Current borrowed books (not returned)
$sql1 = "SELECT b.title, m.name AS member_name, bb.borrow_date, bb.due_date
         FROM BorrowedBooks bb
         JOIN Books b ON bb.book_id = b.id
         JOIN Members m ON bb.member_id = m.id
         WHERE bb.return_date IS NULL";
$res1 = $conn->query($sql1);

// Overdue books (due date passed and not returned)
$sql2 = "SELECT b.title, m.name AS member_name, bb.borrow_date, bb.due_date
         FROM BorrowedBooks bb
         JOIN Books b ON bb.book_id = b.id
         JOIN Members m ON bb.member_id = m.id
         WHERE bb.return_date IS NULL AND bb.due_date < CURDATE()";
$res2 = $conn->query($sql2);
?>

<h2>Reports</h2>

<h3>Currently Borrowed Books</h3>
<?php if ($res1 && $res1->num_rows > 0): ?>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>Book Title</th>
      <th>Member</th>
      <th>Borrow Date</th>
      <th>Due Date</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $res1->fetch_assoc()): ?>
    <tr>
      <td><?php echo htmlspecialchars($row['title']); ?></td>
      <td><?php echo htmlspecialchars($row['member_name']); ?></td>
      <td><?php echo $row['borrow_date']; ?></td>
      <td><?php echo $row['due_date']; ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php else: ?>
  <p>No books are currently borrowed.</p>
<?php endif; ?>

<h3>Overdue Books</h3>
<?php if ($res2 && $res2->num_rows > 0): ?>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>Book Title</th>
      <th>Member</th>
      <th>Borrow Date</th>
      <th>Due Date</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $res2->fetch_assoc()): ?>
    <tr class="table-danger">
      <td><?php echo htmlspecialchars($row['title']); ?></td>
      <td><?php echo htmlspecialchars($row['member_name']); ?></td>
      <td><?php echo $row['borrow_date']; ?></td>
      <td><?php echo $row['due_date']; ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php else: ?>
  <p>No overdue books.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
