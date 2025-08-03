<?php
session_start();

// Check if already logged in
if (isset($_SESSION['vet_logged_in']) && $_SESSION['vet_logged_in']) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Demo credentials (in real app, check against database)
    $demo_vets = [
        'sarah.mitchell@vetcare.com' => ['password' => 'vet123', 'id' => 1, 'name' => 'Dr. Sarah Mitchell'],
        'michael.chen@vetcare.com' => ['password' => 'vet123', 'id' => 2, 'name' => 'Dr. Michael Chen'],
        'emily.rodriguez@vetcare.com' => ['password' => 'vet123', 'id' => 3, 'name' => 'Dr. Emily Rodriguez'],
        'james.wilson@vetcare.com' => ['password' => 'vet123', 'id' => 4, 'name' => 'Dr. James Wilson'],
        'lisa.thompson@vetcare.com' => ['password' => 'vet123', 'id' => 5, 'name' => 'Dr. Lisa Thompson'],
        'robert.kim@vetcare.com' => ['password' => 'vet123', 'id' => 6, 'name' => 'Dr. Robert Kim']
    ];
    
    if (isset($demo_vets[$email]) && $demo_vets[$email]['password'] === $password) {
        $_SESSION['vet_logged_in'] = true;
        $_SESSION['vet_id'] = $demo_vets[$email]['id'];
        $_SESSION['vet_name'] = $demo_vets[$email]['name'];
        $_SESSION['vet_email'] = $email;
        
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid email or password';
    }
}

$page_title = "Veterinarian Login - PurrfectStay Admin";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="flex items-center justify-center w-20 h-20 bg-green-600 rounded-full mx-auto mb-4">
                    <i data-lucide="stethoscope" class="w-10 h-10 text-white"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Veterinarian Portal</h2>
                <p class="mt-2 text-gray-600">Sign in to manage your availability and consultations</p>
            </div>
            
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form class="mt-8 space-y-6" method="POST">
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                            placeholder="your.email@vetcare.com"
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        />
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                            placeholder="Enter your password"
                        />
                    </div>
                </div>
                
                <div>
                    <button 
                        type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    >
                        <i data-lucide="log-in" class="w-4 h-4 mr-2"></i>
                        Sign In
                    </button>
                </div>
                
                <div class="text-center">
                    <p class="text-sm text-gray-600">Demo Credentials:</p>
                    <p class="text-xs text-gray-500 mt-1">
                        Email: sarah.mitchell@vetcare.com<br>
                        Password: vet123
                    </p>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
