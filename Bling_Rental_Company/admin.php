<?php

require_once 'config.php';
require_once __DIR__ . '/admin_check.php';

// Track page visit
$createTableQuery = "CREATE TABLE IF NOT EXISTS admin_stats (stat_key VARCHAR(50) PRIMARY KEY, value INT DEFAULT 0, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
@$conn->query($createTableQuery);
$updateHitsQuery = "INSERT INTO admin_stats (stat_key, value) VALUES ('live_hits_today', 1) ON DUPLICATE KEY UPDATE value = value + 1";
@$conn->query($updateHitsQuery);

// 2. Include your database connection to pull real users
// (Change 'db_connect.php' to match your actual file name if different)
if (!isset($conn)) {
    if (isset($db)) {
        $conn = $db;
    } elseif (isset($mysqli)) {
        $conn = $mysqli;
    } elseif (isset($link)) {
        $conn = $link;
    } elseif (isset($con)) {
        $conn = $con;
    }
}

if (!isset($conn) || !method_exists($conn, 'query')) {
    die('Database connection not established. Please verify db_connect.php defines a valid mysqli or PDO connection in $conn, $db, $mysqli, $link or $con.');
}

// Fetch users from the database for the Blacklist Control tab
$userQuery = "SELECT id, full_name, email, is_blocked FROM users";
$userResult = $conn->query($userQuery);

// Fetch feedback from the database for the Feedback tab
$feedbackResult = null;
$feedbackQuery = "SELECT id, client_name, client_email, message, admin_response, created_at FROM feedback ORDER BY created_at DESC";
$queryResult = @$conn->query($feedbackQuery);

if ($queryResult === false) {
    // If the query fails (missing columns), try to create/alter the table
    $alterQuery = "ALTER TABLE `feedback` ADD COLUMN `client_name` VARCHAR(100) DEFAULT 'Anonymous' AFTER `id`, ADD COLUMN `client_email` VARCHAR(150) DEFAULT NULL AFTER `client_name`";
    @$conn->query($alterQuery);
    // Retry the original query
    $feedbackResult = @$conn->query($feedbackQuery);
} else {
    $feedbackResult = $queryResult;
}

// Fetch bookings from the database for the Bookings tab
$bookingsResult = null;
$bookingsQuery = "SELECT id, full_name, vehicle_name, total_payment, status, booking_date FROM bookings ORDER BY booking_date DESC";
$queryResult = @$conn->query($bookingsQuery);

if ($queryResult === false) {
    // If the query fails (missing columns), try to add the full_name column
    $alterQuery = "ALTER TABLE `bookings` ADD COLUMN `full_name` VARCHAR(100) DEFAULT NULL AFTER `vehicle_name`";
    @$conn->query($alterQuery);
    // Retry the original query
    $bookingsResult = @$conn->query($bookingsQuery);
} else {
    $bookingsResult = $queryResult;
}

// Fetch dashboard statistics
$liveHits = 0;
$rentedCars = 0;
$totalVehicles = 0;
$availableFleet = 0;
$totalPayments = 0;

// Fetch staff from the database for the Employees tab
$staffResult = null;
$staffQuery = "SELECT id, full_name, email, license_number, role, rating, reviews_count, created_at FROM staff ORDER BY created_at DESC";
$queryResult = @$conn->query($staffQuery);

if ($queryResult === false) {
    // If the query fails, the table might not exist yet
    $staffResult = null;
} else {
    $staffResult = $queryResult;
}

// Get total payments from bookings
$paymentQuery = "SELECT COUNT(*) as rented_count, SUM(total_payment) as total_paid FROM bookings WHERE status = 'Confirmed'";
$paymentResult = @$conn->query($paymentQuery);
if ($paymentResult && $paymentResult->num_rows === 1) {
    $row = $paymentResult->fetch_assoc();
    $rentedCars = intval($row['rented_count']);
    $totalPayments = floatval($row['total_paid'] ?? 0);
}

