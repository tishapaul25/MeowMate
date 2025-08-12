<?php
session_start();

// Require admin login
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../db.php';

// Flash helpers
function flash($m){ $_SESSION['flash']=$m; }
function take_flash(){ if(!empty($_SESSION['flash'])){ $m=$_SESSION['flash']; unset($_SESSION['flash']); return $m; } return null; }

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $provider_id = (int)($_POST['provider_id'] ?? 0);

    if ($provider_id > 0) {
        if ($action === 'approve') {
            $stmt = $conn->prepare("UPDATE providers SET status='active' WHERE id=?");
            $stmt->bind_param("i", $provider_id);
            $stmt->execute();
            flash("Hostel provider application approved successfully!");
        } elseif ($action === 'reject') {
            // If you want true "rejected", change the ENUM and set status='rejected'.
            $stmt = $conn->prepare("UPDATE providers SET status='suspended' WHERE id=?");
            $stmt->bind_param("i", $provider_id);
            $stmt->execute();
            flash("Hostel provider application rejected.");
        } elseif ($action === 'suspend') {
            $stmt = $conn->prepare("UPDATE providers SET status='suspended' WHERE id=?");
            $stmt->bind_param("i", $provider_id);
            $stmt->execute();
            flash("Hostel provider account suspended.");
        }
    }
    header("Location: provider-management.php");
    exit;
}

// Filter
$filter = $_GET['filter'] ?? 'all';
$where = ($filter === 'pending') ? "WHERE status='pending'"
      : (($filter === 'active') ? "WHERE status='active'"
      : (($filter === 'suspended') ? "WHERE status='suspended'" : ''));

// Fetch providers (match your columns)
$sql = "
  SELECT
    id, user_id, name, owner_name, email, phone,
    address, city, state, zip, capacity, day_rate,
    license_no, services_json, COALESCE(rating,0) AS rating,
    status, DATE_FORMAT(created_at, '%Y-%m-%d') AS joined
  FROM providers
  $where
  ORDER BY id DESC
";
$res = $conn->query($sql);

$providers = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        // Decode JSON if present (services_json is LONGTEXT)
        $row['services'] = [];
        if (!empty($row['services_json'])) {
            $decoded = json_decode($row['services_json'], true);
            if (is_array($decoded)) $row['services'] = $decoded;
        }
        // for UI naming consistency
        $row['price_per_night'] = (float)$row['day_rate'];
        $providers[] = $row;
    }
}

// Counts for tabs
$c_all       = (int)($conn->query("SELECT COUNT(*) c FROM providers")->fetch_assoc()['c'] ?? 0);
$c_pending   = (int)($conn->query("SELECT COUNT(*) c FROM providers WHERE status='pending'")->fetch_assoc()['c'] ?? 0);
$c_active    = (int)($conn->query("SELECT COUNT(*) c FROM providers WHERE status='active'")->fetch_assoc()['c'] ?? 0);
$c_suspended = (int)($conn->query("SELECT COUNT(*) c FROM providers WHERE status='suspended'")->fetch_assoc()['c'] ?? 0);

