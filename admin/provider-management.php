<?php
session_start();

// Check if logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $provider_id = $_POST['provider_id'] ?? '';
    
    if ($action === 'approve') {
        $success_message = "Hostel provider application approved successfully!";
    } elseif ($action === 'reject') {
        $success_message = "Hostel provider application rejected.";
    } elseif ($action === 'suspend') {
        $success_message = "Hostel provider account suspended.";
    }
}

// Mock provider data
$providers = [
    [
        'id' => 1,
        'name' => 'Sarah\'s Cat Haven',
        'owner_name' => 'Sarah Johnson',
        'email' => 'sarah@catshaven.com',
        'phone' => '+1 (555) 123-4567',
        'address' => '123 Oak Street, Springfield, IL 62701',
        'capacity' => 15,
        'status' => 'active',
        'rating' => 4.8,
        'total_bookings' => 234,
        'earnings' => 18750,
        'joined' => '2024-01-10',
        'services' => ['Boarding', 'Day Care', 'Grooming'],
        'price_per_night' => 35,
        'license' => 'PET-2024-001'
    ],
    [
        'id' => 2,
        'name' => 'Cozy Cat Lodge',
        'owner_name' => 'Michael Brown',
        'email' => 'mike@cozycatlodge.com',
        'phone' => '+1 (555) 234-5678',
        'address' => '456 Pine Avenue, Springfield, IL 62702',
        'capacity' => 20,
        'status' => 'active',
        'rating' => 4.6,
        'total_bookings' => 189,
        'earnings' => 15120,
        'joined' => '2024-01-25',
        'services' => ['Boarding', 'Day Care'],
        'price_per_night' => 40,
        'license' => 'PET-2024-002'
    ],
    [
        'id' => 3,
        'name' => 'Happy Paws Hostel',
        'owner_name' => 'Emily Davis',
        'email' => 'emily@happypaws.com',
        'phone' => '+1 (555) 345-6789',
        'address' => '789 Maple Drive, Springfield, IL 62703',
        'capacity' => 12,
        'status' => 'pending',
        'rating' => 0,
        'total_bookings' => 0,
        'earnings' => 0,
        'joined' => '2024-03-10',
        'services' => ['Boarding', 'Day Care', 'Grooming', 'Training'],
        'price_per_night' => 45,
        'license' => 'PET-2024-003'
    ],
    [
        'id' => 4,
        'name' => 'Feline Paradise',
        'owner_name' => 'David Wilson',
        'email' => 'david@felineparadise.com',
        'phone' => '+1 (555) 456-7890',
        'address' => '321 Cedar Lane, Springfield, IL 62704',
        'capacity' => 8,
        'status' => 'suspended',
        'rating' => 3.2,
        'total_bookings' => 67,
        'earnings' => 2680,
        'joined' => '2024-02-15',
        'services' => ['Boarding'],
        'price_per_night' => 30,
        'license' => 'PET-2024-004'
    ]
];

$filter = $_GET['filter'] ?? 'all';
$filtered_providers = $providers;

if ($filter === 'pending') {
    $filtered_providers = array_filter($providers, function($provider) {
        return $provider['status'] === 'pending';
    });
} elseif ($filter === 'active') {
    $filtered_providers = array_filter($providers, function($provider) {
        return $provider['status'] === 'active';
    });
} elseif ($filter === 'suspended') {
    $filtered_providers = array_filter($providers, function($provider) {
        return $provider['status'] === 'suspended';
    });
}

