<?php
require 'config.php';

$id = intval($_GET['id']);
$conn->query("DELETE FROM Members WHERE id=$id");

header("Location: members.php");
exit;
?>
