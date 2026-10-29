<?php
// 1. Initialize or resume the current session tracking profile
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Homepage is public; user-specific features will appear after sign-in via the header session checks

// ... Rest of your existing index.php code follows below ...
?>
<?php
// 1. Include your header from the new layouts folder
include(__DIR__ . '/layouts/header.php');

// 2. Fetch data from your backend.
$apiUrl = 'http://localhost:8080/api/cars/featured'; // Example Java Spring Boot endpoint
$carJson = @file_get_contents($apiUrl);

if ($carJson !== false) {
    $cars = json_decode($carJson, true);
} else {
    // Fallback data structure if backend services are offline during initial development
    $cars = [
        [
            'id' => 1,
            'name' => 'Tesla Model 3',
            'year' => 2023,
            'location' => 'Mbabane',
            'seats' => 5,
            'transmission' => 'Automatic',
            'fuel' => 'Electric',
            'price' => 1420,
            'rating' => 4.8,
            'badges' => ['Autopilot', 'Premium Audio', '+2 more'],
            'type' => 'Electric',
            'status' => 'Available',
            'image' => 'includes/tesla.jpg',
        ],
        [
            'id' => 2,
            'name' => 'BMW X5',
            'year' => 2023,
            'location' => 'Manzini',
            'seats' => 7,
            'transmission' => 'Automatic',
            'fuel' => 'Gasoline',
            'price' => 1499,
            'rating' => 4.7,
            'badges' => ['Leather Seats', 'Navigation', '+2 more'],
            'type' => 'Luxury SUV',
            'status' => 'Available',
            'image' => 'includes/bmw.jpg',
        ],
        [
            'id' => 3,
            'name' => 'Audi A4',
            'year' => 2023,
            'location' => 'Lobamba',
            'seats' => 5,
            'transmission' => 'Automatic',
            'fuel' => 'Gasoline',
            'price' => 2000,
            'rating' => 4.6,
            'badges' => ['Virtual Cockpit', 'Heated Seats', '+2 more'],
            'type' => 'Sedan',
            'status' => 'Available',
            'image' => 'includes/audi.jpg',
        ],
        [
            'id' => 4,
            'name' => 'Toyota Auris',
            'year' => 2022,
            'location' => 'Siteki',
            'seats' => 5,
            'transmission' => 'Automatic',
            'fuel' => 'Petrol',
            'price' => 949,
            'rating' => 4.4,
            'badges' => ['Reliable', 'Fuel Efficient', '+1 more'],
            'type' => 'Sedan',
            'status' => 'Available',
            'image' => 'includes/toyota.jpg',
        ],
        [
            'id' => 5,
            'name' => 'Ford Explorer',
            'year' => 2021,
            'location' => 'Piggs Peak',
            'seats' => 7,
            'transmission' => 'Automatic',
            'fuel' => 'Petrol',
            'price' => 1690,
            'rating' => 4.5,
            'badges' => ['Spacious', 'All-wheel drive'],
            'type' => 'SUV',
            'status' => 'Available',
            'image' => 'includes/ford.jpg',
        ],
        [
            'id' => 6,
            'name' => 'Kia Sportage',
            'year' => 2022,
            'location' => 'Nhlangano',
            'seats' => 5,
            'transmission' => 'Automatic',
            'fuel' => 'Hybrid',
            'price' => 1365,
            'rating' => 4.3,
            'badges' => ['Hybrid', 'Modern Interior'],
            'type' => 'Crossover',
            'status' => 'Available',
            'image' => 'includes/kia.jpg',
        ]
    ];
}
?>

