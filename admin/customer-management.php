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
    $customer_id = $_POST['customer_id'] ?? '';
    
    if ($action === 'suspend') {
        $success_message = "Customer account suspended.";
    } elseif ($action === 'activate') {
        $success_message = "Customer account activated.";
    }
}

// Mock customer data
$customers = [
    [
        'id' => 1,
        'name' => 'John Smith',
        'email' => 'john.smith@email.com',
        'phone' => '+1 (555) 123-4567',
        'address' => '123 Main Street, Springfield, IL 62701',
        'status' => 'active',
        'joined' => '2024-01-15',
        'total_bookings' => 12,
        'total_spent' => 1680,
        'cats' => [
            ['name' => 'Whiskers', 'breed' => 'Persian', 'age' => 3],
            ['name' => 'Shadow', 'breed' => 'Maine Coon', 'age' => 5]
        ],
        'last_booking' => '2024-03-10',
        'preferred_services' => ['Boarding', 'Grooming']
    ],
    [
        'id' => 2,
        'name' => 'Sarah Johnson',
        'email' => 'sarah.johnson@email.com',
        'phone' => '+1 (555) 234-5678',
        'address' => '456 Oak Avenue, Springfield, IL 62702',
        'status' => 'active',
        'joined' => '2024-02-01',
        'total_bookings' => 8,
        'total_spent' => 960,
        'cats' => [
            ['name' => 'Luna', 'breed' => 'Siamese', 'age' => 2]
        ],
        'last_booking' => '2024-03-08',
        'preferred_services' => ['Boarding', 'Day Care']
    ],
    [
        'id' => 3,
        'name' => 'Mike Davis',
        'email' => 'mike.davis@email.com',
        'phone' => '+1 (555) 345-6789',
        'address' => '789 Pine Street, Springfield, IL 62703',
        'status' => 'active',
        'joined' => '2024-01-20',
        'total_bookings' => 15,
        'total_spent' => 2250,
        'cats' => [
            ['name' => 'Max', 'breed' => 'British Shorthair', 'age' => 4],
            ['name' => 'Bella', 'breed' => 'Ragdoll', 'age' => 6],
            ['name' => 'Charlie', 'breed' => 'Scottish Fold', 'age' => 1]
        ],
        'last_booking' => '2024-03-12',
        'preferred_services' => ['Boarding', 'Grooming', 'Training']
    ],
    [
        'id' => 4,
        'name' => 'Emma Wilson',
        'email' => 'emma.wilson@email.com',
        'phone' => '+1 (555) 456-7890',
        'address' => '321 Elm Drive, Springfield, IL 62704',
        'status' => 'suspended',
        'joined' => '2024-02-10',
        'total_bookings' => 3,
        'total_spent' => 180,
        'cats' => [
            ['name' => 'Mittens', 'breed' => 'Tabby', 'age' => 7]
        ],
        'last_booking' => '2024-02-25',
        'preferred_services' => ['Boarding']
    ]
];

$filter = $_GET['filter'] ?? 'all';
$filtered_customers = $customers;

if ($filter === 'active') {
    $filtered_customers = array_filter($customers, function($customer) {
        return $customer['status'] === 'active';
    });
} elseif ($filter === 'suspended') {
    $filtered_customers = array_filter($customers, function($customer) {
        return $customer['status'] === 'suspended';
    });
}

