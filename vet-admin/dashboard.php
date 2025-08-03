<?php
session_start();

// Check if logged in
if (!isset($_SESSION['vet_logged_in']) || !$_SESSION['vet_logged_in']) {
    header('Location: login.php');
    exit;
}

$vet_id = $_SESSION['vet_id'];
$vet_name = $_SESSION['vet_name'];

// Mock data for the dashboard
$today_stats = [
    'consultations_today' => 8,
    'pending_requests' => 3,
    'earnings_today' => 320,
    'avg_rating' => 4.8
];

$recent_consultations = [
    [
        'id' => 1,
        'patient_name' => 'Whiskers',
        'owner_name' => 'John Smith',
        'time' => '2:30 PM',
        'status' => 'completed',
        'issue' => 'Skin irritation',
        'duration' => '15 min'
    ],
    [
        'id' => 2,
        'patient_name' => 'Luna',
        'owner_name' => 'Sarah Johnson',
        'time' => '1:45 PM',
        'status' => 'completed',
        'issue' => 'Digestive issues',
        'duration' => '22 min'
    ],
    [
        'id' => 3,
        'patient_name' => 'Max',
        'owner_name' => 'Mike Davis',
        'time' => '12:15 PM',
        'status' => 'completed',
        'issue' => 'Behavioral concerns',
        'duration' => '18 min'
    ]
];

$pending_requests = [
    [
        'id' => 4,
        'patient_name' => 'Bella',
        'owner_name' => 'Emma Wilson',
        'issue' => 'Emergency - Not eating',
        'requested_time' => '3:45 PM',
        'priority' => 'high'
    ],
    [
        'id' => 5,
        'patient_name' => 'Charlie',
        'owner_name' => 'David Brown',
        'issue' => 'Routine checkup questions',
        'requested_time' => '4:00 PM',
        'priority' => 'normal'
    ]
];

$page_title = "Veterinarian Dashboard - " . $vet_name;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        .status-online { @apply bg-green-100 text-green-800; }
        .status-busy { @apply bg-yellow-100 text-yellow-800; }
        .status-away { @apply bg-gray-100 text-gray-800; }
        .status-offline { @apply bg-red-100 text-red-800; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-600 rounded-full">
                        <i data-lucide="stethoscope" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Vet Admin Panel</h1>
                        <p class="text-sm text-gray-500">Welcome back, <?php echo htmlspecialchars($vet_name); ?></p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Status:</span>
                        <select id="status-selector" class="text-sm border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="online" class="text-green-600">🟢 Online</option>
                            <option value="busy" class="text-yellow-600">🟡 Busy</option>
                            <option value="away" class="text-gray-600">⚪ Away</option>
                            <option value="offline" class="text-red-600">🔴 Offline</option>
                        </select>
                    </div>
                    
                    <button class="text-gray-500 hover:text-gray-700">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                    </button>
                    
                    <div class="relative">
                        <button id="profile-menu" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium"><?php echo strtoupper(substr($vet_name, 4, 1)); ?></span>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </button>
                        
                        <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                            <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>Profile
                            </a>
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i data-lucide="calendar" class="w-4 h-4 text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Today's Consultations</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo $today_stats['consultations_today']; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i data-lucide="clock" class="w-4 h-4 text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Pending Requests</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo $today_stats['pending_requests']; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i data-lucide="dollar-sign" class="w-4 h-4 text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Today's Earnings</p>
                        <p class="text-2xl font-semibold text-gray-900">$<?php echo $today_stats['earnings_today']; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i data-lucide="star" class="w-4 h-4 text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Average Rating</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo $today_stats['avg_rating']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Availability Management -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Availability Management</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-sm text-green-600 font-medium">Online & Available</span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quick Actions</label>
                                <div class="space-y-2">
                                    <button class="w-full text-left px-3 py-2 text-sm bg-green-50 text-green-700 rounded-md hover:bg-green-100">
                                        <i data-lucide="check-circle" class="w-4 h-4 inline mr-2"></i>
                                        Set Available Now
                                    </button>
                                    <button class="w-full text-left px-3 py-2 text-sm bg-yellow-50 text-yellow-700 rounded-md hover:bg-yellow-100">
                                        <i data-lucide="pause-circle" class="w-4 h-4 inline mr-2"></i>
                                        Take 15 Min Break
                                    </button>
                                    <button class="w-full text-left px-3 py-2 text-sm bg-red-50 text-red-700 rounded-md hover:bg-red-100">
                                        <i data-lucide="x-circle" class="w-4 h-4 inline mr-2"></i>
                                        Go Offline
                                    </button>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Schedule for Today</label>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span>9:00 AM - 12:00 PM</span>
                                        <span class="text-green-600">Available</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>12:00 PM - 1:00 PM</span>
                                        <span class="text-gray-500">Lunch Break</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>1:00 PM - 5:00 PM</span>
                                        <span class="text-green-600">Available</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>5:00 PM - 8:00 PM</span>
                                        <span class="text-yellow-600">Limited</span>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                <i data-lucide="calendar" class="w-4 h-4 inline mr-2"></i>
                                Manage Schedule
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Consultations & Pending Requests -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Pending Requests -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Pending Consultation Requests</h3>
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            <?php echo count($pending_requests); ?> Pending
                        </span>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <?php foreach($pending_requests as $request): ?>
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                                    <i data-lucide="cat" class="w-5 h-5 text-orange-600"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2">
                                                    <h4 class="text-sm font-medium text-gray-900"><?php echo $request['patient_name']; ?></h4>
                                                    <?php if($request['priority'] === 'high'): ?>
                                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded">URGENT</span>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="text-sm text-gray-500">Owner: <?php echo $request['owner_name']; ?></p>
                                                <p class="text-sm text-gray-700 mt-1"><?php echo $request['issue']; ?></p>
                                                <p class="text-xs text-gray-500 mt-1">Requested: <?php echo $request['requested_time']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            Accept
                                        </button>
                                        <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-400">
                                            Decline
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Recent Consultations -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Consultations</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <?php foreach($recent_consultations as $consultation): ?>
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                <i data-lucide="cat" class="w-5 h-5 text-green-600"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900"><?php echo $consultation['patient_name']; ?></h4>
                                            <p class="text-sm text-gray-500">Owner: <?php echo $consultation['owner_name']; ?></p>
                                            <p class="text-sm text-gray-700"><?php echo $consultation['issue']; ?></p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-900"><?php echo $consultation['time']; ?></p>
                                        <p class="text-xs text-gray-500"><?php echo $consultation['duration']; ?></p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="px-6 py-3 bg-gray-50 text-center">
                        <button class="text-green-600 hover:text-green-800 text-sm font-medium">
                            View All Consultations
                        </button>
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
        
        // Status selector change
        document.getElementById('status-selector').addEventListener('change', function() {
            const status = this.value;
            // Here you would typically send an AJAX request to update the status
            console.log('Status changed to:', status);
            
            // Show notification
            showNotification('Status updated to ' + status, 'success');
        });
        
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</body>
</html>
