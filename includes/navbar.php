<header class="sticky top-0 z-50 w-full border-b bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/60">
    <div class="container flex h-16 items-center justify-between px-4 md:px-6 mx-auto max-w-7xl">
        <a href="index.php" class="flex items-center space-x-2">
            <div class="flex items-center justify-center w-10 h-10 bg-green-600 rounded-full">
                <i data-lucide="cat" class="w-6 h-6 text-white"></i>
            </div>
            <span class="text-xl font-bold text-green-800">MeowMate</span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-6 text-sm font-medium">
            <a href="index.php" class="flex items-center space-x-1 text-green-700 hover:text-green-600 transition-colors">
                <i data-lucide="home" class="w-4 h-4"></i><span>Home</span>
            </a>
            <a href="providers.php" class="flex items-center space-x-1 text-green-700 hover:text-green-600 transition-colors">
                <i data-lucide="users" class="w-4 h-4"></i><span>Cat Hostel Providers</span>
            </a>
            <a href="interested.php" class="text-green-700 hover:text-green-600 transition-colors">
                Give Your Cat to Hostel
            </a>
            <a href="products.php" class="flex items-center space-x-1 text-green-700 hover:text-green-600 transition-colors">
                <i data-lucide="package" class="w-4 h-4"></i><span>Products</span>
            </a>
            <a href="contact.php" class="flex items-center space-x-1 text-green-700 hover:text-green-600 transition-colors">
                <i data-lucide="message-circle" class="w-4 h-4"></i><span>Contact Us</span>
            </a>
            <a href="urgent-vet.php" class="flex items-center space-x-1 text-red-600 hover:text-red-700 transition-colors font-medium">
                <i data-lucide="stethoscope" class="w-4 h-4"></i><span>🚨 Urgent Vet</span>
            </a>
        </nav>

        <div class="flex items-center space-x-4">
            <div class="hidden md:flex items-center space-x-2">
                <button onclick="openSignInModal()" class="border border-green-600 text-green-600 hover:bg-green-50 bg-transparent px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Sign In
                </button>
                <button onclick="openModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Sign Up
                </button>
            </div>

            <!-- Mobile menu button -->
            <button id="mobile-menu-btn" class="md:hidden p-2 text-green-700 hover:text-green-600">
                <i data-lucide="menu" class="w-6 h-6" id="menu-icon"></i>
                <i data-lucide="x" class="w-6 h-6 hidden" id="close-icon"></i>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="absolute top-16 left-0 right-0 bg-white border-b shadow-lg md:hidden hidden">
            <nav class="flex flex-col space-y-4 p-4">
                <a href="index.php" class="flex items-center space-x-2 text-green-700 hover:text-green-600 transition-colors">
                    <i data-lucide="home" class="w-4 h-4"></i><span>Home</span>
                </a>
                <a href="providers.php" class="flex items-center space-x-2 text-green-700 hover:text-green-600 transition-colors">
                    <i data-lucide="users" class="w-4 h-4"></i><span>Cat Hostel Providers</span>
                </a>
                <a href="interested.php" class="text-green-700 hover:text-green-600 transition-colors">
                    Give Your Cat to Hostel
                </a>
                <a href="products.php" class="flex items-center space-x-2 text-green-700 hover:text-green-600 transition-colors">
                    <i data-lucide="package" class="w-4 h-4"></i><span>Products</span>
                </a>
                <a href="contact.php" class="flex items-center space-x-2 text-green-700 hover:text-green-600 transition-colors">
                    <i data-lucide="message-circle" class="w-4 h-4"></i><span>Contact Us</span>
                </a>
                <a href="urgent-vet.php" class="flex items-center space-x-2 text-red-600 hover:text-red-700 transition-colors font-medium">
                    <i data-lucide="stethoscope" class="w-4 h-4"></i><span>🚨 Urgent Vet</span>
                </a>
                <div class="flex flex-col space-y-2 pt-2 border-t border-green-200">
                    <button onclick="openSignInModal()" class="border border-green-600 text-green-600 hover:bg-green-50 bg-transparent px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Sign In
                    </button>
                    <button onclick="openModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Sign Up
                    </button>
                </div>
            </nav>
        </div>
    </div>