$page_title = "Hostel Provider Management - Admin";
$success_message = take_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($page_title) ?></title>
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
    <?php if (!empty($success_message)): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <?= htmlspecialchars($success_message) ?>
      </div>
    <?php endif; ?>

    <?php if ($res === false): ?>
      <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
        Could not load providers. Ensure the <code>providers</code> table matches your schema.
      </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-medium text-gray-900">Hostel Providers</h3>
          <div class="flex space-x-2">
            <a href="?filter=all" class="px-3 py-1 text-sm rounded-md <?= $filter==='all' ? 'bg-blue-100 text-blue-800' : 'text-gray-600 hover:bg-gray-100' ?>">
              All (<?= $c_all ?>)
            </a>
            <a href="?filter=pending" class="px-3 py-1 text-sm rounded-md <?= $filter==='pending' ? 'bg-orange-100 text-orange-800' : 'text-gray-600 hover:bg-gray-100' ?>">
              Pending (<?= $c_pending ?>)
            </a>
            <a href="?filter=active" class="px-3 py-1 text-sm rounded-md <?= $filter==='active' ? 'bg-green-100 text-green-800' : 'text-gray-600 hover:bg-gray-100' ?>">
              Active (<?= $c_active ?>)
            </a>
            <a href="?filter=suspended" class="px-3 py-1 text-sm rounded-md <?= $filter==='suspended' ? 'bg-red-100 text-red-800' : 'text-gray-600 hover:bg-gray-100' ?>">
              Suspended (<?= $c_suspended ?>)
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="divide-y divide-gray-200">
        <?php if (empty($providers)): ?>
          <div class="p-6 text-sm text-gray-600">No providers found.</div>
        <?php else: ?>
          <?php foreach ($providers as $p): ?>
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
                      <h4 class="text-lg font-medium text-gray-900"><?= htmlspecialchars($p['name']) ?></h4>
                      <span class="px-2 py-1 text-xs font-medium rounded-full
                        <?= $p['status']==='active' ? 'bg-green-100 text-green-800'
                           : ($p['status']==='pending' ? 'bg-orange-100 text-orange-800'
                           : 'bg-red-100 text-red-800') ?>">
                        <?= ucfirst($p['status']) ?>
                      </span>
                    </div>
                    <p class="text-sm text-gray-600">Owner: <?= htmlspecialchars($p['owner_name']) ?></p>
                    <p class="text-sm text-gray-500"><?= htmlspecialchars($p['email']) ?> • <?= htmlspecialchars($p['phone']) ?></p>
                    <p class="text-sm text-gray-500">
                      <?= htmlspecialchars($p['address']) ?>
                      <?php
                        $line2 = array_filter([$p['city'] ?? '', $p['state'] ?? '', $p['zip'] ?? '']);
                        if (!empty($line2)) echo ' • ' . htmlspecialchars(implode(', ', $line2));
                      ?>
                    </p>
                    <div class="flex items-center space-x-4 mt-2">
                      <span class="text-sm text-gray-500">Capacity: <?= (int)$p['capacity'] ?> cats</span>
                      <span class="text-sm text-gray-500">Rate: $<?= number_format((float)$p['price_per_night'], 2) ?>/night</span>
                      <span class="text-sm text-gray-500">License: <?= htmlspecialchars($p['license_no'] ?? '') ?></span>
                    </div>

                    <?php if (!empty($p['services'])): ?>
                      <div class="flex flex-wrap gap-1 mt-2">
                        <?php foreach ($p['services'] as $svc): ?>
                          <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"><?= htmlspecialchars($svc) ?></span>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>

                    <?php if ($p['status'] === 'active'): ?>
                      <div class="flex items-center space-x-4 mt-2">
                        <div class="flex items-center">
                          <i data-lucide="star" class="w-4 h-4 text-yellow-400 mr-1"></i>
                          <span class="text-sm text-gray-600"><?= number_format((float)$p['rating'], 1) ?> rating</span>
                        </div>
                        <!-- You don't have total_bookings/earnings columns; hide or compute later -->
                        <span class="text-sm text-gray-500">Joined: <?= htmlspecialchars($p['joined']) ?></span>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="flex items-center space-x-2">
                  <?php if ($p['status'] === 'pending'): ?>
                    <form method="POST" class="inline">
                      <input type="hidden" name="provider_id" value="<?= (int)$p['id'] ?>">
                      <input type="hidden" name="action" value="approve">
                      <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Approve</button>
                    </form>
                    <form method="POST" class="inline">
                      <input type="hidden" name="provider_id" value="<?= (int)$p['id'] ?>">
                      <input type="hidden" name="action" value="reject">
                      <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Reject</button>
                    </form>
                  <?php elseif ($p['status'] === 'active'): ?>
                    <button onclick="viewProviderDetails(<?= (int)$p['id'] ?>)" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">View Details</button>
                    <form method="POST" class="inline" onsubmit="return confirm('Suspend this provider?');">
                      <input type="hidden" name="provider_id" value="<?= (int)$p['id'] ?>">
                      <input type="hidden" name="action" value="suspend">
                      <button type="submit" class="bg-orange-600 text-white px-3 py-1 rounded text-sm hover:bg-orange-700">Suspend</button>
                    </form>
                  <?php elseif ($p['status'] === 'suspended'): ?>
                    <form method="POST" class="inline">
                      <input type="hidden" name="provider_id" value="<?= (int)$p['id'] ?>">
                      <input type="hidden" name="action" value="approve">
                      <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Reactivate</button>
                    </form>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Details Modal -->
  <div id="provider-details-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 hidden">
    <div class="bg-white rounded-lg max-w-2xl w-full p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-semibold">Provider Details</h3>
        <button id="close-modal" class="text-gray-500 hover:text-gray-700">
          <i data-lucide="x" class="w-6 h-6"></i>
        </button>
      </div>
      <div id="provider-details-content"></div>
    </div>
  </div>

  <script>
    lucide.createIcons();
    const providersData = <?= json_encode($providers, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?>;

    function viewProviderDetails(id){
      const p = providersData.find(r => Number(r.id) === Number(id));
      if(!p) return;
      const addr2 = [p.city||'', p.state||'', p.zip||''].filter(Boolean).join(', ');
      const services = (Array.isArray(p.services) && p.services.length) ? p.services.join(', ') : '—';
      const html = `
        <div class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-gray-700">Business Name</label><p class="text-sm text-gray-900">${esc(p.name||'')}</p></div>
            <div><label class="block text-sm font-medium text-gray-700">Owner Name</label><p class="text-sm text-gray-900">${esc(p.owner_name||'')}</p></div>
            <div><label class="block text-sm font-medium text-gray-700">Email</label><p class="text-sm text-gray-900">${esc(p.email||'')}</p></div>
            <div><label class="block text-sm font-medium text-gray-700">Phone</label><p class="text-sm text-gray-900">${esc(p.phone||'')}</p></div>
            <div class="col-span-2"><label class="block text-sm font-medium text-gray-700">Address</label><p class="text-sm text-gray-900">${esc(p.address||'')}</p></div>
            <div><label class="block text-sm font-medium text-gray-700">City/State/Zip</label><p class="text-sm text-gray-900">${esc(addr2)}</p></div>
            <div><label class="block text-sm font-medium text-gray-700">Capacity</label><p class="text-sm text-gray-900">${Number(p.capacity||0)} cats</p></div>
            <div><label class="block text-sm font-medium text-gray-700">Rate/Night</label><p class="text-sm text-gray-900">$${Number(p.price_per_night||0).toFixed(2)}</p></div>
            <div><label class="block text-sm font-medium text-gray-700">License</label><p class="text-sm text-gray-900">${esc(p.license_no||'')}</p></div>
            <div><label class="block text-sm font-medium text-gray-700">Rating</label><p class="text-sm text-gray-900">${Number(p.rating||0).toFixed(1)} / 5.0</p></div>
            <div><label class="block text-sm font-medium text-gray-700">Joined</label><p class="text-sm text-gray-900">${esc(p.joined||'')}</p></div>
            <div class="col-span-2"><label class="block text-sm font-medium text-gray-700">Services</label><p class="text-sm text-gray-900">${esc(services)}</p></div>
          </div>
        </div>`;
      document.getElementById('provider-details-content').innerHTML = html;
      document.getElementById('provider-details-modal').classList.remove('hidden');
    }

    document.getElementById('close-modal').addEventListener('click', () => {
      document.getElementById('provider-details-modal').classList.add('hidden');
    });
    document.getElementById('provider-details-modal').addEventListener('click', function(e){
      if(e.target === this) this.classList.add('hidden');
    });

    function esc(s){ return String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c])); }
  </script>
</body>
</html>