$page_title = "Customer Management - Admin";
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
                        <h1 class="text-xl font-semibold text-gray-900">Customer Management</h1>
                        <p class="text-sm text-gray-500">Manage cat owner accounts and bookings</p>
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
                <a href="provider-management.php" class="flex items-center px-3 py-4 text-sm font-medium hover:bg-green-700">
                    <i data-lucide="users" class="w-4 h-4 mr-2"></i>Hostel Providers
                </a>
                <a href="customer-management.php" class="flex items-center px-3 py-4 text-sm font-medium bg-green-700">
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
                    <h3 class="text-lg font-medium text-gray-900">Cat Owners</h3>
                    <div class="flex space-x-2">
                        <a href="?filter=all" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'all' ? 'bg-blue-100 text-blue-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                            All (<?php echo count($customers); ?>)
                        </a>
                        <a href="?filter=active" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'active' ? 'bg-green-100 text-green-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                            Active (<?php echo count(array_filter($customers, function($c) { return $c['status'] === 'active'; })); ?>)
                        </a>
                        <a href="?filter=suspended" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'suspended' ? 'bg-red-100 text-red-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                            Suspended (<?php echo count(array_filter($customers, function($c) { return $c['status'] === 'suspended'; })); ?>)
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="divide-y divide-gray-200">
                <?php foreach($filtered_customers as $customer): ?>
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="heart" class="w-6 h-6 text-purple-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <h4 class="text-lg font-medium text-gray-900"><?php echo $customer['name']; ?></h4>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            <?php echo $customer['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                            <?php echo ucfirst($customer['status']); ?>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500"><?php echo $customer['email']; ?> • <?php echo $customer['phone']; ?></p>
                                    <p class="text-sm text-gray-500"><?php echo $customer['address']; ?></p>
                                    <div class="flex items-center space-x-4 mt-2">
                                        <span class="text-sm text-gray-500"><?php echo count($customer['cats']); ?> cat(s)</span>
                                        <span class="text-sm text-gray-500"><?php echo $customer['total_bookings']; ?> bookings</span>
                                        <span class="text-sm text-gray-500">$<?php echo number_format($customer['total_spent']); ?> spent</span>
                                        <span class="text-sm text-gray-500">Last booking: <?php echo $customer['last_booking']; ?></span>
                                    </div>
                                    <div class="flex items-center space-x-2 mt-2">
                                        <span class="text-sm text-gray-500">Cats:</span>
                                        <?php foreach($customer['cats'] as $cat): ?>
                                            <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">
                                                <?php echo $cat['name']; ?> (<?php echo $cat['breed']; ?>, <?php echo $cat['age']; ?>y)
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <button onclick="viewCustomerDetails(<?php echo $customer['id']; ?>)" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                    View Details
                                </button>
                                <?php if ($customer['status'] === 'active'): ?>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
                                        <input type="hidden" name="action" value="suspend">
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700" onclick="return confirm('Are you sure you want to suspend this customer?')">
                                            Suspend
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
                                        <input type="hidden" name="action" value="activate">
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            Activate
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

    <!-- Customer Details Modal -->
    <div id="customer-details-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 hidden">
        <div class="bg-white rounded-lg max-w-2xl w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold">Customer Details</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <div id="customer-details-content">
                <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        const customersData = <?php echo json_encode($customers); ?>;
        
        function viewCustomerDetails(customerId) {
            const customer = customersData.find(c => c.id === customerId);
            if (!customer) return;
            
            const catsHtml = customer.cats.map(cat => 
                `<div class="bg-orange-50 p-3 rounded-lg">
                    <h5 class="font-medium text-orange-900">${cat.name}</h5>
                    <p class="text-sm text-orange-700">Breed: ${cat.breed}</p>
                    <p class="text-sm text-orange-700">Age: ${cat.age} years</p>
                </div>`
            ).join('');
            
            document.getElementById('customer-details-content').innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="text-sm text-gray-900">${customer.name}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="text-sm text-gray-900">${customer.email}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <p class="text-sm text-gray-900">${customer.phone}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <p class="text-sm text-gray-900">${customer.status}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <p class="text-sm text-gray-900">${customer.address}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Bookings</label>
                            <p class="text-sm text-gray-900">${customer.total_bookings}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Spent</label>
                            <p class="text-sm text-gray-900">$${customer.total_spent.toLocaleString()}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Joined Date</label>
                            <p class="text-sm text-gray-900">${customer.joined}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Booking</label>
                            <p class="text-sm text-gray-900">${customer.last_booking}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Preferred Services</label>
                            <p class="text-sm text-gray-900">${customer.preferred_services.join(', ')}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cats (${customer.cats.length})</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            ${catsHtml}
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('customer-details-modal').classList.remove('hidden');
        }
        
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('customer-details-modal').classList.add('hidden');
        });
        
        // Close modal on background click
        document.getElementById('customer-details-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
