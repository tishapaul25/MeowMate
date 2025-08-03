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
    $vet_id = $_POST['vet_id'] ?? '';
    
    if ($action === 'approve') {
        $success_message = "Veterinarian application approved successfully!";
    } elseif ($action === 'reject') {
        $success_message = "Veterinarian application rejected.";
    } elseif ($action === 'suspend') {
        $success_message = "Veterinarian account suspended.";
    }
}

// Mock veterinarian data
$vets = [
    [
        'id' => 1,
        'name' => 'Dr. Sarah Mitchell',
        'email' => 'sarah.mitchell@vetcare.com',
        'specialty' => 'Emergency & Critical Care',
        'experience' => '12 years',
        'license' => 'VET-2024-001234',
        'status' => 'active',
        'rating' => 4.9,
        'consultations' => 324,
        'earnings' => 14580,
        'joined' => '2024-01-15',
        'phone' => '+1 (555) 123-4567',
        'languages' => ['English', 'Spanish'],
        'rate' => 45
    ],
    [
        'id' => 2,
        'name' => 'Dr. Michael Chen',
        'email' => 'michael.chen@vetcare.com',
        'specialty' => 'Feline Internal Medicine',
        'experience' => '8 years',
        'license' => 'VET-2024-001235',
        'status' => 'active',
        'rating' => 4.8,
        'consultations' => 256,
        'earnings' => 10240,
        'joined' => '2024-02-01',
        'phone' => '+1 (555) 234-5678',
        'languages' => ['English', 'Mandarin'],
        'rate' => 40
    ],
    [
        'id' => 3,
        'name' => 'Dr. Amanda Foster',
        'email' => 'amanda.foster@vetcare.com',
        'specialty' => 'Surgery & Orthopedics',
        'experience' => '15 years',
        'license' => 'VET-2024-001236',
        'status' => 'pending',
        'rating' => 0,
        'consultations' => 0,
        'earnings' => 0,
        'joined' => '2024-03-15',
        'phone' => '+1 (555) 345-6789',
        'languages' => ['English', 'French'],
        'rate' => 55
    ],
    [
        'id' => 4,
        'name' => 'Dr. Robert Kim',
        'email' => 'robert.kim@vetcare.com',
        'specialty' => 'Senior Cat Care',
        'experience' => '14 years',
        'license' => 'VET-2024-001237',
        'status' => 'suspended',
        'rating' => 4.7,
        'consultations' => 189,
        'earnings' => 7938,
        'joined' => '2024-01-20',
        'phone' => '+1 (555) 456-7890',
        'languages' => ['English', 'Korean'],
        'rate' => 42
    ]
];

$filter = $_GET['filter'] ?? 'all';
$filtered_vets = $vets;

if ($filter === 'pending') {
    $filtered_vets = array_filter($vets, function($vet) {
        return $vet['status'] === 'pending';
    });
} elseif ($filter === 'active') {
    $filtered_vets = array_filter($vets, function($vet) {
        return $vet['status'] === 'active';
    });
} elseif ($filter === 'suspended') {
    $filtered_vets = array_filter($vets, function($vet) {
        return $vet['status'] === 'suspended';
    });
}

