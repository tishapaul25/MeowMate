<section class="w-full py-12 md:py-24 lg:py-32 bg-white">
    <div class="container px-4 md:px-6 mx-auto max-w-7xl">
        <div class="flex flex-col items-center justify-center space-y-4 text-center">
            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-800">
                Get in Touch
            </div>
            <h2 class="text-3xl font-bold tracking-tighter sm:text-5xl text-green-900">Contact Us</h2>
            <p class="max-w-[900px] text-green-700 md:text-xl/relaxed">
                Have questions about our cat boarding services? We're here to help you and your feline friend.
            </p>
        </div>
        <div class="mx-auto grid max-w-5xl items-center gap-6 py-12 lg:grid-cols-2 lg:gap-12">
            <div class="flex flex-col justify-center space-y-6">
                <div class="flex items-center space-x-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                        <i data-lucide="phone" class="h-6 w-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-green-900">Phone</h3>
                        <p class="text-green-700">+1 (555) 123-CATS</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                        <i data-lucide="mail" class="h-6 w-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-green-900">Email</h3>
                        <p class="text-green-700">hello@purrfectstay.com</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                        <i data-lucide="map-pin" class="h-6 w-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-green-900">Address</h3>
                        <p class="text-green-700">123 Cat Street, Feline City, FC 12345</p>
                    </div>
                </div>
            </div>
            <div class="rounded-lg border bg-white shadow-sm border-green-200">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight text-green-900">Send us a message</h3>
                    <p class="text-sm text-green-700">We'll get back to you within 24 hours.</p>
                </div>
                <div class="p-6 pt-0 space-y-4">
                    <form method="POST" action="process-contact.php">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <input
                                name="first_name"
                                placeholder="First name"
                                required
                                class="border border-green-300 focus:border-green-500 px-3 py-2 rounded-md text-sm"
                            />
                            <input
                                name="last_name"
                                placeholder="Last name"
                                required
                                class="border border-green-300 focus:border-green-500 px-3 py-2 rounded-md text-sm"
                            />
                        </div>
                        <input
                            name="email"
                            placeholder="Email"
                            type="email"
                            required
                            class="w-full border border-green-300 focus:border-green-500 px-3 py-2 rounded-md text-sm mb-4"
                        />
                        <input
                            name="phone"
                            placeholder="Phone"
                            type="tel"
                            class="w-full border border-green-300 focus:border-green-500 px-3 py-2 rounded-md text-sm mb-4"
                        />
                        <textarea
                            name="message"
                            placeholder="Tell us about your cat and your needs..."
                            required
                            class="w-full min-h-[100px] px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:border-green-500 mb-4"
                        ></textarea>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
