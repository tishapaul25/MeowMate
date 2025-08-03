<section class="w-full py-12 md:py-24 lg:py-32 xl:py-48 bg-gradient-to-r from-green-100 via-emerald-50 to-green-100">
    <div class="container px-4 md:px-6 mx-auto max-w-7xl">
        <div class="grid gap-6 lg:grid-cols-[1fr_400px] lg:gap-12 xl:grid-cols-[1fr_600px]">
            <div class="flex flex-col justify-center space-y-4">
                <div class="space-y-2">
                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-800 hover:bg-green-200">
                        🐱 Premium Cat Care
                    </div>
                    <h1 class="text-3xl font-bold tracking-tighter sm:text-5xl xl:text-6xl/none text-green-900">
                        Your Cat's Home Away From Home
                    </h1>
                    <p class="max-w-[600px] text-green-700 md:text-xl">
                        Professional cat boarding services with love, care, and attention your feline friend deserves. Safe,
                        comfortable, and fun environment for your precious cats.
                    </p>
                </div>

                <!-- Stats -->
                <div class="flex flex-wrap gap-6 py-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-900">500+</div>
                        <div class="text-sm text-green-700">Happy Cats</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-900">50+</div>
                        <div class="text-sm text-green-700">Trusted Providers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-900">24/7</div>
                        <div class="text-sm text-green-700">Care Available</div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 min-[400px]:flex-row">
                    <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium bg-green-600 text-white hover:bg-green-700 h-11 px-8 transition-colors">
                        <i data-lucide="heart" class="w-4 h-4 mr-2"></i>
                        Book Cat Stay
                    </button>
                    <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-green-600 text-green-600 hover:bg-green-50 bg-transparent h-11 px-8 transition-colors">
                        <i data-lucide="play" class="w-4 h-4 mr-2"></i>
                        Watch Video
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-center">
                <div class="relative">
                    <img
                        src="https://via.placeholder.com/400x400/16a34a/ffffff?text=Happy+Cats+Playing"
                        width="400"
                        height="400"
                        alt="Happy orange and gray cats playing together in a cozy hostel room with cat trees and toys"
                        class="mx-auto aspect-square overflow-hidden rounded-3xl object-cover shadow-2xl"
                    />
                    <div class="absolute -bottom-4 -right-4 bg-white rounded-2xl p-4 shadow-lg">
                        <div class="flex items-center space-x-2">
                            <div class="flex -space-x-1">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="text-sm font-medium text-green-800">5.0 Rating</span>
                        </div>
                    </div>

                    <!-- Floating elements -->
                    <div class="absolute -top-4 -left-4 bg-green-600 text-white rounded-full p-3 shadow-lg">
                        <i data-lucide="heart" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
