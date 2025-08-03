<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $vet_id = intval($_POST['vet_id'] ?? 0);
    $cardholder_name = htmlspecialchars(trim($_POST['cardholder_name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    
    // Basic validation
    $errors = [];
    
    if (empty($vet_id)) {
        $errors[] = "Veterinarian selection is required";
    }
    
    if (empty($cardholder_name)) {
        $errors[] = "Cardholder name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($errors)) {
        // Here you would typically:
        // 1. Process payment with payment gateway (Stripe, PayPal, etc.)
        // 2. Create consultation session
        // 3. Send confirmation emails
        // 4. Redirect to consultation room
        
        // For demo purposes, simulate successful payment
        session_start();
        $_SESSION['consultation_paid'] = true;
        $_SESSION['vet_id'] = $vet_id;
        $_SESSION['user_email'] = $email;
        
        // Redirect to consultation room (you would create this page)
        header('Location: consultation-room.php?vet_id=' . $vet_id . '&success=1');
        exit;
    } else {
        // Redirect back with errors
        $error_string = implode(', ', $errors);
        header('Location: urgent-vet.php?error=' . urlencode($error_string));
        exit;
    }
} else {
    // Redirect if not POST request
    header('Location: urgent-vet.php');
    exit;
}
?>
