<?php
session_start();

// If you want admin-only access, uncomment:
// if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
//     header('Location: login.php'); exit;
// }

require_once __DIR__ . '/../db.php'; // <- your db.php is in project root

// ---- Image upload settings/helpers ----
$UPLOAD_DIR = __DIR__ . '/../uploads/products';
$UPLOAD_URL = 'uploads/products'; // relative URL saved in DB

if (!is_dir($UPLOAD_DIR)) {
    @mkdir($UPLOAD_DIR, 0775, true);
}

/**
 * Save uploaded image if present. Returns relative URL (e.g. uploads/products/abc.jpg) or null.
 */
function saveUploadedImage(string $fieldName, string $uploadDir, string $urlBase): ?string {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $tmp  = $_FILES[$fieldName]['tmp_name'];
    $name = $_FILES[$fieldName]['name'];

    // Basic validation
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $tmp);
    finfo_close($finfo);

    $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/gif'=>'gif'];
    if (!isset($allowed[$mime])) return null;

    $ext  = $allowed[$mime];
    $dest = uniqid('prod_', true) . '.' . $ext;
    $path = rtrim($uploadDir, '/\\') . DIRECTORY_SEPARATOR . $dest;

    if (!move_uploaded_file($tmp, $path)) return null;

    return rtrim($urlBase, '/').'/'.$dest; // relative URL stored in DB
}

// Flash helper
function redirect_with($params = []) {
    $qs = http_build_query($params);
    header("Location: product-management.php" . ($qs ? "?$qs" : ""));
    exit;
}

// Handle ADD / EDIT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action     = $_POST['action'] ?? '';
    $name       = trim($_POST['name'] ?? '');
    $category   = trim($_POST['category'] ?? '');
    $price      = $_POST['price'] ?? '';
    $stock      = $_POST['stock'] ?? '';
    $supplier   = trim($_POST['supplier'] ?? '');
    $description= trim($_POST['description'] ?? '');
    $image_url  = trim($_POST['image_url'] ?? '');

    // If an image file was uploaded, use it (takes priority over URL)
    $uploadedUrl = saveUploadedImage('image_file', $UPLOAD_DIR, $UPLOAD_URL);
    if ($uploadedUrl) {
        $image_url = $uploadedUrl;
    }

    if ($action === 'add_product') {
        $stmt = $conn->prepare(
            "INSERT INTO products (name, category, price, stock, supplier, description, image_url)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssdisss", $name, $category, $price, $stock, $supplier, $description, $image_url);
        if ($stmt->execute()) {
            redirect_with(['ok' => 'Product added successfully.']);
        } else {
            redirect_with(['err' => 'Add failed: ' . $conn->error]);
        }
    }

    if ($action === 'save_product') {
        $id = (int)($_POST['product_id'] ?? 0);
        if ($id <= 0) redirect_with(['err' => 'Invalid product ID.']);

        $stmt = $conn->prepare(
            "UPDATE products
               SET name=?, category=?, price=?, stock=?, supplier=?, description=?, image_url=?
             WHERE id=?"
        );
        $stmt->bind_param("ssdisssi", $name, $category, $price, $stock, $supplier, $description, $image_url, $id);
        if ($stmt->execute()) {
            redirect_with(['ok' => 'Product updated successfully.']);
        } else {
            redirect_with(['err' => 'Update failed: ' . $conn->error]);
        }
    }
}

// Filters (All / Out of Stock)
$filter = $_GET['filter'] ?? 'all';
if ($filter === 'out_of_stock') {
    $sql = "SELECT * FROM products WHERE stock <= 0 ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM products ORDER BY id DESC";
}
$res = $conn->query($sql);
$products = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];

// For the right card – demo orders (static)
$recent_orders = [
    ['id'=>1,'customer'=>"Sarah's Cat Haven",'products'=>['Premium Cat Food','Feather Wand'],'total'=>149.94,'status'=>'pending','date'=>'2024-03-15'],
    ['id'=>2,'customer'=>"Happy Paws Hostel",'products'=>['Memory Foam Bed','Grooming Kit'],'total'=>84.98,'status'=>'shipped','date'=>'2024-03-14'],
    ['id'=>3,'customer'=>"Cozy Cat Lodge",'products'=>['Luxury Cat Bed'],'total'=>74.97,'status'=>'delivered','date'=>'2024-03-12'],
];

