<?php
// 1. Include your universal header layout component cleanly
include(__DIR__ . '/layouts/header.php');
?>

<!-- ==================== HERO DECORATIVE HEADER ==================== -->
<section class="bg-gradient-to-br from-gray-900 via-blue-950 to-gray-900 py-24 px-6 text-center">
    <div class="max-w-4xl mx-auto space-y-5">
        <span class="text-base font-bold uppercase tracking-widest text-blue-400 bg-blue-500/10 px-5 py-2 rounded-full border border-blue-500/20">
            24/7 Global Communications
        </span>
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tight">Connect With Our Concierge</h1>
        <p class="text-gray-200 text-lg sm:text-xl max-w-3xl mx-auto font-normal leading-relaxed">
            Have inquiries, fleet requests, or feedback? Access our multi-channel matrix below or dispatch a message straight to the Admin Feedback Panel.
        </p>
    </div>
</section>

<!-- ==================== CONTACT MATRIX CONTAINER ==================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid grid-cols-1 lg:grid-cols-12 gap-10">

    <!-- LEFT SIDE: SYSTEM NODE REGISTRY (COLS 1-5) -->
    <div class="lg:col-span-5 space-y-8">
        <div class="bg-white border border-gray-200/80 rounded-2xl p-8 md:p-10 shadow-elegant space-y-8">
            <div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Direct Communications</h3>
                <p class="text-base text-gray-600 mt-2 font-medium">Official corporate touchpoints managed by central support nodes.</p>
            </div>

            <!-- Voice Node -->
            <div class="flex items-center gap-5 p-5 rounded-xl hover:bg-gray-50 transition border border-gray-100 hover:border-gray-200 shadow-sm">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl shadow-inner shrink-0">
                    <i class="fa-solid fa-phone-volume"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Voice Lines</h4>
                    <p class="text-xl sm:text-2xl font-black text-gray-900 mt-0.5 tracking-wide">+268 2404 1234</p>
                    <p class="text-sm text-gray-500 font-semibold">Toll-free luxury inquiries line</p>
                </div>
            </div>

            <!-- Email Node -->
            <div class="flex items-center gap-5 p-5 rounded-xl hover:bg-gray-50 transition border border-gray-100 hover:border-gray-200 shadow-sm">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl shadow-inner shrink-0">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Digital Correspondence</h4>
                    <p class="text-lg sm:text-xl font-black text-gray-900 mt-0.5 tracking-wide">info@blingrental.co.sz</p>
                    <p class="text-sm text-gray-500 font-semibold">Response guaranteed under 60 minutes</p>
                </div>
            </div>

            <!-- Web Node -->
            <div class="flex items-center gap-5 p-5 rounded-xl hover:bg-gray-50 transition border border-gray-100 hover:border-gray-200 shadow-sm">
                <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-2xl shadow-inner shrink-0">
                    <i class="fa-solid fa-globe"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Official Web Portal</h4>
                    <p class="text-lg sm:text-xl font-black text-gray-900 mt-0.5 tracking-wide">www.blingrental.com</p>
                    <p class="text-sm text-gray-500 font-semibold">Secure framework checkout pipeline</p>
                </div>
            </div>
        </div>

        <!-- SOCIAL DECENTRALIZED STREAM REGISTRY -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-8 md:p-10 shadow-elegant space-y-6">
            <div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Social Network Matrix</h3>
                <p class="text-sm text-gray-600 mt-1 font-medium">Follow our dynamic luxury listings catalog pipelines.</p>
            </div>

            <div class="grid grid-cols-3 gap-5 pt-2">
                <!-- Telegram -->
                <a href="https://t.me/BlingRental" target="_blank" class="flex flex-col items-center justify-center p-5 rounded-xl bg-sky-50 border border-sky-100 group hover:bg-sky-600 transition duration-300 shadow-sm">
                    <i class="fa-brands fa-telegram text-3xl text-sky-500 group-hover:text-white transition"></i>
                    <span class="text-sm font-extrabold text-sky-800 group-hover:text-white mt-2.5 transition">Telegram</span>
                </a>
                <!-- Facebook -->
                <a href="https://facebook.com/BlingRental" target="_blank" class="flex flex-col items-center justify-center p-5 rounded-xl bg-blue-50 border border-blue-100 group hover:bg-blue-600 transition duration-300 shadow-sm">
                    <i class="fa-brands fa-facebook text-3xl text-blue-600 group-hover:text-white transition"></i>
                    <span class="text-sm font-extrabold text-blue-900 group-hover:text-white mt-2.5 transition">Facebook</span>
                </a>
                <!-- Instagram -->
                <a href="https://instagram.com/BlingRental" target="_blank" class="flex flex-col items-center justify-center p-5 rounded-xl bg-pink-50 border border-pink-100 group hover:bg-pink-600 transition duration-300 shadow-sm">
                    <i class="fa-brands fa-instagram text-3xl text-pink-600 group-hover:text-white transition"></i>
                    <span class="text-sm font-extrabold text-pink-900 group-hover:text-white mt-2.5 transition">Instagram</span>
                </a>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE: CLIENT FEEDBACK TERMINAL FOR ADMIN PANEL (COLS 6-12) -->
    <div class="lg:col-span-7">
        <div class="bg-white border border-gray-200/80 rounded-2xl p-8 md:p-10 shadow-elegant relative overflow-hidden h-full flex flex-col justify-between">

            <div class="space-y-8">
                <div>
                    <h3 class="text-3xl font-black text-gray-900 tracking-tight">Client Feedback Terminal</h3>
                    <p class="text-base text-gray-600 mt-2 font-medium">Your comments here route instantly to the **Client Feedback Tab** inside the secure Admin Dashboard.</p>
                </div>

                <!-- Live Notification UI Hook -->
                <div id="feedbackNotification" class="hidden bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-xl p-5 text-base font-bold flex items-center gap-4 animate-bounce">
                    <i class="fa-solid fa-circle-check text-2xl text-emerald-600"></i>
                    <span>String Received! Feedback successfully stacked to Admin Panel Database.</span>
                </div>

                <!-- The Interactive Feedback Form Structure -->
                <form id="feedbackForm" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-extrabold uppercase text-gray-600 mb-2 tracking-wider">Your Full Name</label>
                            <div class="relative">
                                <i class="fa-solid fa-user absolute left-4 top-4 text-gray-400 text-base"></i>
                                <input type="text" name="client_name" required placeholder="John Doe"
                                    class="w-full bg-gray-50 border border-gray-300 rounded-xl pl-12 pr-4 py-3.5 text-base font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition shadow-sm" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-extrabold uppercase text-gray-600 mb-2 tracking-wider">Email Protocol</label>
                            <div class="relative">
                                <i class="fa-solid fa-at absolute left-4 top-4 text-gray-400 text-base"></i>
                                <input type="email" name="client_email" required placeholder="email@example.com"
                                    class="w-full bg-gray-50 border border-gray-300 rounded-xl pl-12 pr-4 py-3.5 text-base font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition shadow-sm" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-extrabold uppercase text-gray-600 mb-2 tracking-wider">Commentary / Feedback String</label>
                        <div class="relative">
                            <i class="fa-solid fa-comment-dots absolute left-4 top-4 text-gray-400 text-base"></i>
                            <textarea name="client_message" required rows="6" placeholder="Share your experience or submit a public comment configuration here..."
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl pl-12 pr-4 py-3.5 text-base font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition shadow-sm"></textarea>
                        </div>
                    </div>

                    <!-- Dispatch Form Action Trigger -->
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 px-6 rounded-xl shadow-md hover:shadow-xl transition cursor-pointer text-base uppercase tracking-wider flex items-center justify-center gap-3">
                        <i class="fa-solid fa-paper-plane text-sm"></i> Dispatch Feedback to Admin Panel
                    </button>
                </form>
            </div>

            <!-- Footer Compliance Notice Trace -->
            <div class="border-t border-gray-200 pt-6 mt-10 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-500 font-semibold">
                <span><i class="fa-solid fa-server mr-2 text-gray-400"></i> Data Node: Encrypted SQL Storage</span>
                <span>Audit Tag: Bling Rentals</span>
            </div>

        </div>
    </div>

