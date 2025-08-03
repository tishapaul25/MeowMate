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
    $product_id = $_POST['product_id'] ?? '';
    
    if ($action === 'approve') {
        $success_message = "Product approved successfully!";
    } elseif ($action === 'reject') {
        $success_message = "Product rejected.";
    } elseif ($action === 'suspend') {
        $success_message = "Product suspended.";
    } elseif ($action === 'add_product') {
        $success_message = "New product added successfully!";
    }
}

// Mock product data
$products = [
    [
        'id' => 1,
        'name' => 'Premium Cat Food - Salmon & Rice',
        'category' => 'Food',
        'price' => 24.99,
        'stock' => 150,
        'status' => 'active',
        'supplier' => 'PetNutrition Co.',
        'description' => 'High-quality salmon and rice formula for adult cats',
        'image' => 'https://via.placeholder.com/100x100/16a34a/ffffff?text=Cat+Food',
        'orders' => 89,
        'revenue' => 2223.11,
        'added_date' => '2024-01-15'
    ],
    [
        'id' => 2,
        'name' => 'Interactive Cat Toy - Feather Wand',
        'category' => 'Toys',
        'price' => 12.99,
        'stock' => 75,
        'status' => 'active',
        'supplier' => 'PlayTime Pets',
        'description' => 'Interactive feather wand toy to keep cats entertained',
        'image' => 'https://via.placeholder.com/100x100/22c55e/ffffff?text=Cat+Toy',
        'orders' => 156,
        'revenue' => 2026.44,
        'added_date' => '2024-01-20'
    ],
    [
        'id' => 3,
        'name' => 'Luxury Cat Bed - Memory Foam',
        'category' => 'Accessories',
        'price' => 49.99,
        'stock' => 25,
        'status' => 'active',
        'supplier' => 'ComfortPet',
        'description' => 'Orthopedic memory foam bed for senior cats',
        'image' => 'https://via.placeholder.com/100x100/4ade80/ffffff?text=Cat+Bed',
        'orders' => 34,
        'revenue' => 1699.66,
        'added_date' => '2024-02-01'
    ],
    [
        'id' => 4,
        'name' => 'Cat Grooming Kit - Professional',
        'category' => 'Grooming',
        'price' => 34.99,
        'stock' => 0,
        'status' => 'out_of_stock',
        'supplier' => 'GroomMaster',
        'description' => 'Complete grooming kit with brushes, nail clippers, and shampoo',
        'image' => 'https://via.placeholder.com/100x100/86efac/000000?text=Grooming',
        'orders' => 67,
        'revenue' => 2344.33,
        'added_date' => '2024-01-25'
    ],
    [
        'id' => 5,
        'name' => 'Organic Cat Treats - Chicken',
        'category' => 'Food',
        'price' => 8.99,
        'stock' => 200,
        'status' => 'pending',
        'supplier' => 'Natural Pet Foods',
        'description' => 'Organic chicken treats made with natural ingredients',
        'image' => 'https://via.placeholder.com/100x100/bbf7d0/000000?text=Treats',
        'orders' => 0,
        'revenue' => 0,
        'added_date' => '2024-03-15'
    ]
];

// Mock order data
$recent_orders = [
    [
        'id' => 1,
        'customer' => 'Sarah\'s Cat Haven',
        'products' => ['Premium Cat Food - Salmon & Rice', 'Interactive Cat Toy - Feather Wand'],
        'total' => 149.94,
        'status' => 'pending',
        'date' => '2024-03-15'
    ],
    [
        'id' => 2,
        'customer' => 'Happy Paws Hostel',
        'products' => ['Luxury Cat Bed - Memory Foam', 'Cat Grooming Kit - Professional'],
        'total' => 84.98,
        'status' => 'shipped',
        'date' => '2024-03-14'
    ],
    [
        'id' => 3,
        'customer' => 'Cozy Cat Lodge',
        'products' => ['Premium Cat Food - Salmon & Rice'],
        'total' => 74.97,
        'status' => 'delivered',
        'date' => '2024-03-12'
    ]
];

$filter = $_GET['filter'] ?? 'all';
$filtered_products = $products;

if ($filter === 'pending') {
    $filtered_products = array_filter($products, function($product) {
        return $product['status'] === 'pending';
    });
} elseif ($filter === 'active') {
    $filtered_products = array_filter($products, function($product) {
        return $product['status'] === 'active';
    });
} elseif ($filter === 'out_of_stock') {
    $filtered_products = array_filter($products, function($product) {
        return $product['status'] === 'out_of_stock';
    });
}

