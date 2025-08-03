<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign In | MeowMate</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen">

  <!-- Sign In Modal -->
  <div class="bg-white p-8 rounded-xl shadow-md text-center max-w-md w-full border border-green-200">
    <h2 class="text-xl font-semibold mb-4 text-green-700">Sign In to MeowMate</h2>

    <form method="POST" action="process-signin.php" class="space-y-4">
      <input type="text" name="username" placeholder="Username" required class="w-full border px-3 py-2 rounded-md" />
      <input type="password" name="password" placeholder="Password" required class="w-full border px-3 py-2 rounded-md" />

      <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2 rounded-md hover:bg-green-700 transition">
        Sign In
      </button>
    </form>

    <p class="text-sm text-gray-500 mt-4">Don't have an account? <a href="index.php" class="text-green-600 hover:underline">Sign up here</a></p>
  </div>
</body>
</html>
