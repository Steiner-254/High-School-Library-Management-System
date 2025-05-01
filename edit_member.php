<?php
include 'header.php';

$error = '';
$success = '';

$id = intval($_GET['id']);

// Fetch member details
$res = $conn->query("SELECT * FROM Members WHERE id=$id");
if ($res->num_rows !== 1) {
    echo "<div class='alert alert-danger'>Member not found.</div>";
    include 'footer.php';
    exit;
}
$member = $res->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    if (empty($name)) {
        $error = "Name is required.";
    } else {
        $sql = "UPDATE Members SET name='$name', email='$email', phone='$phone', address='$address' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $success = "Member updated successfully.";
        } else {
            $error = "Error updating member: " . $conn->error;
        }
    }
}
?>

<h2>Edit Member</h2>
<?php if ($error): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<form method="POST" action="edit_member.php?id=<?php echo $id; ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($member['name']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($member['email']); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($member['phone']); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-control"><?php echo htmlspecialchars($member['address']); ?></textarea>
  </div>
  <button type="submit" class="btn btn-success">Update Member</button>
  <a href="members.php" class="btn btn-secondary">Back to Members</a>
</form>

<?php include 'footer.php'; ?>
