<?php
session_start();

// Check if logged in
if (!isset($_SESSION['vet_logged_in']) || !$_SESSION['vet_logged_in']) {
    header('Location: login.php');
    exit;
}

$vet_name = $_SESSION['vet_name'];
$vet_email = $_SESSION['vet_email'];

// Handle profile updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process profile update
    $success_message = "Profile updated successfully!";
}

$page_title = "Profile Settings - " . $vet_name;

// Mock profile data
$profile_data = [
    'name' => $vet_name,
    'email' => $vet_email,
    'specialty' => 'Emergency & Critical Care',
    'experience' => '12 years',
    'phone' => '+1 (555) 123-4567',
    'license_number' => 'VET-2024-001234',
    'bio' => 'Experienced veterinarian specializing in emergency and critical care for cats. Passionate about providing compassionate care and helping pet owners during stressful situations.',
    'languages' => ['English', 'Spanish'],
    'consultation_rate' => 45
];
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
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="dashboard.php" class="text-green-600 hover:text-green-800">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Profile Settings</h1>
                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($vet_name); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Professional Information</h3>
                <p class="text-sm text-gray-500 mt-1">Update your professional details and consultation settings</p>
            </div>
            
            <form method="POST" class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input 
                            type="text" 
                            name="name"
                            value="<?php echo htmlspecialchars($profile_data['name']); ?>"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            required
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input 
                            type="email" 
                            name="email"
                            value="<?php echo htmlspecialchars($profile_data['email']); ?>"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            required
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input 
                            type="tel" 
                            name="phone"
                            value="<?php echo htmlspecialchars($profile_data['phone']); ?>"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">License Number</label>
                        <input 
                            type="text" 
                            name="license_number"
                            value="<?php echo htmlspecialchars($profile_data['license_number']); ?>"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            required
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Specialty</label>
                        <select name="specialty" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="Emergency & Critical Care" <?php echo $profile_data['specialty'] === 'Emergency & Critical Care' ? 'selected' : ''; ?>>Emergency & Critical Care</option>
                            <option value="Internal Medicine" <?php echo $profile_data['specialty'] === 'Internal Medicine' ? 'selected' : ''; ?>>Internal Medicine</option>
                            <option value="Surgery" <?php echo $profile_data['specialty'] === 'Surgery' ? 'selected' : ''; ?>>Surgery</option>
                            <option value="Dermatology" <?php echo $profile_data['specialty'] === 'Dermatology' ? 'selected' : ''; ?>>Dermatology</option>
                            <option value="Behavior" <?php echo $profile_data['specialty'] === 'Behavior' ? 'selected' : ''; ?>>Behavior</option>
                            <option value="General Practice" <?php echo $profile_data['specialty'] === 'General Practice' ? 'selected' : ''; ?>>General Practice</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Years of Experience</label>
                        <input 
                            type="text" 
                            name="experience"
                            value="<?php echo htmlspecialchars($profile_data['experience']); ?>"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                        />
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Professional Bio</label>
                    <textarea 
                        name="bio"
                        rows="4"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Tell clients about your experience and approach to veterinary care..."
                    ><?php echo htmlspecialchars($profile_data['bio']); ?></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Languages Spoken</label>
                        <div class="space-y-2">
                            <?php 
                            $available_languages = ['English', 'Spanish', 'French', 'German', 'Mandarin', 'Korean', 'Japanese'];
                            foreach($available_languages as $lang): 
                            ?>
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="languages[]" 
                                        value="<?php echo $lang; ?>"
                                        <?php echo in_array($lang, $profile_data['languages']) ? 'checked' : ''; ?>
                                        class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                                    />
                                    <span class="ml-2 text-sm text-gray-700"><?php echo $lang; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Consultation Rate (USD)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                            <input 
                                type="number" 
                                name="consultation_rate"
                                value="<?php echo $profile_data['consultation_rate']; ?>"
                                min="25"
                                max="100"
                                class="w-full border border-gray-300 rounded-md pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            />
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Recommended range: $25 - $100</p>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Change Password</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input 
                                type="password" 
                                name="current_password"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input 
                                type="password" 
                                name="new_password"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            />
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button 
                        type="button" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                    >
                        <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
