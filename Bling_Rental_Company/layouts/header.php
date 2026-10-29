<?php
// Initialize session at the very top to check for user roles safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration to use BASE_URL consistently in navigation links
if (!defined('BASE_URL')) {
    $configPath = __DIR__ . '/../config.php';
    if (file_exists($configPath)) {
        require_once $configPath;
    }
}

// Determine admin and authenticated state from session
$isAdminLoggedIn = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
$isLoggedIn = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
$userName = $_SESSION['user_name'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bling Rental Company</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/scrollreveal"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .shadow-elegant {
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05), 0 2px 5px -1px rgba(0, 0, 0, 0.03);
        }

        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <nav class="bg-white shadow-elegant sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="index.php" class="flex items-center space-x-2 text-gray-800">
                    <i class="fa-solid fa-car text-blue-600 text-2xl h-8 w-8 flex items-center"></i>
                    <span class="text-xl font-bold tracking-tight">Bling Rental Company</span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?php echo defined('BASE_URL') ? BASE_URL : '/Bling_Rental_Company/'; ?>" class="text-gray-700 hover:text-blue-700 font-medium transition-colors">Home</a>
                    <a href="<?php echo defined('BASE_URL') ? BASE_URL . 'booking.php' : '/Bling_Rental_Company/booking.php'; ?>" class="text-gray-700 hover:text-blue-700 font-medium transition-colors">Rent a Car</a>
                    <a href="<?php echo defined('BASE_URL') ? BASE_URL . 'features.php' : '/Bling_Rental_Company/features.php'; ?>" class="text-gray-700 hover:text-blue-700 font-medium transition-colors">About Us</a>
                    <a href="<?php echo defined('BASE_URL') ? BASE_URL . 'contact.php' : '/Bling_Rental_Company/contact.php'; ?>" class="text-gray-700 hover:text-blue-700 font-medium transition-colors">Contact Us</a>
                    <a href="<?php echo defined('BASE_URL') ? BASE_URL . (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true ? 'admin.php' : 'admin_gate.php') : '/Bling_Rental_Company/admin_gate.php'; ?>" class="text-amber-600 hover:text-amber-700 font-semibold transition-colors flex items-center gap-1.5 bg-amber-50 px-3 py-1 rounded-md border border-amber-200 shadow-sm">
                        <i class="fa-solid fa-user-gear text-sm animate-pulse"></i> Admin Panel
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <?php if ($isLoggedIn): ?>
                        <div class="relative group">
                            <a href="<?php echo defined('BASE_URL') ? BASE_URL : '/Bling_Rental_Company/'; ?>" class="py-1.5 px-3 flex items-center gap-2 rounded text-sm font-medium text-gray-700 transition duration-300 hover:bg-gray-100">
                                <i class="fa-solid fa-user text-xs"></i><span><?php echo htmlspecialchars($userName ?: 'Profile'); ?></span>
                            </a>
                            <div class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg hidden group-hover:block">
                                <a href="<?php echo defined('BASE_URL') ? BASE_URL . 'logout.php' : '/Bling_Rental_Company/logout.php'; ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo defined('BASE_URL') ? BASE_URL . 'login.php' : '/Bling_Rental_Company/login.php'; ?>" class="py-1.5 px-3 flex items-center gap-2 rounded text-sm font-medium text-gray-700 transition duration-300 hover:bg-gray-100">
                            <i class="fa-solid fa-right-to-bracket text-xs"></i><span>Login</span>
                        </a>
                        <a href="<?php echo defined('BASE_URL') ? BASE_URL . 'signup.php' : '/Bling_Rental_Company/signup.php'; ?>" class="bg-blue-600 text-white px-4 py-2 rounded font-medium hover:bg-blue-700 transition">
                            Sign Up
                        </a>
                    <?php endif; ?>
                </div>

                <div class="md:hidden">
                    <button id="menu-btn" class="text-gray-600 p-2 focus:outline-none hover:bg-gray-100 rounded">
                        <i id="menu-icon" class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');

            if (menuBtn && mobileMenu && menuIcon) {
                menuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    if (mobileMenu.classList.contains('hidden')) {
                        menuIcon.className = 'fa-solid fa-bars text-xl';
                    } else {
                        menuIcon.className = 'fa-solid fa-xmark text-xl';
                    }
                });
            }
        });
    </script>

    <main class="flex-grow">