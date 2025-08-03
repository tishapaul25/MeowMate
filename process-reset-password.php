<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.'); history.back();</script>";
        exit();
    }

    // Simulate success (later: update in DB)
    header("Location: reset-success.php");
    exit();
}
?>
