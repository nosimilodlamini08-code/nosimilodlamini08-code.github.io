<?php
// payment.php - Receipt and Payment Confirmation Display
include(__DIR__ . '/layouts/header.php');
require_once 'config.php';

// Get booking ID from URL parameter
$bookingId = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

// Default receipt data
$receiptData = [
    'booking_id' => $bookingId,
    'vehicle_name' => 'N/A',
    'driver_name' => 'N/A',
    'payment_method' => 'N/A',
    'transit_method' => 'N/A',
    'handover_address' => 'N/A',
    'total_payment' => '0.00',
    'created_at' => date('Y-m-d H:i:s'),
    'status' => 'Confirmed'
];

// Fetch booking details from database if booking_id is provided
if ($bookingId > 0) {
    $query = "SELECT id, vehicle_name, full_name, driver_name, payment_method, transit_method, handover_address, total_payment, status, booking_date FROM bookings WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param('i', $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows === 1) {
            $booking = $result->fetch_assoc();
            $receiptData = [
                'booking_id' => $booking['id'],
                'vehicle_name' => $booking['vehicle_name'],
                'driver_name' => $booking['driver_name'],
                'payment_method' => $booking['payment_method'],
                'transit_method' => $booking['transit_method'],
                'handover_address' => $booking['handover_address'],
                'total_payment' => number_format($booking['total_payment'], 2),
                'created_at' => date('M d, Y \a\t g:i A', strtotime($booking['booking_date'])),
                'status' => $booking['status']
            ];
        }
        $stmt->close();
    }
}
?>

<main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div id="payment-receipt" class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 space-y-8">
        
        <!-- Receipt Header -->
        <div class="border-b border-gray-200 pb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">Payment Receipt</h1>
                    <p class="text-sm text-gray-500 mt-1">Car Rental Booking Confirmation</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg font-bold text-sm">
                        <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($receiptData['status']); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company Info & Receipt Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">From</h3>
                <div class="space-y-1">
                    <p class="text-lg font-black text-gray-900">Bling Rental Company</p>
                    <p class="text-sm text-gray-600">Suite 402, Bling Towers</p>
                    <p class="text-sm text-gray-600">Custom Corporate Highway</p>
                    <p class="text-sm text-gray-600">Mbabane, Eswatini</p>
                </div>
            </div>

            <div class="text-right">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Booking Details</h3>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">
                        <span class="font-bold text-gray-900">Booking ID:</span>
                        <span class="font-mono font-bold text-blue-600">#<?php echo htmlspecialchars($receiptData['booking_id']); ?></span>
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-bold text-gray-900">Date & Time:</span>
                        <span class="font-bold text-gray-700"><?php echo htmlspecialchars($receiptData['created_at']); ?></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Rental Details Section -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i class="fa-solid fa-car text-blue-600"></i> Vehicle & Rental Information
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                    <span class="text-sm text-gray-600 font-medium">Selected Vehicle:</span>
                    <span class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($receiptData['vehicle_name']); ?></span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                    <span class="text-sm text-gray-600 font-medium">Driver Assignment:</span>
                    <span class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($receiptData['driver_name']); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 font-medium">Fulfillment Method:</span>
                    <span class="text-sm font-bold text-purple-600"><?php echo htmlspecialchars($receiptData['transit_method']); ?></span>
                </div>
            </div>
        </div>

        <!-- Payment Details Section -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i class="fa-solid fa-credit-card text-emerald-600"></i> Payment Information
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                    <span class="text-sm text-gray-600 font-medium">Payment Method:</span>
                    <span class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($receiptData['payment_method']); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-900">Total Amount Paid:</span>
                    <span class="text-2xl font-black text-emerald-600 font-mono">E<?php echo htmlspecialchars($receiptData['total_payment']); ?></span>
                </div>
            </div>
        </div>

        <!-- Delivery Address Section -->
        <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 flex items-center gap-2">
                <i class="fa-solid fa-map-location-dot text-red-500"></i> Delivery / Collection Address
            </h3>
            <p class="text-sm text-gray-700 leading-relaxed font-semibold">
                <?php echo htmlspecialchars($receiptData['handover_address']); ?>
            </p>
        </div>

        <!-- Terms & Conditions -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 space-y-3">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Important Notice</h3>
            <ul class="space-y-2 text-xs text-gray-600 leading-relaxed">
                <li class="flex gap-2">
                    <i class="fa-solid fa-check text-emerald-600 mt-0.5 flex-shrink-0"></i>
                    <span>Your payment has been successfully processed and authorized.</span>
                </li>
                <li class="flex gap-2">
                    <i class="fa-solid fa-check text-emerald-600 mt-0.5 flex-shrink-0"></i>
                    <span>Your vehicle booking confirmation has been recorded in our system.</span>
                </li>
                <li class="flex gap-2">
                    <i class="fa-solid fa-check text-emerald-600 mt-0.5 flex-shrink-0"></i>
                    <span>Please arrive at the specified address 15 minutes before your scheduled pickup time.</span>
                </li>
                <li class="flex gap-2">
                    <i class="fa-solid fa-check text-emerald-600 mt-0.5 flex-shrink-0"></i>
                    <span>A confirmation email with complete rental agreement terms has been sent to your registered email address.</span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons: only Print Receipt retained -->
        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
            <button type="button" onclick="window.print()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-3 px-4 rounded-xl shadow-md transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                <i class="fa-solid fa-print"></i> Print Receipt
            </button>
        </div>
    </div>
</main>

<style>
    @media print {
        /* Reset page */
        html, body {
            margin: 0;
            padding: 0;
            background: white;
            color: black;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Hide header and footer */
        nav, header, footer, .no-print {
            display: none !important;
        }

        /* Show main content area */
        main {
            display: block !important;
            width: 100%;
            margin: 0;
            padding: 20px;
            box-shadow: none;
        }

        /* Ensure receipt is visible */
        #payment-receipt {
            display: block !important;
            visibility: visible !important;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
            border: none;
            box-shadow: none;
            background: white;
            page-break-after: avoid;
        }

        /* Make all content visible */
        #payment-receipt * {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            color: #000 !important;
            background-color: transparent !important;
            border-color: #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Inline elements should stay inline */
        #payment-receipt span,
        #payment-receipt i,
        #payment-receipt a {
            display: inline !important;
        }

        /* Hide print button */
        #payment-receipt button {
            display: none !important;
        }

        /* Preserve grid layout for print */
        .grid {
            display: grid !important;
        }

        .flex {
            display: flex !important;
        }

        /* Adjust text sizing for print */
        * {
            -webkit-text-size-adjust: 100%;
        }
    }
</style>

<!-- print handled by the button's onclick (window.print()) -->

<?php
include(__DIR__ . '/layouts/footer.php');
?>
