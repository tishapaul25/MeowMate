<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $first_name = htmlspecialchars(trim($_POST['first_name'] ?? ''));
    $last_name = htmlspecialchars(trim($_POST['last_name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    
    // Basic validation
    $errors = [];
    
    if (empty($first_name)) {
        $errors[] = "First name is required";
    }
    
    if (empty($last_name)) {
        $errors[] = "Last name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    if (empty($errors)) {
        // Here you would typically:
        // 1. Save to database
        // 2. Send email notification
        // 3. Send confirmation email to user
        
        // For now, we'll just redirect with success message
        header('Location: contact.php?success=1');
        exit;
    } else {
        // Redirect back with errors
        $error_string = implode(', ', $errors);
        header('Location: contact.php?error=' . urlencode($error_string));
        exit;
    }
} else {
    // Redirect if not POST request
    header('Location: contact.php');
    exit;
}
?>