<!-- ==================== HERO SECTION ==================== -->
<section class="bg-gradient-to-br from-blue-500 to-blue-700 text-white sm:py-28 py-16 px-4 text-center">
    <h1 class="text-4xl sm:text-5xl font-bold mb-4 hero-reveal">
        Find Your Perfect <span class="text-yellow-400">Rental Car</span>
    </h1>
    <p class="text-lg sm:text-xl mb-12 text-gray-200 hero-reveal max-w-2xl mx-auto">
        Discover amazing deals on quality vehicles. Book now and drive away with confidence.
    </p>

    <!-- Booking Form Panel -->
    <form action="process_search.php" method="GET" class="bg-white rounded-xl shadow-lg p-4 sm:p-6 max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-5 gap-4 items-end text-black text-left hero-reveal">
        <div>
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                <i class="fa-solid fa-map-pin text-blue-500 text-base"></i> <span>Pickup Location</span>
            </label>
            <select name="location" class="w-full p-2.5 border border-gray-300 rounded text-sm text-gray-700 bg-white cursor-pointer focus:border-blue-500 focus:outline-none">
                <option value="">Select city</option>
                <option value="Mbabane">Mbabane</option>
                <option value="Manzini">Manzini</option>
                <option value="Lobamba">Lobamba</option>
                <option value="Siteki">Siteki</option>
                <option value="Mahhala">Mahhala</option>
                <option value="Nhlangano">Nhlangano</option>
                <option value="Simunye">Simunye</option>
                <option value="BigBend">BigBend</option>
                <option value="Piggs Peak">Piggs Peak</option>

            </select>
        </div>

        <div>
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                <i class="fa-regular fa-calendar-days text-blue-500 text-base"></i> <span>Pickup Date</span>
            </label>
            <input type="date" name="pickup_date" class="w-full p-2 border border-gray-300 rounded text-sm text-gray-700 cursor-pointer focus:border-blue-500 focus:outline-none" />
        </div>

        <div>
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                <i class="fa-regular fa-clock text-blue-500 text-base"></i> <span>Pickup Time</span>
            </label>
            <input type='time' name="pickup_time" class="w-full p-2 border border-gray-300 rounded text-sm text-gray-700 cursor-pointer focus:border-blue-500 focus:outline-none" />
        </div>

        <div>
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                <i class="fa-regular fa-calendar-days text-blue-500 text-base"></i> <span>Return Date</span>
            </label>
            <input type="date" name="return_date" class="w-full p-2 border border-gray-300 rounded text-sm text-gray-700 cursor-pointer focus:border-blue-500 focus:outline-none" />
        </div>

        <div>
            <a href="booking.php" class="block w-full">
                <button type="button" class="flex items-center justify-center gap-2 w-full cursor-pointer bg-blue-500 text-white font-medium p-2.5 rounded hover:bg-blue-700 transition duration-300 shadow-sm">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i> <span>Search Cars</span>
                </button>
            </a>
        </div>
    </form>

    <div class="mt-16 max-w-4xl mx-auto grid grid-cols-2 sm:grid-cols-4 gap-8 text-white hero-reveal">
        <div>
            <h2 class="sm:text-4xl text-3xl font-bold" data-target="500" data-suffix="+">0</h2>
            <p class="sm:text-lg text-gray-200">Premium Cars</p>
        </div>
        <div>
            <h2 class="sm:text-4xl text-3xl font-bold" data-target="50" data-suffix="+">0</h2>
            <p class="sm:text-lg text-gray-200">Locations</p>
        </div>
        <div>
            <h2 class="sm:text-4xl text-3xl font-bold" data-target="24" data-suffix="/7">0</h2>
            <p class="sm:text-lg text-gray-200">Support</p>
        </div>
        <div>
            <h2 class="sm:text-4xl text-3xl font-bold" data-target="99" data-suffix="%">0</h2>
            <p class="sm:text-lg text-gray-200">Satisfaction</p>
        </div>
    </div>

    <script>
        const counters = document.querySelectorAll('[data-target]');

        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const suffix = counter.getAttribute('data-suffix') || '';
                const count = +counter.innerText;
                const increment = target / 200;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(updateCount, 10);
                } else {
                    // Apply the suffix (e.g., +, %, or /7) based on the data-suffix attribute
                    counter.innerText = target + suffix;
                }
            };
            updateCount();
        });
    </script>
    </div>
</section>

