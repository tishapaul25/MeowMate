<section class="w-full py-12 md:py-24 lg:py-32 bg-white">
    <div class="container px-4 md:px-6 mx-auto max-w-7xl">
        <div class="grid items-center gap-6 lg:grid-cols-[1fr_500px] lg:gap-12 xl:grid-cols-[1fr_550px]">
            <img
                src="https://via.placeholder.com/500x400/22c55e/ffffff?text=Cat+Owner+Goodbye"
                width="500"
                height="400"
                alt="Cat owner gently petting a tabby cat in a comfortable hostel suite with cat bed and toys visible"
                class="mx-auto aspect-video overflow-hidden rounded-xl object-cover"
            />
            <div class="flex flex-col justify-center space-y-4">
                <div class="space-y-2">
                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-800">
                        For Cat Parents
                    </div>
                    <h2 class="text-3xl font-bold tracking-tighter sm:text-5xl text-green-900">
                        Ready to Book Your Cat's Stay?
                    </h2>
                    <p class="max-w-[600px] text-green-700 md:text-xl/relaxed">
                        Give your cat the best care while you're away. Our professional cat sitters provide a safe, loving
                        environment.
                    </p>
                </div>
                <div class="w-full max-w-sm space-y-2">
                    <form class="flex gap-2" method="POST" action="process-quote.php">
                        <input
                            type="email"
                            name="email"
                            placeholder="Enter your email"
                            required
                            class="flex-1 border border-green-300 focus:border-green-500 px-3 py-2 rounded-md text-sm"
                        />
                        <button
                            type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors"
                        >
                            Get Quote
                        </button>
                    </form>
                    <p class="text-xs text-green-600">Get a personalized quote for your cat's boarding needs.</p>
                </div>
                <div class="flex flex-col gap-2 min-[400px]:flex-row">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                        Book Now
                    </button>
                    <button class="border border-green-600 text-green-600 hover:bg-green-50 bg-transparent px-6 py-2 rounded-md font-medium transition-colors">
                        View Pricing
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
