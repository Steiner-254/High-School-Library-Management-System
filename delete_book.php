<?php
require 'config.php';

// Get the book ID and delete
$id = intval($_GET['id']);
$conn->query("DELETE FROM Books WHERE id=$id");

// Redirect back to books page
header("Location: books.php");
exit;
?>
