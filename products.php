<?php
$page_title = "Products & Services - PurrfectStay";
$page_description = "Premium cat products and additional services to keep your feline friend happy and healthy.";
include 'includes/header.php';
?>

<div class="flex flex-col min-h-screen bg-gradient-to-br from-green-50 to-emerald-50">
    <?php include 'includes/navbar.php'; ?>
    
    <main class="flex-1">
        <?php include 'sections/product-section.php'; ?>
    </main>
    
    <?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>
