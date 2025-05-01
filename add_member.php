<?php
include 'header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    // Validate required fields
    if (empty($name)) {
        $error = "Name is required.";
    } else {
        // Insert into database, join_date defaults to current date
        $sql = "INSERT INTO Members (name, email, phone, address) VALUES ('$name', '$email', '$phone', '$address')";
        if ($conn->query($sql) === TRUE) {
            $success = "Member added successfully.";
        } else {
            $error = "Error adding member: " . $conn->error;
        }
    }
}
?>

<h2>Add New Member</h2>
<?php if ($error): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<form method="POST" action="add_member.php">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-control"></textarea>
  </div>
  <button type="submit" class="btn btn-success">Add Member</button>
  <a href="members.php" class="btn btn-secondary">Back to Members</a>
</form>

<?php include 'footer.php'; ?>
