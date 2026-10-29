</main>

<!-- ==================== FOOTER SECTION ==================== -->
<footer class="bg-gray-900 text-gray-300 py-16 px-4 sm:px-6 lg:px-20 reveal-y">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">
        <!-- Company Info -->
        <div>
            <a href="index.php" class="flex items-center space-x-2 text-white">
                <i class="fa-solid fa-car text-blue-500 text-2xl h-8 w-8 flex items-center"></i>
                <span class="text-xl font-bold">Bling Rental Company</span>
            </a>
            <p class="leading-relaxed my-4">
                Your trusted partner for premium car rentals. Experience the freedom of the road with our quality vehicles and exceptional service.
            </p>
            <div class="flex gap-4 mt-2">
                <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-facebook text-xl"></i></a>
                <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-twitter text-xl"></i></a>
                <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-instagram text-xl"></i></a>
            </div>
        </div>

        <!-- Quick Links -->
        <div>
            <h4 class="text-white font-semibold mb-4">Quick Links</h4>
            <ul class="space-y-2">
                <li><a href="index.php" class="hover:underline">Home</a></li>
                <li><a href="booking.php" class="hover:underline">Rent a Car</a></li>
                <li><a href="Features.php" class="hover:underline">About Us</a></li>
                <li><a href="contact.php" class="hover:underline">Contact Us</a></li>
                <li><a href="terms.php" class="hover:underline">Terms & Conditions</a></li>
            </ul>
        </div>

        <!-- Services -->
        <div>
            <h4 class="text-white font-semibold mb-4">Services</h4>
            <ul class="space-y-2">
                <li>Economy Cars</li>
                <li>Luxury Vehicles</li>
                <li>SUVs & Trucks</li>
                <li>Electric Cars</li>
                <li>Long-term Rentals</li>
            </ul>
        </div>

        <!-- Contact -->
        <div>
            <h4 class="text-white font-semibold mb-4">Contact Us</h4>
            <ul class="space-y-3">
                <li class="flex items-center gap-2">
                    <i class="fa-solid fa-phone text-blue-400 w-5"></i> +268 2404 1234
                </li>
                <li class="flex items-center gap-2">
                    <i class="fa-solid fa-envelope text-blue-400 w-5"></i> info@blingrental.co.sz
                </li>
                <li class="flex items-center gap-2">
                    <i class="fa-solid fa-map-pin text-blue-400 w-5"></i> Mbabane, Hhohho, Eswatini
                </li>
            </ul>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-700 mt-10 pt-6 text-sm flex flex-col sm:flex-row justify-between items-center text-gray-500">
        <p>&copy; <?php echo date("Y"); ?> Bling Rental Company. All rights reserved.</p>
        <div class="flex gap-4 mt-4 sm:mt-0">
            <a href="#" class="hover:underline">Privacy Policy</a>
            <a href="#" class="hover:underline">Terms of Service</a>
        </div>
    </div>
</footer>

<!-- ==================== CLIENT INTERACTION SCRIPTS ==================== -->
<script>
    // Responsive Navbar Toggle Engine
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');

    if (menuBtn && mobileMenu && menuIcon) {
        menuBtn.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            if (isOpen) {
                mobileMenu.classList.add('hidden');
                menuIcon.className = "fa-solid fa-bars text-xl";
            } else {
                mobileMenu.classList.remove('hidden');
                menuIcon.className = "fa-solid fa-xmark text-xl";
            }
        });
    }

    // ScrollReveal Animation Setup
    ScrollReveal().reveal('.hero-reveal', {
        distance: '50px',
        duration: 1000,
        easing: 'ease-in-out',
        origin: 'left',
        reset: false
    });

    ScrollReveal().reveal(".head-reveal", {
        scale: 0.85,
        distance: "0px",
        duration: 1500,
        easing: "ease-in-out",
        reset: false
    });

    ScrollReveal().reveal(".reveal-y", {
        origin: "bottom",
        distance: "100px",
        duration: 1500,
        interval: 200,
        easing: "ease-in-out",
        reset: false
    });
</script>
</body>

</html>