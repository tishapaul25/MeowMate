<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Here you would typically:
        // 1. Save email to database
        // 2. Send quote information email
        // 3. Add to mailing list
        
        header('Location: interested.php?success=1');
        exit;
    } else {
        header('Location: interested.php?error=Invalid email address');
        exit;
    }
} else {
    header('Location: interested.php');
    exit;
}
?>