$page_title = "Veterinarian Management - Admin";
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
                        <h1 class="text-xl font-semibold text-gray-900">Veterinarian Management</h1>
                        <p class="text-sm text-gray-500">Manage veterinarian applications and accounts</p>
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
                <a href="vet-management.php" class="flex items-center px-3 py-4 text-sm font-medium bg-green-700">
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
        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Veterinarians</h3>
                    <div class="flex space-x-2">
                        <a href="?filter=all" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'all' ? 'bg-blue-100 text-blue-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                            All (<?php echo count($vets); ?>)
                        </a>
                        <a href="?filter=pending" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'pending' ? 'bg-orange-100 text-orange-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                            Pending (<?php echo count(array_filter($vets, function($v) { return $v['status'] === 'pending'; })); ?>)
                        </a>
                        <a href="?filter=active" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'active' ? 'bg-green-100 text-green-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                            Active (<?php echo count(array_filter($vets, function($v) { return $v['status'] === 'active'; })); ?>)
                        </a>
                        <a href="?filter=suspended" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'suspended' ? 'bg-red-100 text-red-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                            Suspended (<?php echo count(array_filter($vets, function($v) { return $v['status'] === 'suspended'; })); ?>)
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Veterinarians List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="divide-y divide-gray-200">
                <?php foreach($filtered_vets as $vet): ?>
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="stethoscope" class="w-6 h-6 text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <h4 class="text-lg font-medium text-gray-900"><?php echo $vet['name']; ?></h4>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            <?php 
                                            echo $vet['status'] === 'active' ? 'bg-green-100 text-green-800' : 
                                                ($vet['status'] === 'pending' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'); 
                                            ?>">
                                            <?php echo ucfirst($vet['status']); ?>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600"><?php echo $vet['specialty']; ?> • <?php echo $vet['experience']; ?> experience</p>
                                    <p class="text-sm text-gray-500"><?php echo $vet['email']; ?> • <?php echo $vet['phone']; ?></p>
                                    <div class="flex items-center space-x-4 mt-2">
                                        <span class="text-sm text-gray-500">License: <?php echo $vet['license']; ?></span>
                                        <span class="text-sm text-gray-500">Rate: $<?php echo $vet['rate']; ?>/consultation</span>
                                        <span class="text-sm text-gray-500">Languages: <?php echo implode(', ', $vet['languages']); ?></span>
                                    </div>
                                    <?php if ($vet['status'] === 'active'): ?>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <div class="flex items-center">
                                                <i data-lucide="star" class="w-4 h-4 text-yellow-400 mr-1"></i>
                                                <span class="text-sm text-gray-600"><?php echo $vet['rating']; ?> rating</span>
                                            </div>
                                            <span class="text-sm text-gray-500"><?php echo $vet['consultations']; ?> consultations</span>
                                            <span class="text-sm text-gray-500">$<?php echo number_format($vet['earnings']); ?> earned</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <?php if ($vet['status'] === 'pending'): ?>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="vet_id" value="<?php echo $vet['id']; ?>">
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="vet_id" value="<?php echo $vet['id']; ?>">
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                            Reject
                                        </button>
                                    </form>
                                <?php elseif ($vet['status'] === 'active'): ?>
                                    <button onclick="viewVetDetails(<?php echo $vet['id']; ?>)" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                        View Details
                                    </button>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="vet_id" value="<?php echo $vet['id']; ?>">
                                        <input type="hidden" name="action" value="suspend">
                                        <button type="submit" class="bg-orange-600 text-white px-3 py-1 rounded text-sm hover:bg-orange-700" onclick="return confirm('Are you sure you want to suspend this veterinarian?')">
                                            Suspend
                                        </button>
                                    </form>
                                <?php elseif ($vet['status'] === 'suspended'): ?>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="vet_id" value="<?php echo $vet['id']; ?>">
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

    <!-- Vet Details Modal -->
    <div id="vet-details-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 hidden">
        <div class="bg-white rounded-lg max-w-2xl w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold">Veterinarian Details</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <div id="vet-details-content">
                <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        const vetsData = <?php echo json_encode($vets); ?>;
        
        function viewVetDetails(vetId) {
            const vet = vetsData.find(v => v.id === vetId);
            if (!vet) return;
            
            document.getElementById('vet-details-content').innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="text-sm text-gray-900">${vet.name}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="text-sm text-gray-900">${vet.email}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <p class="text-sm text-gray-900">${vet.phone}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">License</label>
                            <p class="text-sm text-gray-900">${vet.license}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Specialty</label>
                            <p class="text-sm text-gray-900">${vet.specialty}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Experience</label>
                            <p class="text-sm text-gray-900">${vet.experience}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Consultation Rate</label>
                            <p class="text-sm text-gray-900">$${vet.rate}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Languages</label>
                            <p class="text-sm text-gray-900">${vet.languages.join(', ')}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rating</label>
                            <p class="text-sm text-gray-900">${vet.rating}/5.0</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Consultations</label>
                            <p class="text-sm text-gray-900">${vet.consultations}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Earnings</label>
                            <p class="text-sm text-gray-900">$${vet.earnings.toLocaleString()}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Joined Date</label>
                            <p class="text-sm text-gray-900">${vet.joined}</p>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('vet-details-modal').classList.remove('hidden');
        }
        
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('vet-details-modal').classList.add('hidden');
        });
        
        // Close modal on background click
        document.getElementById('vet-details-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