</section>

<script>
    document.getElementById('feedbackForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const clientName = document.querySelector('input[name="client_name"]').value;
        const clientEmail = document.querySelector('input[name="client_email"]').value;
        const clientMessage = document.querySelector('textarea[name="client_message"]').value;

        const formData = new FormData();
        formData.append('client_name', clientName);
        formData.append('client_email', clientEmail);
        formData.append('client_message', clientMessage);

        try {
            const response = await fetch('process_contact.php', {
                method: 'POST',
                body: formData
            });

            let result;
            const responseText = await response.text();

            try {
                result = JSON.parse(responseText);
            } catch (parseError) {
                console.error('Server response:', responseText);
                throw new Error('Invalid server response. Please contact support.');
            }

            if (result.success) {
                // Show success popup modal
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md mx-4 text-center animate-bounce">
                        <div class="mb-4 flex justify-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-check text-3xl text-green-600"></i>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Success!</h2>
                        <p class="text-gray-600 text-base mb-6">Your feedback has been successfully sent to the admin panel. Thank you for your valuable comments!</p>
                        <button onclick="this.parentElement.parentElement.remove()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-8 rounded-lg transition cursor-pointer">
                            Close
                        </button>
                    </div>
                `;
                document.body.appendChild(modal);

                // Auto-close after 5 seconds
                setTimeout(() => {
                    modal.remove();
                }, 5000);

                // Reset form
                document.getElementById('feedbackForm').reset();
            } else {
                // Show error popup modal
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md mx-4 text-center">
                        <div class="mb-4 flex justify-center">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-xmark text-3xl text-red-600"></i>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Error</h2>
                        <p class="text-gray-600 text-base mb-6">${result.message || 'Failed to submit feedback. Please try again.'}</p>
                        <button onclick="this.parentElement.parentElement.remove()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-8 rounded-lg transition cursor-pointer">
                            Close
                        </button>
                    </div>
                `;
                document.body.appendChild(modal);
            }
        } catch (error) {
            // Show error popup modal
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md mx-4 text-center">
                    <div class="mb-4 flex justify-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-exclamation text-3xl text-red-600"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Connection Error</h2>
                    <p class="text-gray-600 text-base mb-6">${error.message}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-8 rounded-lg transition cursor-pointer">
                        Close
                    </button>
                </div>
            `;
            document.body.appendChild(modal);
        }
    });
</script>

<?php
// 3. Include your universal layout footer component cleanly
include(__DIR__ . '/layouts/footer.php');
?>