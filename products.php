<?php
// products.php (public catalog)
$page_title = "Products – MeowMate";

require_once __DIR__ . '/db.php';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';

// ---------- helpers ----------
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
function asset_url(?string $path): string {
  if (!$path) return 'https://via.placeholder.com/640x400/e5e7eb/111827?text=No+Image';
  if (preg_match('~^https?://~i', $path)) return $path; // already absolute
  return $path; // relative web path like "uploads/products/xxx.jpg"
}

// ---------- filters ----------
$category = trim($_GET['category'] ?? '');
$q        = trim($_GET['q'] ?? '');
$instock  = isset($_GET['instock']) ? 1 : 0;

$where  = [];
$params = [];
$types  = '';

if ($category !== '') {
  $where[] = 'category = ?';
  $params[] = $category;
  $types   .= 's';
}
if ($q !== '') {
  $where[] = '(name LIKE CONCAT("%", ?, "%") OR description LIKE CONCAT("%", ?, "%"))';
  $params[] = $q;
  $params[] = $q;
  $types   .= 'ss';
}
if ($instock) {
  $where[] = 'stock > 0';
}

$sql = "SELECT id, name, category, price, stock, supplier, description, image_url
        FROM products";
if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
$sql .= " ORDER BY created_at DESC";

// Fetch products
$stmt = $conn->prepare($sql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch distinct categories for the filter dropdown
$cats = [];
$res  = $conn->query("SELECT DISTINCT category FROM products ORDER BY category");
if ($res) $cats = $res->fetch_all(MYSQLI_ASSOC);
?>

<!-- Page header / hero (CENTERED) -->
<div class="max-w-7xl mx-auto px-4 md:px-6 py-10 text-center">
  <h1 class="text-3xl md:text-4xl font-extrabold text-green-800 mb-2">
    Everything Your Cat Needs
  </h1>
  <p class="text-green-700 text-lg">Browse the latest products</p>
</div>

<!-- Filter bar (unchanged) -->
<div class="max-w-7xl mx-auto px-4 md:px-6">
  <form class="bg-white rounded-xl shadow p-4 md:p-6 mb-8 flex flex-col md:flex-row gap-4 md:items-end" method="get">
    <div class="flex-1">
      <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
      <input type="text" name="q" value="<?= e($q) ?>" class="w-full border rounded-md px-3 py-2" placeholder="Search by name or description...">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
      <select name="category" class="border rounded-md px-3 py-2 w-48">
        <option value="">All categories</option>
        <?php foreach ($cats as $c): ?>
          <option value="<?= e($c['category']) ?>" <?= $category===$c['category']?'selected':'' ?>>
            <?= e($c['category']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="flex items-center gap-2">
      <input type="checkbox" id="instock" name="instock" value="1" <?= $instock?'checked':'' ?> />
      <label for="instock" class="text-sm text-gray-700">Only show in stock</label>
    </div>
    <div>
      <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Filter</button>
    </div>
  </form>
</div>

<!-- Products grid -->
<div class="max-w-7xl mx-auto px-4 md:px-6 pb-16">
  <?php if (empty($products)): ?>
    <div class="bg-white rounded-xl shadow p-10 text-center text-gray-500">
      No products found
    </div>
  <?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($products as $p): 
        // Prepare a clean payload for the modal (include resolved image URL)
        $payload = [
          'id'          => (int)$p['id'],
          'name'        => (string)$p['name'],
          'category'    => (string)$p['category'],
          'price'       => (float)$p['price'],
          'stock'       => (int)$p['stock'],
          'supplier'    => (string)$p['supplier'],
          'description' => (string)$p['description'],
          'image_full'  => asset_url($p['image_url']),
        ];
        $dataAttr = e(json_encode($payload, JSON_UNESCAPED_SLASHES));
      ?>
       <!-- HOVER HIGHLIGHT: smooth scale + subtle glow -->
<article
  class="bg-white rounded-xl border border-gray-100 shadow-sm transition-transform duration-300 ease-out
         hover:scale-[1.02] hover:shadow-xl hover:border-green-300 cursor-pointer group"
  data-product='<?= $dataAttr ?>'
>
  <img
    src="<?= e(asset_url($p['image_url'])) ?>"
    alt="<?= e($p['name']) ?>"
    class="w-full h-48 object-cover rounded-t-xl transition-opacity duration-300 group-hover:opacity-95"
  >
  <div class="p-4">
    <div class="flex items-center justify-between">
      <h3 class="text-lg font-semibold text-gray-900"><?= e($p['name']) ?></h3>
      <?php if ((int)$p['stock'] <= 0): ?>
        <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Out of Stock</span>
      <?php endif; ?>
    </div>
    <p class="text-sm text-gray-500 mb-1"><?= e($p['category']) ?> • Supplier: <?= e($p['supplier']) ?></p>
    <p class="text-sm text-gray-600 line-clamp-3"><?= e($p['description']) ?></p>
    <div class="flex items-center justify-between mt-3">
      <span class="font-semibold text-gray-900">$<?= number_format((float)$p['price'], 2) ?></span>
      <span class="text-sm text-gray-500">Stock: <?= (int)$p['stock'] ?></span>
    </div>
  </div>
</article>
    <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<!-- PRODUCT MODAL (Quick View) -->
<div id="product-modal" class="fixed inset-0 z-50 hidden">
  <!-- backdrop -->
  <div id="modal-backdrop" class="absolute inset-0 bg-black bg-opacity-50"></div>

  <!-- dialog -->
  <div class="absolute inset-0 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b">
        <h3 id="pm-title" class="text-xl font-semibold text-gray-900">Product</h3>
        <button id="pm-close" class="text-gray-500 hover:text-gray-700" aria-label="Close">
          <!-- simple X -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
        <div class="p-5">
          <img id="pm-image" src="" alt="" class="w-full h-72 object-cover rounded-xl">
        </div>
        <div class="p-5 space-y-3">
          <div class="text-2xl font-semibold text-gray-900">
            $<span id="pm-price">0.00</span>
          </div>
          <div class="text-sm text-gray-600">
            <span class="font-medium">Category:</span> <span id="pm-category"></span>
          </div>
          <div class="text-sm text-gray-600">
            <span class="font-medium">Supplier:</span> <span id="pm-supplier"></span>
          </div>
          <div class="text-sm text-gray-600">
            <span class="font-medium">Stock:</span> <span id="pm-stock"></span>
          </div>
          <div class="pt-2">
            <h4 class="text-sm font-medium text-gray-900 mb-1">Description</h4>
            <p id="pm-description" class="text-gray-700 leading-relaxed"></p>
          </div>
        </div>
      </div>

      <div class="px-5 py-4 border-t flex justify-end">
        <button id="pm-close-2" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
<?php include __DIR__ . '/includes/scripts.php'; ?>

<script>
// Modal helpers
const modal      = document.getElementById('product-modal');
const backdrop   = document.getElementById('modal-backdrop');
const closeBtns  = [document.getElementById('pm-close'), document.getElementById('pm-close-2')];

// Modal fields
const pmTitle   = document.getElementById('pm-title');
const pmImg     = document.getElementById('pm-image');
const pmPrice   = document.getElementById('pm-price');
const pmCat     = document.getElementById('pm-category');
const pmSupp    = document.getElementById('pm-supplier');
const pmStock   = document.getElementById('pm-stock');
const pmDesc    = document.getElementById('pm-description');

function openProductModal(data) {
  pmTitle.textContent = data.name || 'Product';
  pmImg.src           = data.image_full || '';
  pmImg.alt           = data.name || '';
  pmPrice.textContent = (Number(data.price) || 0).toFixed(2);
  pmCat.textContent   = data.category || '—';
  pmSupp.textContent  = data.supplier || '—';
  pmStock.textContent = (data.stock !== undefined) ? data.stock : '—';
  pmDesc.textContent  = data.description || '';

  modal.classList.remove('hidden');
}

function closeProductModal() {
  modal.classList.add('hidden');
}

// Open from any product card
document.querySelectorAll('[data-product]').forEach(card => {
  card.addEventListener('click', () => {
    const json = card.getAttribute('data-product');
    try {
      const data = JSON.parse(json);
      openProductModal(data);
    } catch (e) {
      console.error('Invalid product payload', e);
    }
  });
});

// Close handlers
backdrop.addEventListener('click', closeProductModal);
closeBtns.forEach(btn => btn.addEventListener('click', closeProductModal));
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeProductModal();
});
</script>

</body>
</html>
