<?php
require "db.php";
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
    if ($password == $confirm) {
        $password =  password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (first_name, last_name, email, phone, address, username, password, role) VALUES ('$first', '$last', '$email', '$phone', '$address', '$username', '$password', '1')";
        if (mysqli_query($conn, $sql)) {
            echo "insert successfull ";
        }
    }

    // Temporary Success Response
    // Redirect to success page
//header("Location: signup-success.php");
//exit();

}
?>
