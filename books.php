<?php
include 'header.php';

// Handle search query
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
}

// Fetch books from database
$sql = "SELECT * FROM Books";
if ($search_query) {
    $sql .= " WHERE title LIKE '%$search_query%' OR author LIKE '%$search_query%'";
}
$result = $conn->query($sql);
?>

<h2>Books</h2>
<div class="mb-3">
  <a href="add_book.php" class="btn btn-primary">Add New Book</a>
</div>

<!-- Search form -->
<form class="mb-3" method="GET" action="books.php">
  <div class="input-group">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" class="form-control" placeholder="Search by title or author">
    <button type="submit" class="btn btn-outline-secondary">Search</button>
  </div>
</form>

<?php if ($result && $result->num_rows > 0): ?>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Author</th>
      <th>Publisher</th>
      <th>Year</th>
      <th>Total</th>
      <th>Available</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo htmlspecialchars($row['title']); ?></td>
      <td><?php echo htmlspecialchars($row['author']); ?></td>
      <td><?php echo htmlspecialchars($row['publisher']); ?></td>
      <td><?php echo $row['year']; ?></td>
      <td><?php echo $row['total_copies']; ?></td>
      <td><?php echo $row['available_copies']; ?></td>
      <td>
        <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
           onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php else: ?>
  <p>No books found.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