// Get total vehicles count
$vehicleQuery = "SELECT COUNT(*) as total_count FROM vehicles";
$vehicleResult = @$conn->query($vehicleQuery);
if ($vehicleResult && $vehicleResult->num_rows === 1) {
    $row = $vehicleResult->fetch_assoc();
    $totalVehicles = intval($row['total_count']);
    $availableFleet = $totalVehicles - $rentedCars;
}

// Get live hits (page visits)
$hitsQuery = "SELECT COALESCE(value, 0) as hits_count FROM admin_stats WHERE stat_key = 'live_hits_today'";
$hitsResult = @$conn->query($hitsQuery);
if ($hitsResult && $hitsResult->num_rows === 1) {
    $row = $hitsResult->fetch_assoc();
    $liveHits = intval($row['hits_count']);
} else {
    // If table doesn't exist, create it
    @$conn->query("CREATE TABLE IF NOT EXISTS admin_stats (stat_key VARCHAR(50) PRIMARY KEY, value INT DEFAULT 0, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");
    @$conn->query("INSERT IGNORE INTO admin_stats (stat_key, value) VALUES ('live_hits_today', 0)");
}

// 3. Include simplified admin header
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bling Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">


<div class="flex min-h-screen bg-gray-100 mt-1">

    <aside class="w-64 bg-gray-900 text-gray-200 flex flex-col shadow-xl">
        <div class="p-5 border-b border-gray-800 flex items-center gap-3">
            <div class="bg-blue-500 text-white p-2 rounded-lg">
                <i class="fa-solid fa-car text-lg"></i>
            </div>
            <div>
                <h2 class="font-bold text-white text-sm tracking-wide">Bling Rental Company</h2>
                <span class="text-xs text-green-400 font-semibold"><i class="fa-solid fa-circle text-[8px] animate-pulse"></i> Admin Panel</span>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            <button onclick="switchTab('overview')" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg bg-blue-600 text-white transition">
                <i class="fa-solid fa-chart-line w-5"></i> System Traffic
            </button>
            <button onclick="switchTab('inventory')" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-car-rear w-5"></i> Fleet Management
            </button>
            <button onclick="switchTab('employees')" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-id-card w-5"></i> Drivers & Staff
            </button>
            <button onclick="switchTab('bookings')" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-calendar-check w-5"></i> Rented & Available
            </button>
            <button onclick="switchTab('gps')" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-map-location-dot w-5"></i> Live GPS Tracking
            </button>
            <button onclick="switchTab('feedback')" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-comments w-5"></i> Client Feedbacks
            </button>
            <button onclick="switchTab('users')" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-user-slash w-5"></i> Block / Ban Access
            </button>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <a href="admin_logout.php" class="w-full flex items-center justify-center gap-2 bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white text-xs font-semibold py-2.5 rounded transition" onclick="if(!confirm('Are you sure you want to logout?')) return false;">
                <i class="fa-solid fa-power-off"></i> Logout
            </a>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Live Hits Today</p>
                    <h3 class="stat-counter text-2xl font-bold text-gray-800 mt-1" data-target="<?php echo $liveHits; ?>">0</h3>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-500"><i class="fa-solid fa-chart-bar text-xl"></i></div>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Rented Out</p>
                    <h3 class="stat-counter text-2xl font-bold text-amber-600 mt-1" data-target="<?php echo $rentedCars; ?>">0</h3>
                    <span class="text-xs text-gray-500 ml-1">Cars</span>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center text-amber-500"><i class="fa-solid fa-key text-xl"></i></div>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Available Fleet</p>
                    <h3 class="stat-counter text-2xl font-bold text-green-600 mt-1" data-target="<?php echo $availableFleet; ?>">0</h3>
                    <span class="text-xs text-gray-500 ml-1">Cars</span>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-green-500"><i class="fa-solid fa-circle-check text-xl"></i></div>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total Payments</p>
                    <h3 class="stat-counter text-2xl font-bold text-gray-800 mt-1" data-target="<?php echo number_format($totalPayments, 2, '.', ''); ?>">0</h3>
                    <span class="text-xs text-gray-500 ml-1">E</span>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center text-purple-500"><i class="fa-solid fa-wallet text-xl"></i></div>
            </div>
        </div>

        <!-- Overview Tab -->
        <div id="overview-tab" class="dashboard-content space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fa-solid fa-chart-area text-blue-500 mr-2"></i> Server Performance & Web Traffic Metrics</h3>
                <div class="h-64 bg-gray-50 border border-gray-200 rounded-lg flex items-end p-4 justify-between space-x-2">
                    <div class="w-full bg-blue-500 rounded-t" style="height: 40%"></div>
                    <div class="w-full bg-blue-500 rounded-t" style="height: 55%"></div>
                    <div class="w-full bg-blue-500 rounded-t" style="height: 75%"></div>
                    <div class="w-full bg-blue-600 rounded-t" style="height: 90%"></div>
                    <div class="w-full bg-blue-700 rounded-t" style="height: 60%"></div>
                    <div class="w-full bg-blue-500 rounded-t" style="height: 85%"></div>
                    <div class="w-full bg-blue-600 rounded-t" style="height: 95%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 font-semibold uppercase mt-3 px-1">
                    <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                </div>
            </div>
        </div>

        <!-- Inventory Tab -->
        <div id="inventory-tab" class="dashboard-content hidden space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fa-solid fa-plus text-blue-500 mr-2"></i> Register New Vehicle Resource</h3>
                <form id="vehicleForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="text" name="name" placeholder="Car Name (e.g. Mercedes C200)" required class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white" />
                    <input type="text" name="type" placeholder="Category Type (SUV, Sedan)" required class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white" />
                    <input type="number" name="price_per_day" placeholder="Daily Rate (SZL E)" required class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white" />
                    <input type="text" name="location" placeholder="Location Office" required class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white" />
                    <input type="text" name="fuel" placeholder="Fuel Configuration" required class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white" />
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 px-4 rounded shadow transition cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Save to MySQL Inventory
                    </button>
                </form>
            </div>
        </div>

        <!-- Employees Tab -->
        <div id="employees-tab" class="dashboard-content hidden space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fa-solid fa-user-plus text-blue-500 mr-2"></i> Onboard New Employee / Chauffeur Driver</h3>
                <form id="staffForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="text" name="full_name" placeholder="Full Name" required class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white" />
                    <input type="email" name="email" placeholder="Staff Email Protocol" required class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white" />
                    <input type="text" name="license_number" placeholder="License Number Assignment" required class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white" />
                    <input type="tel" name="phone" placeholder="Phone Number (+268...)" class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white" />
                    <input type="text" name="address" placeholder="Residential Address" class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white" />
                    <input type="number" name="experience_years" placeholder="Years of Experience" min="0" class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white" />
                    <select name="role" class="p-2.5 border rounded text-sm focus:outline-none focus:border-blue-500 bg-white text-gray-600">
                        <option value="Chauffeur Driver">Role: Chauffeur Driver</option>
                        <option value="Maintenance Tech">Role: Maintenance Tech</option>
                        <option value="Branch Desk Supervisor">Role: Branch Desk Supervisor</option>
                    </select>
                    <button type="submit" class="md:col-span-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold py-2.5 rounded shadow transition cursor-pointer">
                        <i class="fa-solid fa-address-card mr-1"></i> Commit Employee Credentials
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-gray-800 text-base"><i class="fa-solid fa-users text-blue-500 mr-1"></i> Registered Staff & Drivers Directory</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 text-xs uppercase font-bold border-b border-gray-200">
                                <th class="p-4">Name</th>
                                <th class="p-4">Role</th>
                                <th class="p-4">License</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Rating</th>
                                <th class="p-4">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                            <?php
                            if ($staffResult && $staffResult->num_rows > 0):
                                while ($staff = $staffResult->fetch_assoc()):
                            ?>
                                <tr>
                                    <td class="p-4 font-medium"><?php echo htmlspecialchars($staff['full_name']); ?></td>
                                    <td class="p-4">
                                        <?php if ($staff['role'] === 'Chauffeur Driver'): ?>
                                            <span class="bg-blue-100 text-blue-700 px-2.5 py-0.5 rounded-full font-semibold text-xs">Chauffeur</span>
                                        <?php else: ?>
                                            <span class="bg-gray-100 text-gray-700 px-2.5 py-0.5 rounded-full font-semibold text-xs"><?php echo htmlspecialchars($staff['role']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 font-mono text-xs"><?php echo htmlspecialchars($staff['license_number']); ?></td>
                                    <td class="p-4">
                                        <div class="text-xs text-gray-600"><?php echo htmlspecialchars($staff['email']); ?></div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-1 text-amber-500 font-bold">
                                            <i class="fa-solid fa-star text-xs"></i>
                                            <?php echo number_format($staff['rating'] ?? 4.5, 1); ?>
                                            <span class="text-gray-400 font-normal text-xs">(<?php echo $staff['reviews_count'] ?? 0; ?>)</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-xs text-gray-500"><?php echo date('M d, Y', strtotime($staff['created_at'])); ?></td>
                                </tr>
                            <?php
                                endwhile;
                            else:
                            ?>
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-500 italic">No staff members registered yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bookings Tab -->
        <div id="bookings-tab" class="dashboard-content hidden space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-base"><i class="fa-solid fa-receipt text-purple-500 mr-1"></i> Booking Commitments & Payment Audit Trail</h3>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-xs uppercase font-bold border-b border-gray-200">
                            <th class="p-4">Customer Name</th>
                            <th class="p-4">Vehicle Model</th>
                            <th class="p-4">Payment Cleared</th>
                            <th class="p-4">Status Flag</th>
                            <th class="p-4">Booking Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                        <?php
                        if ($bookingsResult && $bookingsResult->num_rows > 0):
                            while ($booking = $bookingsResult->fetch_assoc()):
                                $statusClass = 'bg-gray-100 text-gray-800';
                                $statusText = 'Pending';

                                if ($booking['status'] === 'Confirmed') {
                                    $statusClass = 'bg-amber-100 text-amber-800';
                                    $statusText = 'Active Rental';
                                } elseif ($booking['status'] === 'Completed') {
                                    $statusClass = 'bg-green-100 text-green-800';
                                    $statusText = 'Available / Returned';
                                } elseif ($booking['status'] === 'Cancelled') {
                                    $statusClass = 'bg-red-100 text-red-800';
                                    $statusText = 'Cancelled';
                                }
                        ?>
                                <tr>
                                    <td class="p-4 font-medium"><?php echo htmlspecialchars($booking['full_name'] ?? 'Guest User'); ?></td>
                                    <td class="p-4"><?php echo htmlspecialchars($booking['vehicle_name'] ?? 'N/A'); ?></td>
                                    <td class="p-4 font-bold text-purple-600">E<?php echo number_format($booking['total_payment'] ?? 0, 2); ?></td>
                                    <td class="p-4"><span class="<?php echo $statusClass; ?> text-xs px-2.5 py-0.5 rounded-full font-semibold"><?php echo $statusText; ?></span></td>
                                    <td class="p-4 text-xs text-gray-500"><?php echo date('M d, Y', strtotime($booking['booking_date'])); ?></td>
                                </tr>
                            <?php
                            endwhile;
                        else:
                            ?>
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500 italic">No bookings found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- GPS Tab -->
        <div id="gps-tab" class="dashboard-content hidden space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-satellite text-blue-500 mr-2"></i> Active Fleet Tracking Framework</h3>
                    <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-semibold animate-pulse">Live telemetry</span>
                </div>
                <div class="w-full h-96 rounded-xl overflow-hidden relative border border-gray-300 shadow-inner bg-blue-50">
                    <iframe class="w-full h-full border-none" src="https://maps.google.com/maps?q=Mbabane,Eswatini&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
                </div>
            </div>
        </div>

        <!-- Feedback Tab -->
        <div id="feedback-tab" class="dashboard-content hidden space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-4">
                <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-comment-dots text-teal-500 mr-2"></i> Incoming Client Comments & Email Responder Engines</h3>

                <?php if ($feedbackResult && $feedbackResult->num_rows > 0): ?>
                    <?php while ($feedback = $feedbackResult->fetch_assoc()): ?>
                        <div class="p-4 bg-gray-50 border rounded-xl space-y-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($feedback['client_name']); ?></h4>
                                    <span class="text-xs text-blue-500 font-medium"><?php echo htmlspecialchars($feedback['client_email']); ?></span>
                                </div>
                                <span class="text-xs text-gray-400 font-medium"><?php echo date('M d, Y', strtotime($feedback['created_at'])); ?></span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed italic">"<?php echo htmlspecialchars($feedback['message']); ?>"</p>

                            <?php if ($feedback['admin_response']): ?>
                                <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded text-sm">
                                    <p class="font-semibold text-green-800 text-xs mb-1">Admin Response:</p>
                                    <p class="text-green-700"><?php echo htmlspecialchars($feedback['admin_response']); ?></p>
                                </div>
                            <?php else: ?>
                                <form class="mt-4 replyForm" data-feedback-id="<?php echo $feedback['id']; ?>">
                                    <input type="hidden" name="feedback_id" value="<?php echo $feedback['id']; ?>" />
                                    <input type="hidden" name="client_email" value="<?php echo htmlspecialchars($feedback['client_email']); ?>" />
                                    <div class="flex gap-2">
                                        <textarea name="admin_response" required placeholder="Type direct administrative email feedback answer here..." class="flex-1 p-2 border rounded text-xs focus:outline-none focus:border-blue-500 bg-white resize-none" rows="2"></textarea>
                                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold px-4 rounded transition flex items-center gap-1 cursor-pointer">
                                            <i class="fa-solid fa-paper-plane text-[10px]"></i> Dispatch Email
                                        </button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="p-4 bg-gray-50 border rounded-xl text-center">
                        <p class="text-gray-500 text-sm"><i class="fa-solid fa-inbox text-gray-400 mr-2"></i> No feedback received yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Users Tab (Dynamic Table Loop integrated here) -->
        <div id="users-tab" class="dashboard-content hidden space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-gray-800 text-base"><i class="fa-solid fa-user-lock text-red-500 mr-1"></i> User Authentication Blacklist Controls</h3>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-xs uppercase font-bold border-b border-gray-200">
                            <th class="p-4">Account ID</th>
                            <th class="p-4">Full Name</th>
                            <th class="p-4">Email Index</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-right">Administrative Action Button</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                        <?php
                        if ($userResult && $userResult->num_rows > 0):
                            while ($user = $userResult->fetch_assoc()):
                        ?>
                                <tr>
                                    <td class="p-4 font-mono font-medium text-gray-600">#USR-<?php echo $user['id']; ?></td>
                                    <td class="p-4 font-medium"><?php echo htmlspecialchars($user['full_name']); ?></td>
                                    <td class="p-4 text-gray-500"><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td class="p-4 text-center">
                                        <?php if ($user['is_blocked'] == 1): ?>
                                            <span class="bg-red-100 text-red-700 px-2.5 py-0.5 rounded-full font-semibold text-xs">Blocked</span>
                                        <?php else: ?>
                                            <span class="bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full font-semibold text-xs">Active</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 text-right">
                                        <?php if ($user['is_blocked'] == 0): ?>
                                            <!-- STEP 4 BLOCK BUTTON CODE INSERTED SAFELY -->
                                            <button onclick="blockUser(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['full_name'], ENT_QUOTES); ?>')" class="bg-red-500 text-white px-3 py-1.5 rounded text-xs font-semibold hover:bg-red-700 transition inline-block shadow-sm cursor-pointer border-0">
                                                <i class="fa-solid fa-ban mr-1"></i> Block User
                                            </button>
                                        <?php else: ?>
                                            <button disabled class="bg-gray-200 text-gray-400 px-3 py-1.5 rounded text-xs font-semibold cursor-not-allowed inline-block">
                                                <i class="fa-solid fa-lock mr-1"></i> Permanently Blocked
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php
                            endwhile;
                        else:
                            ?>
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500 italic">No registered users found in database architecture.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<script>
    async function blockUser(userId, userName) {
        if (!confirm('Are you sure you want to permanently block ' + userName + ' from the system?')) {
            return;
        }

        try {
            const response = await fetch('block_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userId
                })
            });

            const result = await response.json();
            if (result.success) {
                alert('User ' + userName + ' has been permanently blocked from the system.');
                location.reload();
            } else {
                alert('Error: ' + (result.message || 'Failed to block user'));
            }
        } catch (error) {
            alert('Error: ' + error.message);

            // Handle staff registration form submission
            const staffForm = document.getElementById('staffForm');
            if (staffForm) {
                staffForm.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const fullName = staffForm.querySelector('input[name="full_name"]').value;
                    const email = staffForm.querySelector('input[name="email"]').value;
                    const licenseNumber = staffForm.querySelector('input[name="license_number"]').value;
                    const phone = staffForm.querySelector('input[name="phone"]').value;
                    const address = staffForm.querySelector('input[name="address"]').value;
                    const experienceYears = staffForm.querySelector('input[name="experience_years"]').value;
                    const role = staffForm.querySelector('select[name="role"]').value;

                    try {
                        const response = await fetch('process_staff_register.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                full_name: fullName,
                                email: email,
                                license_number: licenseNumber,
                                phone: phone,
                                address: address,
                                experience_years: experienceYears,
                                role: role
                            })
                        });

                        const result = await response.json();
                        if (result.success) {
                            addStaffToTable(result);
                            showStaffSuccessModal(result);
                            staffForm.reset();
                        } else {
                            alert('Error: ' + (result.message || 'Failed to register employee'));
                        }
                    } catch (error) {
                        alert('Error: ' + error.message);
                    }
                });
            }

            // Handle vehicle registration form submission
            const vehicleForm = document.getElementById('vehicleForm');
            if (vehicleForm) {
                vehicleForm.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const name = vehicleForm.querySelector('input[name="name"]').value;
                    const type = vehicleForm.querySelector('input[name="type"]').value;
                    const pricePerDay = vehicleForm.querySelector('input[name="price_per_day"]').value;
                    const location = vehicleForm.querySelector('input[name="location"]').value;
                    const fuel = vehicleForm.querySelector('input[name="fuel"]').value;

                    try {
                        const response = await fetch('api/vehicles/add.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                name: name,
                                type: type,
                                price_per_day: pricePerDay,
                                location: location,
                                fuel: fuel
                            })
                        });

                        const result = await response.json();
                        if (result.success) {
                            alert('Vehicle added successfully!');
                            vehicleForm.reset();
                        } else {
                            alert('Error: ' + (result.message || 'Failed to add vehicle'));
                        }
                    } catch (error) {
                        alert('Error: ' + error.message);
                    }
                });
            }

            // Add new staff to the table dynamically
            function addStaffToTable(data) {
                const tableBody = document.querySelector('#employees-tab tbody');
                if (!tableBody) return;

                // Remove "No staff members registered yet" row if it exists
                const noStaffRow = tableBody.querySelector('td[colspan]');
                if (noStaffRow) {
                    noStaffRow.closest('tr').remove();
                }

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td class="p-4 font-medium">${data.staff_name}</td>
                    <td class="p-4">
                        ${data.staff_role === 'Chauffeur Driver' 
                            ? '<span class="bg-blue-100 text-blue-700 px-2.5 py-0.5 rounded-full font-semibold text-xs">Chauffeur</span>'
                            : `<span class="bg-gray-100 text-gray-700 px-2.5 py-0.5 rounded-full font-semibold text-xs">${data.staff_role}</span>`
                        }
                    </td>
                    <td class="p-4 font-mono text-xs">${data.staff_license}</td>
                    <td class="p-4">
                        <div class="text-xs text-gray-600">${data.staff_email}</div>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-1 text-amber-500 font-bold">
                            <i class="fa-solid fa-star text-xs"></i>
                            4.5
                            <span class="text-gray-400 font-normal text-xs">(0)</span>
                        </div>
                    </td>
                    <td class="p-4 text-xs text-gray-500">${new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                `;

                // Add animation class
                newRow.style.animation = 'fadeIn 0.5s ease-out';
                tableBody.insertBefore(newRow, tableBody.firstChild);
            }

            // Show success modal with employee details
            function showStaffSuccessModal(data) {
                const modalHTML = `
                    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 animate-fadeIn">
                        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl animate-slideUp">
                            <div class="text-center">
                                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-check text-green-600 text-2xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">Employee Added Successfully!</h2>
                                <p class="text-sm text-gray-500 mb-6">New driver has been registered and is now available in the booking system.</p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4 space-y-3 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Name:</span>
                                    <span class="font-bold text-gray-900">${data.staff_name}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Email:</span>
                                    <span class="font-bold text-gray-900 text-sm">${data.staff_email}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">License:</span>
                                    <span class="font-bold text-gray-900">${data.staff_license}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Role:</span>
                                    <span class="font-bold text-blue-600">${data.staff_role}</span>
                                </div>
                            </div>

                            <button onclick="this.closest('.fixed').remove();" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
                                <i class="fa-solid fa-check mr-2"></i> Close
                            </button>
                        </div>
                    </div>
                    <style>
                        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
                        @keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
                        .animate-fadeIn { animation: fadeIn 0.3s ease-out; }
                        .animate-slideUp { animation: slideUp 0.3s ease-out; }
                    </style>
                `;

                const modal = document.createElement('div');
                modal.innerHTML = modalHTML;
                document.body.appendChild(modal.firstElementChild);
            }
        }
    }

    function switchTab(tabId) {
        document.querySelectorAll('.dashboard-content').forEach(element => {
            element.classList.add('hidden');
        });

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('hover:bg-gray-800', 'text-gray-400', 'hover:text-white');
        });

        document.getElementById(tabId + '-tab').classList.remove('hidden');

        const activeBtn = window.event.currentTarget;
        activeBtn.classList.add('bg-blue-600', 'text-white');
        activeBtn.classList.remove('hover:bg-gray-800', 'text-gray-400', 'hover:text-white');
    }

    // Animate counters on page load
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-counter');
        
        counters.forEach(counter => {
            const target = parseFloat(counter.getAttribute('data-target'));
            const duration = 2000; // 2 seconds animation
            const startTime = Date.now();
            const isCurrency = counter.textContent.includes('E') || counter.parentElement.textContent.includes('E');
            
            function updateCounter() {
                const elapsed = Date.now() - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const current = Math.floor(progress * target);
                
                if (isCurrency && current < target) {
                    // Format as currency with 2 decimal places
                    counter.textContent = current.toLocaleString('en-US', { 
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2 
                    });
                } else if (isCurrency) {
                    counter.textContent = target.toLocaleString('en-US', { 
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2 
                    });
                } else {
                    counter.textContent = current.toLocaleString('en-US');
                }
                
                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                }
            }
            
            updateCounter();
        });
    }
    
    // Start animation when page loads
    window.addEventListener('load', animateCounters);

    // Handle feedback reply submission
    document.querySelectorAll('.replyForm').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const feedbackId = form.getAttribute('data-feedback-id');
            const adminReply = form.querySelector('textarea[name="admin_response"]').value;
            const clientEmail = form.querySelector('input[name="client_email"]').value;

            try {
                const response = await fetch('process_admin_reply.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        feedback_id: feedbackId,
                        admin_response: adminReply,
                        client_email: clientEmail
                    })
                });

                const result = await response.json();
                if (result.success) {
                    alert('Reply sent successfully to ' + clientEmail);
                    location.reload();
                } else {
                    alert('Error: ' + (result.message || 'Failed to send reply'));
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    });
</script>

<?php
include(__DIR__ . '/layouts/footer.php');
?>