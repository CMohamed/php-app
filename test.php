<?php
// Connect to the database
$db = mysqli_connect('localhost', 'username', 'password', '');

// Create a new record
if (isset($_POST['create'])) {
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
  mysqli_query($db, $sql);
  header('location: index.php');
}

// Read records from the database
$results = mysqli_query($db, "SELECT * FROM users");

// Update a record
if (isset($_POST['update'])) {
  $id = mysqli_real_escape_string($db, $_POST['id']);
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  mysqli_query($db, "UPDATE users SET name='$name', email='$email' WHERE id=$id");
  header('location: index.php');
}

// Delete a record
if (isset($_GET['del'])) {
  $id = mysqli_real_escape_string($db, $_GET['del']);
  mysqli_query($db, "DELETE FROM users WHERE id=$id");
  header('location: index.php');
}
?>
