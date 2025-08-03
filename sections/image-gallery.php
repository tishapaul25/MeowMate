<?php
$galleryImages = [
    [
        'src' => 'https://via.placeholder.com/250x300/16a34a/ffffff?text=Cozy+Cat+Suites',
        'alt' => 'Luxurious cat suite with comfortable bedding, climbing trees, and a black cat relaxing by the window',
        'title' => 'Cozy Cat Suites'
    ],
    [
        'src' => 'https://via.placeholder.com/250x200/22c55e/ffffff?text=Cats+Napping',
        'alt' => 'Three cats of different colors peacefully napping together on soft blankets in a sunny room',
        'title' => 'Peaceful Nap Time'
    ],
    [
        'src' => 'https://via.placeholder.com/250x200/4ade80/ffffff?text=Play+Time',
        'alt' => 'Energetic kittens playing with colorful toys in a bright, spacious play area with climbing structures',
        'title' => 'Fun Play Time'
    ],
    [
        'src' => 'https://via.placeholder.com/250x300/86efac/000000?text=Meal+Time',
        'alt' => 'Multiple cats eating from individual bowls in a clean, organized feeding area with natural lighting',
        'title' => 'Meal Time Together'
    ],
    [
        'src' => 'https://via.placeholder.com/250x300/bbf7d0/000000?text=Outdoor+Garden',
        'alt' => 'Secure outdoor garden area with cats exploring cat-safe plants, climbing posts, and sunny spots',
        'title' => 'Outdoor Cat Garden'
    ],
    [
        'src' => 'https://via.placeholder.com/250x200/dcfce7/000000?text=Cuddle+Time',
        'alt' => 'Staff member gently cuddling with a content orange tabby cat in a comfortable reading nook',
        'title' => 'Cuddle Time'
    ],
    [
        'src' => 'https://via.placeholder.com/250x200/f0fdf4/000000?text=Spa+Treatment',
        'alt' => 'Relaxed long-haired cat receiving gentle spa treatment in a calm, soothing environment',
        'title' => 'Spa Treatment'
    ],
    [
        'src' => 'https://via.placeholder.com/250x300/15803d/ffffff?text=Night+Comfort',
        'alt' => 'Peaceful nighttime scene with cats sleeping comfortably in individual cozy beds with soft lighting',
        'title' => 'Night Time Comfort'
    ]
];
?>

<section class="w-full py-12 md:py-24 lg:py-32 bg-gradient-to-r from-green-50 to-emerald-100">
    <div class="container px-4 md:px-6 mx-auto max-w-7xl">
        <div class="flex flex-col items-center justify-center space-y-4 text-center">
            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-600 text-white">
                Our Facilities
            </div>
            <h2 class="text-3xl font-bold tracking-tighter sm:text-5xl text-green-900">
                See Our Happy Guests in Action
            </h2>
            <p class="max-w-[900px] text-green-700 md:text-xl/relaxed">
                Take a peek at our cozy rooms, play areas, and the adorable cats who call our hostel their temporary home.
            </p>
        </div>

        <div class="mx-auto grid max-w-6xl gap-4 py-12 lg:grid-cols-4 md:grid-cols-2 grid-cols-1">
            <?php foreach($galleryImages as $index => $image): ?>
                <div class="relative group cursor-pointer gallery-item" data-index="<?php echo $index; ?>">
                    <img
                        src="<?php echo $image['src']; ?>"
                        alt="<?php echo $image['alt']; ?>"
                        class="w-full <?php echo ($index % 2 === 0) ? 'h-72' : 'h-48'; ?> object-cover rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group-hover:scale-105"
                    />
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 rounded-lg flex items-center justify-center">
                        <div class="text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center">
                            <h3 class="font-semibold text-lg"><?php echo $image['title']; ?></h3>
                            <p class="text-sm">Click to view</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal -->
    <div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4 hidden">
        <div class="relative max-w-4xl max-h-full">
            <button id="close-modal" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <i data-lucide="x" class="w-8 h-8"></i>
            </button>

            <button id="prev-image" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 z-10">
                <i data-lucide="chevron-left" class="w-8 h-8"></i>
            </button>

            <button id="next-image" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 z-10">
                <i data-lucide="chevron-right" class="w-8 h-8"></i>
            </button>

            <img id="modal-image" src="/placeholder.svg" alt="" class="max-w-full max-h-full object-contain rounded-lg" />

            <div class="absolute bottom-4 left-4 right-4 text-white text-center">
                <h3 id="modal-title" class="font-semibold text-xl"></h3>
                <p id="modal-counter" class="text-sm opacity-75"></p>
            </div>
        </div>
    </div>
</section>

<script>
// Gallery data for JavaScript
const galleryData = <?php echo json_encode($galleryImages); ?>;
</script>