<!-- ==================== FEATURED CARS SECTION ==================== -->
<section class="bg-gray-100 py-20 sm:px-16 px-4">
    <div class="max-w-7xl mx-auto text-center mb-12 head-reveal">
        <h2 class="sm:text-4xl text-3xl font-bold mb-2 flex justify-center items-center gap-2">
            <span class="text-blue-500"><i class="fa-solid fa-car text-3xl sm:text-4xl"></i></span>
            <span class='text-gray-800'>Featured Cars</span>
        </h2>
        <p class="text-gray-600 text-lg">Discover our handpicked selection of premium vehicles, perfect for any journey</p>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 max-w-7xl mx-auto">
        <?php foreach ($cars as $car): ?>
            <div class="bg-white rounded-xl p-4 shadow-md hover:shadow-lg transition duration-300 hover:-translate-y-3 reveal-y">
                <div class="relative overflow-hidden rounded-md">
                    <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>" class="rounded-md w-full h-48 sm:h-56 md:h-60 object-cover" />
                    <span class="absolute top-2 left-2 bg-white text-xs font-semibold px-2 py-1 rounded-full shadow"><?php echo htmlspecialchars($car['type']); ?></span>
                    <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full"><?php echo htmlspecialchars($car['status']); ?></span>
                </div>

                <div class="mt-4">
                    <div class='flex justify-between items-center'>
                        <h3 class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($car['name']); ?></h3>
                        <div class="text-yellow-500 text-sm flex items-center gap-1">
                            <i class="fa-solid fa-star"></i><?php echo htmlspecialchars($car['rating']); ?>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($car['year']); ?></p>

                    <div class="flex items-center text-sm text-gray-500 my-4 gap-1">
                        <i class="fa-solid fa-map-pin text-sm text-gray-400"></i><span><?php echo htmlspecialchars($car['location']); ?></span>
                    </div>

                    <div class="flex sm:items-center sm:flex-row flex-col sm:gap-6 gap-2 mt-2 text-gray-600 text-sm">
                        <span class='inline-flex items-center gap-1'><i class="fa-solid fa-users text-blue-500"></i> <?php echo htmlspecialchars($car['seats']); ?> seats</span>
                        <span class='inline-flex items-center gap-1'><i class="fa-solid fa-gear text-blue-500"></i> <?php echo htmlspecialchars($car['transmission']); ?></span>
                        <span class='inline-flex items-center gap-1'><i class="fa-solid fa-gas-pump text-blue-500"></i> <?php echo htmlspecialchars($car['fuel']); ?></span>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-3">
                        <?php foreach ($car['badges'] as $badge): ?>
                            <span class="bg-gray-50 text-xs px-2 py-1 rounded-full font-semibold border border-gray-200 text-gray-600"><?php echo htmlspecialchars($badge); ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-4">
                        <p class="text-lg font-bold text-blue-500">E<?php echo htmlspecialchars($car['price']); ?><span class="text-sm font-normal text-gray-500">/day</span></p>
                    </div>


                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="booking.php" class='mx-auto max-w-xs flex items-center justify-center mt-12 bg-blue-500 py-3 px-5 text-white rounded font-medium gap-2 transition duration-300 hover:bg-blue-700'>
        View All Cars <i class="fa-solid fa-arrow-right"></i>
    </a>
</section>

<!-- ==================== WHY CHOOSE US (FEATURES) SECTION ==================== -->
<section class="py-16 bg-gray-50 px-4 sm:px-6 lg:px-28">
    <div class="max-w-7xl mx-auto text-center">
        <h2 class="sm:text-4xl text-3xl font-bold text-gray-800 mb-4 head-reveal">Why Choose Bling Rental Company?</h2>
        <p class="text-gray-600 mb-12 max-w-2xl mx-auto text-lg head-reveal">
            We're committed to providing you with the best car rental experience through our premium services and customer-first approach.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="flex flex-col bg-white items-center text-center border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transform hover:-translate-y-2 transition duration-300 reveal-y">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-500 mb-4 text-white text-xl shadow-sm">
                    <i class="fa-solid fa-shield-halved text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Fully Insured</h3>
                <p class="text-sm text-gray-600 leading-relaxed">All our vehicles come with comprehensive insurance coverage for your peace of mind.</p>
            </div>

            <div class="flex flex-col bg-white items-center text-center border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transform hover:-translate-y-2 transition duration-300 reveal-y">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-500 mb-4 text-white text-xl shadow-sm">
                    <i class="fa-regular fa-clock text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">24/7 Service</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Round-the-clock customer support and roadside assistance whenever you need it.</p>
            </div>

            <div class="flex flex-col bg-white items-center text-center border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transform hover:-translate-y-2 transition duration-300 reveal-y">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-500 mb-4 text-white text-xl shadow-sm">
                    <i class="fa-regular fa-credit-card text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Easy Payment</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Secure online payments with multiple payment options and instant confirmation.</p>
            </div>

            <div class="flex flex-col bg-white items-center text-center border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transform hover:-translate-y-2 transition duration-300 reveal-y">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-500 mb-4 text-white text-xl shadow-sm">
                    <i class="fa-solid fa-map-location-dot text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Multiple Locations</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Pick up and drop off at any of our 50+ convenient locations across the country.</p>
            </div>
        </div>
    </div>
</section>

<?php
// 3. Include your footer from the new layouts folder
include(__DIR__ . '/layouts/footer.php');
?>