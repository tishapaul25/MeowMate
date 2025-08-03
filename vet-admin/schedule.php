<?php
session_start();

// Check if logged in
if (!isset($_SESSION['vet_logged_in']) || !$_SESSION['vet_logged_in']) {
    header('Location: login.php');
    exit;
}

$vet_name = $_SESSION['vet_name'];

// Handle schedule updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process schedule update
    $success_message = "Schedule updated successfully!";
}

$page_title = "Schedule Management - " . $vet_name;

// Mock schedule data
$weekly_schedule = [
    'monday' => [
        ['start' => '09:00', 'end' => '12:00', 'status' => 'available'],
        ['start' => '13:00', 'end' => '17:00', 'status' => 'available'],
        ['start' => '18:00', 'end' => '20:00', 'status' => 'limited']
    ],
    'tuesday' => [
        ['start' => '09:00', 'end' => '12:00', 'status' => 'available'],
        ['start' => '13:00', 'end' => '17:00', 'status' => 'available']
    ],
    'wednesday' => [
        ['start' => '09:00', 'end' => '12:00', 'status' => 'available'],
        ['start' => '13:00', 'end' => '17:00', 'status' => 'available'],
        ['start' => '18:00', 'end' => '20:00', 'status' => 'limited']
    ],
    'thursday' => [
        ['start' => '09:00', 'end' => '12:00', 'status' => 'available'],
        ['start' => '13:00', 'end' => '17:00', 'status' => 'available']
    ],
    'friday' => [
        ['start' => '09:00', 'end' => '12:00', 'status' => 'available'],
        ['start' => '13:00', 'end' => '16:00', 'status' => 'available']
    ],
    'saturday' => [
        ['start' => '10:00', 'end' => '14:00', 'status' => 'limited']
    ],
    'sunday' => [] // Off day
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
                        <h1 class="text-xl font-semibold text-gray-900">Schedule Management</h1>
                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($vet_name); ?></p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Quick Settings -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Default Availability</label>
                            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="available">Available</option>
                                <option value="limited">Limited Availability</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Consultation Duration</label>
                            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="15">15 minutes</option>
                                <option value="20" selected>20 minutes</option>
                                <option value="30">30 minutes</option>
                                <option value="45">45 minutes</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Break Between Consultations</label>
                            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="5" selected>5 minutes</option>
                                <option value="10">10 minutes</option>
                                <option value="15">15 minutes</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500" checked>
                                <span class="ml-2 text-sm text-gray-700">Accept emergency consultations</span>
                            </label>
                        </div>
                        
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm text-gray-700">Auto-accept consultations</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Time Off Requests -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Request Time Off</h3>
                    
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                            <textarea class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" rows="3" placeholder="Optional reason for time off"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700">
                            Submit Request
                        </button>
                    </form>
                </div>
            </div>

            <!-- Weekly Schedule -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Weekly Schedule</h3>
                        <p class="text-sm text-gray-500 mt-1">Click on time slots to edit your availability</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-6">
                            <?php 
                            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                            $day_names = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            
                            foreach($days as $index => $day): 
                                $schedule = $weekly_schedule[$day] ?? [];
                            ?>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-lg font-medium text-gray-900"><?php echo $day_names[$index]; ?></h4>
                                        <button class="text-green-600 hover:text-green-800 text-sm font-medium" onclick="addTimeSlot('<?php echo $day; ?>')">
                                            <i data-lucide="plus" class="w-4 h-4 inline mr-1"></i>
                                            Add Time Slot
                                        </button>
                                    </div>
                                    
                                    <div id="<?php echo $day; ?>-slots" class="space-y-2">
                                        <?php if (empty($schedule)): ?>
                                            <p class="text-gray-500 text-sm italic">No availability set for this day</p>
                                        <?php else: ?>
                                            <?php foreach($schedule as $slot_index => $slot): ?>
                                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-md">
                                                    <input type="time" value="<?php echo $slot['start']; ?>" class="border border-gray-300 rounded px-2 py-1 text-sm">
                                                    <span class="text-gray-500">to</span>
                                                    <input type="time" value="<?php echo $slot['end']; ?>" class="border border-gray-300 rounded px-2 py-1 text-sm">
                                                    
                                                    <select class="border border-gray-300 rounded px-2 py-1 text-sm">
                                                        <option value="available" <?php echo $slot['status'] === 'available' ? 'selected' : ''; ?>>Available</option>
                                                        <option value="limited" <?php echo $slot['status'] === 'limited' ? 'selected' : ''; ?>>Limited</option>
                                                        <option value="unavailable" <?php echo $slot['status'] === 'unavailable' ? 'selected' : ''; ?>>Unavailable</option>
                                                    </select>
                                                    
                                                    <button class="text-red-600 hover:text-red-800" onclick="removeTimeSlot(this)">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="mt-8 flex justify-end space-x-4">
                            <button class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Reset to Default
                            </button>
                            <button class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Save Schedule
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        function addTimeSlot(day) {
            const container = document.getElementById(day + '-slots');
            const newSlot = document.createElement('div');
            newSlot.className = 'flex items-center space-x-3 p-3 bg-gray-50 rounded-md';
            newSlot.innerHTML = `
                <input type="time" value="09:00" class="border border-gray-300 rounded px-2 py-1 text-sm">
                <span class="text-gray-500">to</span>
                <input type="time" value="17:00" class="border border-gray-300 rounded px-2 py-1 text-sm">
                
                <select class="border border-gray-300 rounded px-2 py-1 text-sm">
                    <option value="available" selected>Available</option>
                    <option value="limited">Limited</option>
                    <option value="unavailable">Unavailable</option>
                </select>
                
                <button class="text-red-600 hover:text-red-800" onclick="removeTimeSlot(this)">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            `;
            
            // Remove "No availability" message if it exists
            const noAvailMsg = container.querySelector('p.italic');
            if (noAvailMsg) {
                noAvailMsg.remove();
            }
            
            container.appendChild(newSlot);
            lucide.createIcons();
        }
        
        function removeTimeSlot(button) {
            const slot = button.closest('.flex');
            const container = slot.parentElement;
            slot.remove();
            
            // Add "No availability" message if no slots remain
            if (container.children.length === 0) {
                const noAvailMsg = document.createElement('p');
                noAvailMsg.className = 'text-gray-500 text-sm italic';
                noAvailMsg.textContent = 'No availability set for this day';
                container.appendChild(noAvailMsg);
            }
        }
    </script>
</body>
</html>
