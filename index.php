<?php
$page_title = "PurrfectStay - Premium Cat Hostel Services";
$page_description = "Professional cat boarding services with love, care, and attention your feline friend deserves.";
include 'includes/header.php';
?>

<div class="flex flex-col min-h-screen bg-gradient-to-br from-green-50 to-emerald-50">
    <?php include 'includes/navbar.php'; ?>
    
    <main class="flex-1">
        <?php include 'sections/hero-section.php'; ?>
        <?php include 'sections/features.php'; ?>
        <?php include 'sections/image-gallery.php'; ?>
    </main>
    
    <?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>