$page_title = "Product Management - Admin";
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
                        <h1 class="text-xl font-semibold text-gray-900">Product Management</h1>
                        <p class="text-sm text-gray-500">Manage products and orders</p>
                    </div>
                </div>
                
                <button onclick="showAddProductModal()" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    <i data-lucide="plus" class="w-4 h-4 inline mr-2"></i>
                    Add Product
                </button>
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
                <a href="customer-management.php" class="flex items-center px-3 py-4 text-sm font-medium hover:bg-green-700">
                    <i data-lucide="heart" class="w-4 h-4 mr-2"></i>Cat Owners
                </a>
                <a href="product-management.php" class="flex items-center px-3 py-4 text-sm font-medium bg-green-700">
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Products Section -->
            <div class="lg:col-span-2">
                <!-- Filters -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Products</h3>
                            <div class="flex space-x-2">
                                <a href="?filter=all" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'all' ? 'bg-blue-100 text-blue-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                                    All (<?php echo count($products); ?>)
                                </a>
                                <a href="?filter=pending" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'pending' ? 'bg-orange-100 text-orange-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                                    Pending (<?php echo count(array_filter($products, function($p) { return $p['status'] === 'pending'; })); ?>)
                                </a>
                                <a href="?filter=active" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'active' ? 'bg-green-100 text-green-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                                    Active (<?php echo count(array_filter($products, function($p) { return $p['status'] === 'active'; })); ?>)
                                </a>
                                <a href="?filter=out_of_stock" class="px-3 py-1 text-sm rounded-md <?php echo $filter === 'out_of_stock' ? 'bg-red-100 text-red-800' : 'text-gray-600 hover:bg-gray-100'; ?>">
                                    Out of Stock (<?php echo count(array_filter($products, function($p) { return $p['status'] === 'out_of_stock'; })); ?>)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products List -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        <?php foreach($filtered_products as $product): ?>
                            <div class="p-6">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-16 h-16 rounded-lg object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="text-lg font-medium text-gray-900"><?php echo $product['name']; ?></h4>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                <?php 
                                                echo $product['status'] === 'active' ? 'bg-green-100 text-green-800' : 
                                                    ($product['status'] === 'pending' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'); 
                                                ?>">
                                                <?php echo ucfirst(str_replace('_', ' ', $product['status'])); ?>
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600"><?php echo $product['category']; ?> • Supplier: <?php echo $product['supplier']; ?></p>
                                        <p class="text-sm text-gray-500"><?php echo $product['description']; ?></p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <span class="text-sm font-medium text-gray-900">$<?php echo $product['price']; ?></span>
                                            <span class="text-sm text-gray-500">Stock: <?php echo $product['stock']; ?></span>
                                            <span class="text-sm text-gray-500"><?php echo $product['orders']; ?> orders</span>
                                            <span class="text-sm text-gray-500">$<?php echo number_format($product['revenue'], 2); ?> revenue</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <?php if ($product['status'] === 'pending'): ?>
                                            <form method="POST" class="inline">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" class="inline">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                                    Reject
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button onclick="editProduct(<?php echo $product['id']; ?>)" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                                Edit
                                            </button>
                                            <?php if ($product['status'] === 'active'): ?>
                                                <form method="POST" class="inline">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                    <input type="hidden" name="action" value="suspend">
                                                    <button type="submit" class="bg-orange-600 text-white px-3 py-1 rounded text-sm hover:bg-orange-700">
                                                        Suspend
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Orders</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <?php foreach($recent_orders as $order): ?>
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-sm font-medium text-gray-900">Order #<?php echo $order['id']; ?></h4>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        <?php 
                                        echo $order['status'] === 'delivered' ? 'bg-green-100 text-green-800' : 
                                            ($order['status'] === 'shipped' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800'); 
                                        ?>">
                                        <?php echo ucfirst($order['status']); ?>
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600"><?php echo $order['customer']; ?></p>
                                <p class="text-sm text-gray-500 mt-1"><?php echo implode(', ', array_slice($order['products'], 0, 2)); ?><?php echo count($order['products']) > 2 ? '...' : ''; ?></p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-sm font-medium text-gray-900">$<?php echo number_format($order['total'], 2); ?></span>
                                    <span class="text-xs text-gray-500"><?php echo $order['date']; ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="px-6 py-3 bg-gray-50 text-center">
                        <button class="text-green-600 hover:text-green-800 text-sm font-medium">
                            View All Orders
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="add-product-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 hidden">
        <div class="bg-white rounded-lg max-w-2xl w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold">Add New Product</h3>
                <button id="close-add-modal" class="text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="add_product">
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                        <input type="text" name="name" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Select Category</option>
                            <option value="Food">Food</option>
                            <option value="Toys">Toys</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Grooming">Grooming</option>
                            <option value="Health">Health</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                        <input type="number" name="price" step="0.01" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Initial Stock</label>
                        <input type="number" name="stock" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                        <input type="text" name="supplier" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" onclick="closeAddProductModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    ```php file="admin/logout.php"
<?php
session_start();

// Destroy all session data
session_destroy();

// Redirect to login page
header('Location: login.php?message=logged_out');
exit;
?>
