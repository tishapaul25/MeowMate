<?php
session_start();

// Check if logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

$admin_name = $_SESSION['admin_name'];

// Mock dashboard statistics
$stats = [
    'total_vets' => 24,
    'pending_vet_applications' => 8,
    'active_providers' => 156,
    'pending_provider_applications' => 23,
    'total_customers' => 1247,
    'active_bookings' => 89,
    'total_products' => 342,
    'pending_orders' => 15,
    'monthly_revenue' => 45670,
    'consultations_today' => 67
];

$page_title = "Admin Dashboard - MeowMate";
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
                    <div class="flex items-center justify-center w-10 h-10 bg-green-600 rounded-full">
                        <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">MeowMate Admin</h1>
                        <p class="text-sm text-gray-500">Welcome back, <?php echo htmlspecialchars($admin_name); ?></p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                    </button>
                    
                    <div class="relative">
                        <button id="profile-menu" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">A</span>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </button>
                        
                        <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                            <a href="settings.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i data-lucide="settings" class="w-4 h-4 inline mr-2"></i>Settings
                            </a>
                            <hr class="my-1">
                            <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i data-lucide="log-out" class="w-4 h-4 inline mr-2"></i>Sign Out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-green-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-8">
                <a href="dashboard.php" class="flex items-center px-3 py-4 text-sm font-medium bg-green-700">
                    <i data-lucide="home" class="w-4 h-4 mr-2"></i>Dashboard
                </a>
                <a href="vet-management.php" class="flex items-center px-3 py-4 text-sm font-medium hover:bg-green-700">
                    <i data-lucide="stethoscope" class="w-4 h-4 mr-2"></i>Veterinarians
                </a>
                <a href="provider-management.php" class="flex items-center px-3 py-4 text-sm font-medium hover:bg-green-700">
                    <i data-lucide="users" class="w-4 h-4 mr-2"></i>Hostel Providers
                </a>
                <a href="customer-management.php" class="flex items-center px-3 py-4 text-sm font-medium hover:bg-green-700">
                    <i data-lucide="heart" class="w-4 h-4 mr-2"></i>Cat Owners
                </a>
                <a href="product-management.php" class="flex items-center px-3 py-4 text-sm font-medium hover:bg-green-700">
                    <i data-lucide="package" class="w-4 h-4 mr-2"></i>Products
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Veterinarians Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i data-lucide="stethoscope" class="w-4 h-4 text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Veterinarians</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo $stats['total_vets']; ?></p>
                        <p class="text-xs text-orange-600"><?php echo $stats['pending_vet_applications']; ?> pending applications</p>
                    </div>
                </div>
            </div>
            
            <!-- Providers Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i data-lucide="users" class="w-4 h-4 text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Hostel Providers</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo $stats['active_providers']; ?></p>
                        <p class="text-xs text-orange-600"><?php echo $stats['pending_provider_applications']; ?> pending applications</p>
                    </div>
                </div>
            </div>
            
            <!-- Customers Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i data-lucide="heart" class="w-4 h-4 text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Cat Owners</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo $stats['total_customers']; ?></p>
                        <p class="text-xs text-green-600"><?php echo $stats['active_bookings']; ?> active bookings</p>
                    </div>
                </div>
            </div>
            
            <!-- Revenue Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i data-lucide="dollar-sign" class="w-4 h-4 text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Monthly Revenue</p>
                        <p class="text-2xl font-semibold text-gray-900">$<?php echo number_format($stats['monthly_revenue']); ?></p>
                        <p class="text-xs text-green-600">+12% from last month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Quick Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <a href="vet-management.php?filter=pending" class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <div class="flex items-center">
                                    <i data-lucide="stethoscope" class="w-5 h-5 text-blue-600 mr-3"></i>
                                    <span class="text-sm font-medium text-blue-900">Review Vet Applications</span>
                                </div>
                                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full"><?php echo $stats['pending_vet_applications']; ?></span>
                            </a>
                            
                            <a href="provider-management.php?filter=pending" class="flex items-center justify-between p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <div class="flex items-center">
                                    <i data-lucide="users" class="w-5 h-5 text-green-600 mr-3"></i>
                                    <span class="text-sm font-medium text-green-900">Review Provider Applications</span>
                                </div>
                                <span class="bg-green-600 text-white text-xs px-2 py-1 rounded-full"><?php echo $stats['pending_provider_applications']; ?></span>
                            </a>
                            
                            <a href="product-management.php?filter=pending" class="flex items-center justify-between p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                                <div class="flex items-center">
                                    <i data-lucide="package" class="w-5 h-5 text-orange-600 mr-3"></i>
                                    <span class="text-sm font-medium text-orange-900">Manage Product Orders</span>
                                </div>
                                <span class="bg-orange-600 text-white text-xs px-2 py-1 rounded-full"><?php echo $stats['pending_orders']; ?></span>
                            </a>
                            
                            <a href="reports.php" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                <i data-lucide="bar-chart" class="w-5 h-5 text-purple-600 mr-3"></i>
                                <span class="text-sm font-medium text-purple-900">View Analytics</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="p-6">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="user-plus" class="w-4 h-4 text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">New veterinarian application from Dr. Amanda Foster</p>
                                    <p class="text-xs text-gray-500">2 minutes ago</p>
                                </div>
                                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Review</button>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="home" class="w-4 h-4 text-green-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">New hostel provider registration from Sarah's Cat Haven</p>
                                    <p class="text-xs text-gray-500">15 minutes ago</p>
                                </div>
                                <button class="text-green-600 hover:text-green-800 text-sm font-medium">Review</button>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="shopping-cart" class="w-4 h-4 text-purple-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">Large product order placed by Happy Paws Hostel</p>
                                    <p class="text-xs text-gray-500">1 hour ago</p>
                                </div>
                                <button class="text-purple-600 hover:text-purple-800 text-sm font-medium">View</button>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="alert-triangle" class="w-4 h-4 text-yellow-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">Customer complaint reported for Cozy Cat Lodge</p>
                                    <p class="text-xs text-gray-500">3 hours ago</p>
                                </div>
                                <button class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">Handle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        // Profile dropdown toggle
        document.getElementById('profile-menu').addEventListener('click', function() {
            document.getElementById('profile-dropdown').classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profile-dropdown');
            const button = document.getElementById('profile-menu');
            
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
