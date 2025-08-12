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

   $status = '0';
   if($role == '1'){
       $status = '1';
    }else if($role == '2'){
        $status = '1';
    }
    else if ($role == '3'){
       $status = '0';
    }//
//    $status = if($role === 1 || $role === 2) ? 1 : 0;
    // Validation: Check if passwords match
    if ($password == $confirm) {
          $result = $conn->query("SELECT * FROM users WHERE username = '$username'");
         if($result->num_rows < 1){
        $password =  password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (first_name, last_name, email, phone, address, username, password, role, status) VALUES ('$first', '$last', '$email', '$phone', '$address', '$username', '$password', '$role', '$status')";
        if (mysqli_query($conn, $sql)) {
            echo "insert successfull ";
        }
    }else{
        echo "User already exist with this number";
    }
    }

    // Temporary Success Response
    // Redirect to success page
//header("Location: signup-success.php");
//exit();

}
?>
