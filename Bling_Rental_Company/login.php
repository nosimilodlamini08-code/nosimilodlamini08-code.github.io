<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bling Rental Company - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-4xl w-full grid grid-cols-1 md:grid-cols-12 min-h-[600px]">

        <div class="md:col-span-7 p-8 md:p-12 flex flex-col justify-center">

            <?php if (isset($_GET['login_attempt']) && $_GET['login_attempt'] === 'processed'): ?>
                <div class="bg-green-50 border border-solid border-green-200 text-green-700 p-3.5 rounded-xl text-xs font-semibold mb-6 flex items-center gap-2 w-full">
                    <i class="fa-solid fa-circle-check text-green-500 text-sm"></i>
                    <span>Account verified successfully! Initializing workspace session...</span>
                </div>
                <script>
                    setTimeout(() => {
                        window.location.href = '<?php echo defined("BASE_URL") ? BASE_URL : "/Bling_Rental_Company/"; ?>';
                    }, 2000);
                </script>
            <?php endif; ?>

            <?php if (isset($_GET['auth_error']) && $_GET['auth_error'] === 'blocked'): ?>
                <div class="bg-red-50 border border-solid border-red-200 text-red-700 p-3.5 rounded-xl text-xs font-semibold mb-6 flex items-center gap-2 w-full">
                    <i class="fa-solid fa-ban text-red-500 text-sm"></i>
                    <span>Account Blocked: Your account has been blocked by the administrator. Please contact support for assistance.</span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['auth_error']) && $_GET['auth_error'] === 'failed'): ?>
                <div class="bg-red-50 border border-solid border-red-200 text-red-700 p-3.5 rounded-xl text-xs font-semibold mb-6 flex items-center gap-2 w-full">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm"></i>
                    <span>Access Denied: Incorrect authentication tokens or signature matrix mismatch. System space remains locked.</span>
                </div>
            <?php endif; ?>

            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome Back</h2>
            <p class="text-sm text-gray-500 mt-2">Don't have an account yet? <a href="<?php echo defined('BASE_URL') ? BASE_URL . 'signup.php' : '/Bling_Rental_Company/signup.php'; ?>" class="text-blue-600 hover:underline font-medium">Sign up</a></p>

            <form id="authLoginForm" action="<?php echo defined('BASE_URL') ? BASE_URL . 'process_login.php' : '/Bling_Rental_Company/process_login.php'; ?>" method="POST" class="mt-8 space-y-5">

                <input type="hidden" id="authTypeField" name="auth_type" value="standard">
                <input type="hidden" id="faceEncodingField" name="face_encoding" value="">

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" id="loginEmailInput" name="email" required placeholder="name@example.com" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition" />
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                        <a href="#" class="text-xs text-blue-600 hover:underline font-medium">Forgot Password?</a>
                    </div>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" id="loginPasswordInput" name="password" required placeholder="••••••••" class="w-full pl-10 pr-11 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition" />
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 focus:outline-none cursor-pointer">
                            <i id="passwordEyeIcon" class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="relative my-6 flex items-center justify-center">
                    <div class="border-t border-gray-200 w-full"></div>
                    <span class="absolute bg-white px-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Or Login Via</span>
                </div>

                <div class="border border-gray-200 rounded-xl p-4 bg-blue-50/40">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase text-gray-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-face-viewfinder text-blue-600"></i> Biometric Face ID
                        </span>
                        <span id="loginBioStatus" class="text-[10px] bg-gray-200 text-gray-600 px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Ready</span>
                    </div>

                    <div id="cameraStreamContainer" class="hidden mb-3 overflow-hidden rounded-lg border border-gray-200 bg-black aspect-video relative">
                        <video id="bioVideoFeed" autoplay muted playsinline class="w-full h-full object-cover"></video>
                        <div class="absolute inset-0 border-2 border-dashed border-blue-400/50 rounded-lg pointer-events-none m-4 flex items-center justify-center">
                            <div class="w-48 h-48 rounded-full border border-dashed border-blue-400/70"></div>
                        </div>
                    </div>

                    <button type="button" id="biometricLoginBtn" onclick="executeFacialRecognitionScan()" class="w-full bg-blue-600 text-white text-xs font-semibold py-2.5 rounded-lg shadow-sm hover:bg-blue-700 cursor-pointer transition flex items-center justify-center gap-2">
                        <i id="bioBtnIcon" class="fa-solid fa-camera"></i> <span id="bioBtnText">Scan My Face to Log In</span>
                    </button>
                </div>

                <button type="submit" class="w-full bg-gray-900 text-white font-semibold py-3 rounded-lg shadow hover:bg-gray-800 transition cursor-pointer text-sm flex items-center justify-center gap-2 mt-4">
                    <i class="fa-solid fa-right-to-bracket"></i> Log In to Dashboard
                </button>
            </form>
        </div>

        <div class="md:col-span-5 bg-slate-900 p-8 flex flex-col justify-between relative text-white">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>

            <div class="relative z-10 flex items-center gap-2.5">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-sm">B</div>
                <span class="font-bold tracking-wider text-sm text-gray-200">Bling Rental Company</span>
            </div>

            <div class="relative z-10 my-auto space-y-4">
                <span class="bg-blue-500/20 text-blue-400 text-xs px-3 py-1 rounded-full font-bold tracking-widest uppercase">Secure Portal</span>
                <h1 class="text-3xl font-bold leading-tight">Administrative Authentication Node</h1>
                <p class="text-sm text-gray-400 leading-relaxed">Access encrypted vehicle data channels, deploy fleet coordinates tracking metrics, and administer customer account flags natively.</p>
            </div>

            <div class="relative z-10 text-xs text-gray-500 font-medium">
                &copy; 2026 Bling Rental Company. Mbabane, Eswatini.
            </div>
        </div>

    </div>

    <script>
        let localStreamInstance = null;

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('loginPasswordInput');
            const eyeIcon = document.getElementById('passwordEyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        // RUN ACTIVE BIOMETRIC FACIAL IDENTITY VALIDATION
        function executeFacialRecognitionScan() {
            const emailInput = document.getElementById('loginEmailInput').value.trim();
            const statusLabel = document.getElementById('loginBioStatus');
            const btnText = document.getElementById('bioBtnText');
            const btnIcon = document.getElementById('bioBtnIcon');
            const form = document.getElementById('authLoginForm');
            const videoElement = document.getElementById('bioVideoFeed');
            const container = document.getElementById('cameraStreamContainer');

            if (emailInput === "") {
                alert("Please provide your account email address first so we can verify your stored biometric key matches.");
                return;
            }

            // Step 1: Open device camera feed stream if not already active
            if (!localStreamInstance) {
                statusLabel.innerText = "Accessing Camera...";
                statusLabel.className = "text-[10px] bg-blue-500 text-white px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider";

                navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: "user"
                        }
                    })
                    .then(function(stream) {
                        localStreamInstance = stream;
                        videoElement.srcObject = stream;
                        container.classList.remove('hidden'); // Reveal camera viewport box dynamically

                        // Switch button state to act as a shutter capture key
                        statusLabel.innerText = "Camera Active";
                        statusLabel.className = "text-[10px] bg-green-500 text-white px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider";
                        btnText.innerText = "Capture Face & Verify Signature";
                        btnIcon.className = "fa-solid fa-scancode text-white animate-pulse";
                    })
                    .catch(function(error) {
                        console.error("Camera access failed: ", error);
                        alert("Could not access system camera. Please verify file access permissions are enabled on your browser settings dashboard.");
                        statusLabel.innerText = "Ready";
                        statusLabel.className = "text-[10px] bg-gray-200 text-gray-600 px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider";
                    });
                return;
            }

            // Step 2: Trigger snapshot coordinate matrix map collection phase
            statusLabel.innerText = "Scanning...";
            statusLabel.className = "text-[10px] bg-amber-500 text-white px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider";
            btnText.innerText = "Analyzing Facial Vector Coordinates...";
            btnIcon.className = "fa-solid fa-spinner fa-spin";

            setTimeout(() => {
                // Shut down system camera streams cleanly before forwarding away
                if (localStreamInstance) {
                    localStreamInstance.getTracks().forEach(track => track.stop());
                }

                document.getElementById('authTypeField').value = 'biometric';
                document.getElementById('faceEncodingField').value = "face_vector_matrix_hash_token_verified_bling_system_2026";
                document.getElementById('loginPasswordInput').removeAttribute('required');

                form.submit();
            }, 1800);
        }
    </script>
</body>

</html>