</header>

<!-- Sign Up Modal -->
<div id="signupModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden justify-center items-center">
  <div class="bg-white p-6 rounded-lg w-full max-w-md relative shadow-lg">
    <button class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-xl font-bold" onclick="closeModal()">&times;</button>
    <h2 class="text-xl font-semibold mb-4 text-center text-green-700">Create Your Account</h2>


    
    <form method="POST" action="process-signup.php" id="signupForm" class="space-y-3">
      <input type="text" name="first_name" placeholder="First Name" required class="w-full border px-3 py-2 rounded-md" />
      <input type="text" name="last_name" placeholder="Last Name" required class="w-full border px-3 py-2 rounded-md" />
      <input type="text" name="email" placeholder="Email" required class="w-full border px-3 py-2 rounded-md" />
      <input type="text" name="phone" placeholder="Phone" required class="w-full border px-3 py-2 rounded-md" />
      <input type="text" name="address" placeholder="Address" required class="w-full border px-3 py-2 rounded-md" />
      <input type="text" name="username" placeholder="Username" required class="w-full border px-3 py-2 rounded-md" />
      <input type="password" name="password" placeholder="Password" required class="w-full border px-3 py-2 rounded-md" />
      <input type="password" name="confirm_password" placeholder="Confirm Password" required class="w-full border px-3 py-2 rounded-md" />
      <select name="role" required class="w-full border px-3 py-2 rounded-md">
        <option value="">-- Select Role --</option>
        <option value="owner">Cat Owner</option>
        <option value="hostel">Hostel Service Provider</option>
        <option value="vet">Veterinarian</option>
      </select>
      <button type="submit" name="sign_up_btn" class="w-full bg-green-600 text-white font-semibold py-2 rounded-md hover:bg-green-700 transition">Create Account</button>
    </form>
  </div>
</div>

<!-- Sign In Modal -->
<div id="signinModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden justify-center items-center">
  <div class="bg-white p-6 rounded-lg w-full max-w-md relative shadow-lg">
    <button class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-xl font-bold" onclick="closeSignInModal()">&times;</button>

    <!-- Sign In Form -->
    <div id="signinForm">
      <h2 class="text-xl font-semibold mb-4 text-green-700">Sign In to MeowMate</h2>
      <form method="POST" action="process-signin.php" class="space-y-4">
        <input type="text" name="username" placeholder="Username" required class="w-full border px-3 py-2 rounded-md" />
        <input type="password" name="password" placeholder="Password" required class="w-full border px-3 py-2 rounded-md" />
        <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2 rounded-md hover:bg-green-700 transition">
          Sign In
        </button>
      </form>
      <p class="text-sm text-gray-500 mt-4">
        Forgot your password?
        <button onclick="showResetForm()" class="text-green-600 hover:underline">Reset here</button>
      </p>
    </div>

    <!-- Reset Form -->
    <div id="resetForm" class="hidden">
      <h2 class="text-xl font-semibold mb-4 text-green-700">Reset Your Password</h2>
      <form method="POST" action="process-send-code.php" class="space-y-4">
        <input type="text" name="username" placeholder="Username" required class="w-full border px-3 py-2 rounded-md" />
        <input type="email" name="email" placeholder="Your Email" required class="w-full border px-3 py-2 rounded-md" />
        <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2 rounded-md hover:bg-green-700 transition">
          Send Verification Code
        </button>
      </form>
      <p class="text-sm text-gray-500 mt-4">
        Remembered your password?
        <button onclick="showSignInForm()" class="text-green-600 hover:underline">Back to Sign In</button>
      </p>
    </div>
  </div>
</div>
