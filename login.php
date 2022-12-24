<?php
// Start the session
session_start();

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "db-app");

// Check if the login form has been submitted
if (isset($_POST["submit"])) {
  // Get the username and password from the form
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Query the database to check if the user exists
  $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  // If the query returns a row, the login was successful
  if (mysqli_num_rows($result) == 1) {
    // Store the user's information in a session variable
    $_SESSION["logged_in"] = true;
    $_SESSION["username"] = $username;

    // Redirect to the home page
    header("Location: home.php");
  } else {
    // Set an error message
    $error = "Invalid username or password";
  }
}
?>

<?php
// If there was an error, display it
if (isset($error)) {
  echo "<p>$error</p>";
}
?>
