<?php
session_start();

// Check if user has paid for consultation
if (!isset($_SESSION['consultation_paid']) || !$_SESSION['consultation_paid']) {
    header('Location: urgent-vet.php?error=Payment required');
    exit;
}

$vet_id = intval($_GET['vet_id'] ?? 0);
$success = isset($_GET['success']);

$page_title = "Consultation Room - PurrfectStay";
$page_description = "Your veterinary consultation session";
include 'includes/header.php';
?>

<div class="flex flex-col min-h-screen bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    
    <main class="flex-1 py-8">
        <div class="container mx-auto max-w-4xl px-4">
            <?php if($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                        <span>Payment successful! Your consultation session is starting...</span>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Consultation Room</h1>
                    <p class="text-gray-600">Connecting you with your veterinarian...</p>
                </div>
                
                <!-- Video Call Placeholder -->
                <div class="bg-gray-900 rounded-lg aspect-video flex items-center justify-center mb-6">
                    <div class="text-center text-white">
                        <i data-lucide="video" class="w-16 h-16 mx-auto mb-4 opacity-50"></i>
                        <p class="text-xl mb-2">Video Call Starting...</p>
                        <p class="text-gray-300">Please wait while we connect you with your veterinarian</p>
                        <div class="mt-4">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white mx-auto"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Controls -->
                <div class="flex justify-center space-x-4 mb-6">
                    <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                        <i data-lucide="mic-off" class="w-4 h-4"></i>
                        <span>Mute</span>
                    </button>
                    <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                        <i data-lucide="video-off" class="w-4 h-4"></i>
                        <span>Camera</span>
                    </button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Chat</span>
                    </button>
                    <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                        <i data-lucide="phone-off" class="w-4 h-4"></i>
                        <span>End Call</span>
                    </button>
                </div>
                
                <!-- Session Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-900 mb-2">Session Information</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Session Duration: Up to 30 minutes</li>
                        <li>• You can share photos/videos of your cat during the call</li>
                        <li>• The veterinarian may provide written recommendations after the session</li>
                        <li>• If needed, you'll receive referrals to local emergency clinics</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
</div>

<script>
// Simulate connection after 3 seconds
setTimeout(function() {
    document.querySelector('.bg-gray-900 .text-center').innerHTML = `
        <i data-lucide="video" class="w-16 h-16 mx-auto mb-4 text-green-400"></i>
        <p class="text-xl mb-2 text-green-400">Connected!</p>
        <p class="text-gray-300">Your veterinarian will join shortly</p>
    `;
    lucide.createIcons();
}, 3000);
</script>

<?php include 'includes/scripts.php'; ?>
</body>
</html>
