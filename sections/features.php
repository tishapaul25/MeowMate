<?php
$features = [
    [
        'icon' => 'shield',
        'title' => 'Safe & Secure',
        'description' => '24/7 monitoring, secure facilities, and trained staff ensure your cat\'s safety and well-being at all times.'
    ],
    [
        'icon' => 'heart',
        'title' => 'Loving Care',
        'description' => 'Individual attention, playtime, and cuddles from our cat-loving staff who treat your pet like family.'
    ],
    [
        'icon' => 'clock',
        'title' => 'Flexible Stays',
        'description' => 'Short-term or long-term boarding options with flexible scheduling to meet your travel needs.'
    ],
    [
        'icon' => 'award',
        'title' => 'Certified Staff',
        'description' => 'All our caregivers are professionally trained and certified in pet care and first aid.'
    ],
    [
        'icon' => 'users',
        'title' => 'Small Groups',
        'description' => 'We maintain small group sizes to ensure each cat gets personalized attention and care.'
    ],
    [
        'icon' => 'zap',
        'title' => 'Quick Booking',
        'description' => 'Easy online booking system with instant confirmation and real-time availability updates.'
    ]
];
?>

<section class="w-full py-12 md:py-24 lg:py-32 bg-white">
    <div class="container px-4 md:px-6 mx-auto max-w-7xl">
        <div class="flex flex-col items-center justify-center space-y-4 text-center">
            <div class="space-y-2">
                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-800">
                    Why Choose Us
                </div>
                <h2 class="text-3xl font-bold tracking-tighter sm:text-5xl text-green-900">
                    Premium Cat Care Services
                </h2>
                <p class="max-w-[900px] text-green-700 md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                    We provide exceptional care for your feline friends with professional staff, modern facilities, and
                    personalized attention.
                </p>
            </div>
        </div>

        <div class="mx-auto grid max-w-5xl items-center gap-6 py-12 lg:grid-cols-3 lg:gap-12">
            <?php foreach($features as $feature): ?>
                <div class="rounded-lg border bg-white text-card-foreground shadow-sm border-green-200 hover:shadow-lg transition-shadow">
                    <div class="flex flex-col space-y-1.5 p-6 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                            <i data-lucide="<?php echo $feature['icon']; ?>" class="h-6 w-6 text-green-600"></i>
                        </div>
                        <h3 class="text-2xl font-semibold leading-none tracking-tight text-green-900"><?php echo $feature['title']; ?></h3>
                    </div>
                    <div class="p-6 pt-0">
                        <p class="text-sm text-muted-foreground text-center text-green-700"><?php echo $feature['description']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
