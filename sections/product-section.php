<?php
$products = [
    [
        'image' => 'https://via.placeholder.com/300x200/16a34a/ffffff?text=Premium+Cat+Food',
        'title' => 'Premium Cat Food',
        'description' => 'High-quality, nutritious cat food and treats to keep your cat healthy and satisfied.',
        'buttonText' => 'Shop Now'
    ],
    [
        'image' => 'https://via.placeholder.com/300x200/22c55e/ffffff?text=Cat+Toys',
        'title' => 'Toys & Accessories',
        'description' => 'Fun toys, comfortable beds, and essential accessories for your cat\'s entertainment and comfort.',
        'buttonText' => 'Browse Toys'
    ],
    [
        'image' => 'https://via.placeholder.com/300x200/4ade80/ffffff?text=Cat+Grooming',
        'title' => 'Grooming Services',
        'description' => 'Professional grooming services including bathing, nail trimming, and fur care.',
        'buttonText' => 'Book Grooming'
    ]
];
?>

<section class="w-full py-12 md:py-24 lg:py-32 bg-green-50">
    <div class="container px-4 md:px-6 mx-auto max-w-7xl">
        <div class="flex flex-col items-center justify-center space-y-4 text-center">
            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-600 text-white">
                Products & Services
            </div>
            <h2 class="text-3xl font-bold tracking-tighter sm:text-5xl text-green-900">Everything Your Cat Needs</h2>
            <p class="max-w-[900px] text-green-700 md:text-xl/relaxed">
                Premium cat products and additional services to keep your feline friend happy and healthy.
            </p>
        </div>
        <div class="mx-auto grid max-w-5xl items-center gap-6 py-12 lg:grid-cols-3 lg:gap-8">
            <?php foreach($products as $product): ?>
                <div class="rounded-lg border bg-white shadow-sm border-green-200 hover:shadow-lg transition-shadow">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <img
                            src="<?php echo $product['image']; ?>"
                            width="300"
                            height="200"
                            alt="<?php echo $product['description']; ?>"
                            class="w-full h-48 object-cover rounded-lg"
                        />
                        <h3 class="text-2xl font-semibold leading-none tracking-tight text-green-900"><?php echo $product['title']; ?></h3>
                    </div>
                    <div class="p-6 pt-0">
                        <p class="text-sm text-green-700"><?php echo $product['description']; ?></p>
                        <button class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <?php echo $product['buttonText']; ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