$page_title = "Product Management - Admin";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($page_title) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="bg-gray-50">
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
        <button onclick="showAddProductModal()"
                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 flex items-center gap-2">
          <i data-lucide="plus" class="w-4 h-4"></i>
          Add Product
        </button>
      </div>
    </div>
  </header>

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
    <?php if (!empty($_GET['ok'])): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <?= htmlspecialchars($_GET['ok']) ?>
      </div>
    <?php endif; ?>
    <?php if (!empty($_GET['err'])): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <?= htmlspecialchars($_GET['err']) ?>
      </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2">
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow mb-6">
          <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-medium text-gray-900">Products</h3>
              <div class="flex space-x-2">
                <a href="?filter=all"
                   class="px-3 py-1 text-sm rounded-md <?= $filter==='all'?'bg-blue-100 text-blue-800':'text-gray-600 hover:bg-gray-100' ?>">
                  All
                </a>
                <a href="?filter=out_of_stock"
                   class="px-3 py-1 text-sm rounded-md <?= $filter==='out_of_stock'?'bg-red-100 text-red-800':'text-gray-600 hover:bg-gray-100' ?>">
                  Out of Stock
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <div class="divide-y divide-gray-200">
            <?php if (empty($products)): ?>
              <div class="p-6 text-gray-500">No products found.</div>
            <?php else: foreach ($products as $p): ?>
              <div class="p-6">
                <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                    <img src="<?= htmlspecialchars($p['image_url'] ?: 'https://via.placeholder.com/100x100/e5e7eb/111827?text=Image') ?>"
                         alt="<?= htmlspecialchars($p['name']) ?>"
                         class="w-16 h-16 rounded-lg object-cover">
                  </div>
                  <div class="flex-1">
                    <div class="flex items-center space-x-2">
                      <h4 class="text-lg font-medium text-gray-900"><?= htmlspecialchars($p['name']) ?></h4>
                      <?php if ((int)$p['stock'] <= 0): ?>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Out of Stock</span>
                      <?php endif; ?>
                    </div>
                    <p class="text-sm text-gray-600">
                      <?= htmlspecialchars($p['category']) ?> • Supplier: <?= htmlspecialchars($p['supplier']) ?>
                    </p>
                    <p class="text-sm text-gray-500"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
                    <div class="flex items-center space-x-4 mt-2">
                      <span class="text-sm font-medium text-gray-900">$<?= number_format((float)$p['price'], 2) ?></span>
                      <span class="text-sm text-gray-500">Stock: <?= (int)$p['stock'] ?></span>
                      <span class="text-sm text-gray-500"><?= isset($p['orders']) ? (int)$p['orders'] : 0 ?> orders</span>
                      <span class="text-sm text-gray-500">$<?= number_format(isset($p['revenue'])?(float)$p['revenue']:0, 2) ?> revenue</span>
                    </div>
                  </div>
                  <div>
                    <button
                      class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700"
                      onclick='openEditModal(<?= json_encode([
                        "id"=>$p["id"],
                        "name"=>$p["name"],
                        "category"=>$p["category"],
                        "price"=>$p["price"],
                        "stock"=>$p["stock"],
                        "supplier"=>$p["supplier"],
                        "description"=>$p["description"],
                        "image_url"=>$p["image_url"],
                      ], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?>)'>
                      Edit
                    </button>
                  </div>
                </div>
              </div>
            <?php endforeach; endif; ?>
          </div>
        </div>
      </div>

      <!-- Recent orders (optional) -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow">
          <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Orders</h3>
          </div>
          <div class="divide-y divide-gray-200">
            <?php foreach ($recent_orders as $o): ?>
              <?php
                $badge = $o['status']==='delivered' ? 'bg-green-100 text-green-800'
                      : ($o['status']==='shipped' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800');
              ?>
              <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                  <h4 class="text-sm font-medium text-gray-900">Order #<?= (int)$o['id'] ?></h4>
                  <span class="px-2 py-1 text-xs font-medium rounded-full <?= $badge ?>">
                    <?= htmlspecialchars(ucfirst($o['status'])) ?>
                  </span>
                </div>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($o['customer']) ?></p>
                <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars(implode(', ', $o['products'])) ?></p>
                <div class="flex items-center justify-between mt-2">
                  <span class="text-sm font-medium text-gray-900">$<?= number_format($o['total'], 2) ?></span>
                  <span class="text-xs text-gray-500"><?= htmlspecialchars($o['date']) ?></span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Modal -->
  <div id="add-product-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-semibold">Add New Product</h3>
        <button onclick="closeAddProductModal()" class="text-gray-500 hover:text-gray-700">
          <i data-lucide="x" class="w-6 h-6"></i>
        </button>
      </div>
      <!-- IMPORTANT: enctype to allow file uploads -->
      <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="action" value="add_product">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
            <input name="name" required class="w-full border rounded-md px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category" required class="w-full border rounded-md px-3 py-2">
              <option value="">-- Select Category --</option>
              <option value="Food">Food</option>
              <option value="Toys">Toys</option>
              <option value="Accessories">Accessories</option>
              <option value="Grooming">Grooming</option>
              <option value="Health">Health</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
            <input type="number" step="0.01" name="price" required class="w-full border rounded-md px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
            <input type="number" name="stock" required class="w-full border rounded-md px-3 py-2">
          </div>
          <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
            <input name="supplier" required class="w-full border rounded-md px-3 py-2">
          </div>
          <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Image Upload</label>
            <input type="file" name="image_file" accept="image/*" class="w-full border rounded-md px-3 py-2">
          </div>
          <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Image URL (optional)</label>
            <input name="image_url" class="w-full border rounded-md px-3 py-2">
          </div>
          <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3" required class="w-full border rounded-md px-3 py-2"></textarea>
          </div>
        </div>
        <div class="flex justify-end space-x-3 pt-2">
          <button type="button" onclick="closeAddProductModal()" class="px-4 py-2 border rounded-md">Cancel</button>
          <button class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Add Product</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Modal -->
  <div id="edit-product-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-semibold">Edit Product</h3>
        <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
          <i data-lucide="x" class="w-6 h-6"></i>
        </button>
      </div>
      <!-- IMPORTANT: enctype for file uploads -->
      <form method="POST" enctype="multipart/form-data" class="space-y-4" id="edit-form">
        <input type="hidden" name="action" value="save_product">
        <input type="hidden" name="product_id" id="edit-id">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
            <input name="name" id="edit-name" required class="w-full border rounded-md px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category" id="edit-category" required class="w-full border rounded-md px-3 py-2">
              <option value="">-- Select Category --</option>
              <option value="Food">Food</option>
              <option value="Toys">Toys</option>
              <option value="Accessories">Accessories</option>
              <option value="Grooming">Grooming</option>
              <option value="Health">Health</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
            <input type="number" step="0.01" name="price" id="edit-price" required class="w-full border rounded-md px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
            <input type="number" name="stock" id="edit-stock" required class="w-full border rounded-md px-3 py-2">
          </div>
          <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
            <input name="supplier" id="edit-supplier" required class="w-full border rounded-md px-3 py-2">
          </div>
          <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Image Upload</label>
            <input type="file" name="image_file" accept="image/*" class="w-full border rounded-md px-3 py-2">
          </div>
          <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Image URL (optional)</label>
            <input name="image_url" id="edit-image" class="w-full border rounded-md px-3 py-2">
          </div>
          <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" id="edit-description" rows="3" required class="w-full border rounded-md px-3 py-2"></textarea>
          </div>
        </div>
        <div class="flex justify-end space-x-3 pt-2">
          <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded-md">Cancel</button>
          <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save Changes</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    lucide.createIcons();

    function showAddProductModal(){
      const m = document.getElementById('add-product-modal');
      m.classList.remove('hidden'); m.classList.add('flex');
    }
    function closeAddProductModal(){
      const m = document.getElementById('add-product-modal');
      m.classList.add('hidden'); m.classList.remove('flex');
    }

    function openEditModal(p){
      document.getElementById('edit-id').value = p.id;
      document.getElementById('edit-name').value = p.name || '';
      document.getElementById('edit-category').value = p.category || '';
      document.getElementById('edit-price').value = p.price || 0;
      document.getElementById('edit-stock').value = p.stock || 0;
      document.getElementById('edit-supplier').value = p.supplier || '';
      document.getElementById('edit-image').value = p.image_url || '';
      document.getElementById('edit-description').value = p.description || '';
      const m = document.getElementById('edit-product-modal');
      m.classList.remove('hidden'); m.classList.add('flex');
    }
    function closeEditModal(){
      const m = document.getElementById('edit-product-modal');
      m.classList.add('hidden'); m.classList.remove('flex');
    }
  </script>
</body>
</html>
