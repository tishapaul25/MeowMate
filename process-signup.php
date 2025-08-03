<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validation: Check if passwords match
    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match.'); history.back();</script>";
        exit();
    }

    // Temporary Success Response
    // Redirect to success page
header("Location: signup-success.php");
exit();

}
?>
