<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Dummy login logic
    if ($username === "admin" && $password === "admin123") {
        header("Location: signin-success.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password'); history.back();</script>";
    }
}
?>
