<?php
include 'header.php';

// Handle search query
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
}

// Fetch members from database
$sql = "SELECT * FROM Members";
if ($search_query) {
    $sql .= " WHERE name LIKE '%$search_query%' OR email LIKE '%$search_query%'";
}
$result = $conn->query($sql);
?>

<h2>Members</h2>
<div class="mb-3">
  <a href="add_member.php" class="btn btn-primary">Add New Member</a>
</div>

<form class="mb-3" method="GET" action="members.php">
  <div class="input-group">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" class="form-control" placeholder="Search by name or email">
    <button type="submit" class="btn btn-outline-secondary">Search</button>
  </div>
</form>

<?php if ($result && $result->num_rows > 0): ?>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Address</th>
      <th>Join Date</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo htmlspecialchars($row['name']); ?></td>
      <td><?php echo htmlspecialchars($row['email']); ?></td>
      <td><?php echo htmlspecialchars($row['phone']); ?></td>
      <td><?php echo htmlspecialchars($row['address']); ?></td>
      <td><?php echo $row['join_date']; ?></td>
      <td>
        <a href="edit_member.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="delete_member.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
           onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php else: ?>
  <p>No members found.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