$page_title = "Hostel Provider Management - Admin";
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
                        <h1 class="text-xl font-semibold text-gray-900">Hostel Provider Management</h1>
                        <p class="text-sm text-gray-500">Manage hostel provider applications and accounts</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-green-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-8">
                <a href="dashboard.php" class="flex items-center px-3 py-4 text-sm font-medium hover:bg-green-700">
                    <i data-lucide="home" class="w-4 h-4 mr-2"></i>Dashboard
                </a>
                <a href="vet-management.php" class="flex items-center px-3 py-4 text-sm font-medium hover:bg-green-700">
                    <i data-lucide="stethoscope" class="w-4 h-4 mr-2"></i>Veterinarians
                </a>
                <a href="provider-management.php" class="flex items-center px-3 py-4 text-sm font-medium bg-green-700">
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
        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Hostel Providers</h3>
                    <div class="flex space-x-2">
                        <a href="?filter=all" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'all' ? 'bg-blue-100 text-blue-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                            All (<?php echo count($providers); ?>)
                        </a>
                        <a href="?filter=pending" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'pending' ? 'bg-orange-100 text-orange-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                            Pending (<?php echo count(array_filter($providers, function($p) { return $p['status'] === 'pending'; })); ?>)
                        </a>
                        <a href="?filter=active" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'active' ? 'bg-green-100 text-green-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                            Active (<?php echo count(array_filter($providers, function($p) { return $p['status'] === 'active'; })); ?>)
                        </a>
                        <a href="?filter=suspended" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'suspended' ? 'bg-red-100 text-red-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                            Suspended (<?php echo count(array_filter($providers, function($p) { return $p['status'] === 'suspended'; })); ?>)
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Providers List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="divide-y divide-gray-200">
                <?php foreach($filtered_providers as $provider): ?>
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="home" class="w-6 h-6 text-green-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <h4 class="text-lg font-medium text-gray-900"><?php echo $provider['name']; ?></h4>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            <?php 
                                            echo $provider['status'] === 'active' ? 'bg-green-100 text-green-800' : 
                                                ($provider['status'] === 'pending' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'); 
                                            ?>">
                                            <?php echo ucfirst($provider['status']); ?>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">Owner: <?php echo $provider['owner_name']; ?></p>
                                    <p class="text-sm text-gray-500"><?php echo $provider['email']; ?> • <?php echo $provider['phone']; ?></p>
                                    <p class="text-sm text-gray-500"><?php echo $provider['address']; ?></p>
                                    <div class="flex items-center space-x-4 mt-2">
                                        <span class="text-sm text-gray-500">Capacity: <?php echo $provider['capacity']; ?> cats</span>
                                        <span class="text-sm text-gray-500">Rate: $<?php echo $provider['price_per_night']; ?>/night</span>
                                        <span class="text-sm text-gray-500">License: <?php echo $provider['license']; ?></span>
                                    </div>
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        <?php foreach($provider['services'] as $service): ?>
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"><?php echo $service; ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if ($provider['status'] === 'active'): ?>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <div class="flex items-center">
                                                <i data-lucide="star" class="w-4 h-4 text-yellow-400 mr-1"></i>
                                                <span class="text-sm text-gray-600"><?php echo $provider['rating']; ?> rating</span>
                                            </div>
                                            <span class="text-sm text-gray-500"><?php echo $provider['total_bookings']; ?> bookings</span>
                                            <span class="text-sm text-gray-500">$<?php echo number_format($provider['earnings']); ?> earned</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <?php if ($provider['status'] === 'pending'): ?>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="provider_id" value="<?php echo $provider['id']; ?>">
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="provider_id" value="<?php echo $provider['id']; ?>">
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                            Reject
                                        </button>
                                    </form>
                                <?php elseif ($provider['status'] === 'active'): ?>
                                    <button onclick="viewProviderDetails(<?php echo $provider['id']; ?>)" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                        View Details
                                    </button>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="provider_id" value="<?php echo $provider['id']; ?>">
                                        <input type="hidden" name="action" value="suspend">
                                        <button type="submit" class="bg-orange-600 text-white px-3 py-1 rounded text-sm hover:bg-orange-700" onclick="return confirm('Are you sure you want to suspend this provider?')">
                                            Suspend
                                        </button>
                                    </form>
                                <?php elseif ($provider['status'] === 'suspended'): ?>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="provider_id" value="<?php echo $provider['id']; ?>">
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            Reactivate
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Provider Details Modal -->
    <div id="provider-details-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 hidden">
        <div class="bg-white rounded-lg max-w-2xl w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold">Provider Details</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <div id="provider-details-content">
                <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        const providersData = <?php echo json_encode($providers); ?>;
        
        function viewProviderDetails(providerId) {
            const provider = providersData.find(p => p.id === providerId);
            if (!provider) return;
            
            document.getElementById('provider-details-content').innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Business Name</label>
                            <p class="text-sm text-gray-900">${provider.name}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Owner Name</label>
                            <p class="text-sm text-gray-900">${provider.owner_name}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="text-sm text-gray-900">${provider.email}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <p class="text-sm text-gray-900">${provider.phone}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <p class="text-sm text-gray-900">${provider.address}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Capacity</label>
                            <p class="text-sm text-gray-900">${provider.capacity} cats</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Price per Night</label>
                            <p class="text-sm text-gray-900">$${provider.price_per_night}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">License</label>
                            <p class="text-sm text-gray-900">${provider.license}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rating</label>
                            <p class="text-sm text-gray-900">${provider.rating}/5.0</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Bookings</label>
                            <p class="text-sm text-gray-900">${provider.total_bookings}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Earnings</label>
                            <p class="text-sm text-gray-900">$${provider.earnings.toLocaleString()}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Joined Date</label>
                            <p class="text-sm text-gray-900">${provider.joined}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Services</label>
                            <p class="text-sm text-gray-900">${provider.services.join(', ')}</p>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('provider-details-modal').classList.remove('hidden');
        }
        
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('provider-details-modal').classList.add('hidden');
        });
        
        // Close modal on background click
        document.getElementById('provider-details-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
