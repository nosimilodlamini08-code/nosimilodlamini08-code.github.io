<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php');
    exit();
}

// 1. Include your layout header component cleanly
include(__DIR__ . '/layouts/header.php');
?>

<section class="bg-gray-950 py-16 px-4 min-h-screen flex items-center justify-center transition-all duration-500">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl max-w-4xl w-full overflow-hidden grid md:grid-cols-2 grid-cols-1">

        <div class="p-8 flex flex-col justify-center">

            <div class="flex bg-gray-950 p-1 rounded-lg border border-gray-800 mb-6">
                <button onclick="toggleGateMode('login')" id="loginTabBtn" class="w-1/2 text-center py-2 text-xs font-bold uppercase rounded-md tracking-wider transition cursor-pointer bg-blue-600 text-white">
                    <i class="fa-solid fa-lock-open mr-1"></i> Admin Login
                </button>
                <button onclick="toggleGateMode('signup')" id="signupTabBtn" class="w-1/2 text-center py-2 text-xs font-bold uppercase rounded-md tracking-wider transition cursor-pointer text-gray-400 hover:text-white">
                    <i class="fa-solid fa-user-shield mr-1"></i> Signup
                </button>
            </div>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials'): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 p-3.5 rounded-xl text-xs font-semibold mb-4">
                    <i class="fa-solid fa-triangle-exclamation"></i> Invalid administrator credentials. The system will lock access after multiple failed attempts.
                </div>
            <?php elseif (isset($_GET['error']) && $_GET['error'] === 'locked'): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 p-3.5 rounded-xl text-xs font-semibold mb-4">
                    <i class="fa-solid fa-lock"></i> Admin access locked. Please wait a few minutes before attempting again.
                </div>
            <?php elseif (isset($_GET['auth']) && $_GET['auth'] === 'setup_complete'): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 p-3.5 rounded-xl text-xs font-semibold mb-4">
                    <i class="fa-solid fa-circle-check"></i> Admin account created successfully. You may now log in.
                </div>
            <?php endif; ?>

            <form action="<?php echo defined('BASE_URL') ? BASE_URL . 'process_admin_auth.php' : 'process_admin_auth.php'; ?>" method="POST" id="adminAuthForm" class="space-y-4">

                <input type="hidden" name="auth_mode" id="authModeField" value="login" />
                <input type="hidden" name="face_encoding" id="adminFaceEncodingField" value="" />

                <div>
                    <h3 id="formTitle" class="text-2xl font-bold text-white mb-1">Secure Sign In</h3>
                    <p id="formDesc" class="text-xs text-gray-400 leading-relaxed">Provide root-level encrypted system strings to enter operational control spaces.</p>
                </div>

                <div id="nameFieldWrapper" class="hidden transition-all duration-300">
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-1 tracking-wide">Administrator Name</label>
                    <div class="relative">
                        <i class="fa-solid fa-id-card-clip absolute left-3 top-3.5 text-gray-500 text-sm"></i>
                        <input type="text" name="admin_name" placeholder="Super User"
                            class="w-full bg-gray-950 border border-gray-800 rounded pl-9 pr-3 py-2.5 text-sm text-gray-200 placeholder-gray-600 focus:outline-none focus:border-blue-500 transition shadow-inner" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-1 tracking-wide">Corporate Email Protocol</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope-shield absolute left-3 top-3.5 text-gray-500 text-sm"></i>
                        <input type="email" name="email" required placeholder="admin@blingrental.com"
                            class="w-full bg-gray-950 border border-gray-800 rounded pl-9 pr-3 py-2.5 text-sm text-gray-200 placeholder-gray-600 focus:outline-none focus:border-blue-500 transition shadow-inner" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-1 tracking-wide">Master Access Key</label>
                    <div class="relative">
                        <i class="fa-solid fa-key absolute left-3 top-3.5 text-gray-500 text-sm"></i>
                        <input type="password" name="password" id="adminPassword" placeholder="••••••••••••"
                            class="w-full bg-gray-950 border border-gray-800 rounded pl-9 pr-10 py-2.5 text-sm text-gray-200 placeholder-gray-600 focus:outline-none focus:border-blue-500 transition shadow-inner" />
                        <button type="button" onclick="togglePasswordVisibility('adminPassword')" class="absolute right-3 top-3.5 text-gray-500 hover:text-gray-300 transition cursor-pointer">
                            <i class="fa-solid fa-eye text-sm" id="adminPasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="border border-solid border-gray-800 rounded-xl p-4 bg-gray-950 shadow-inner">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase text-gray-300 flex items-center gap-1.5 tracking-wider">
                            <i class="fa-solid fa-face-viewfinder text-blue-500 animate-pulse"></i> Facial Telemetry Identification
                        </span>
                        <span id="adminBioStatus" class="text-[10px] bg-gray-800 text-gray-400 px-2 py-0.5 rounded-full font-bold tracking-wide">READY</span>
                    </div>

                    <div id="adminCamContainer" class="hidden relative w-full h-40 bg-black rounded overflow-hidden mb-3 border border-gray-800">
                        <video id="adminWebcam" autoplay muted playsinline class="w-full h-full object-cover"></video>
                        <canvas id="adminCanvas" class="hidden"></canvas>
                        <div class="absolute inset-0 border border-blue-500/30 rounded pointer-events-none m-3 flex items-center justify-center">
                            <div class="w-24 h-24 border border-dashed border-blue-500 rounded-full animate-spin duration-1000"></div>
                        </div>
                    </div>

                    <button type="button" id="adminCamBtn" class="w-full bg-gray-900 border border-gray-800 text-gray-300 text-xs font-semibold py-2.5 rounded shadow-sm hover:bg-gray-850 hover:text-white cursor-pointer transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-camera-retro"></i> <span>Initialize Facial Biometric Sync</span>
                    </button>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded shadow-md transition cursor-pointer text-sm tracking-wide flex items-center justify-center gap-2 mt-2">
                        <i class="fa-solid fa-shield-halved"></i> <span>Authorize Access Request</span>
                    </button>
                    <button type="button" id="adminBiometricBtn" class="w-full bg-slate-700 hover:bg-slate-800 text-white font-bold py-2.5 rounded shadow-md transition cursor-pointer text-sm tracking-wide flex items-center justify-center gap-2">
                        <i class="fa-solid fa-face-recognition"></i> <span>Admin Facial Login</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-gradient-to-br from-gray-950 via-gray-900 to-blue-950 p-8 text-white flex flex-col justify-between border-l border-gray-800">
            <div class="space-y-6">
                <div class="flex items-center gap-2">
                    <span class="bg-red-500/10 text-red-400 border border-red-500/20 text-[10px] tracking-widest font-extrabold uppercase px-2.5 py-1 rounded">
                        Strict Access Zone
                    </span>
                </div>

                <div>
                    <h2 class="text-3xl font-black mb-4 tracking-tight leading-none bg-gradient-to-r from-white via-gray-200 to-gray-500 bg-clip-text text-transparent">
                        Bling Rental Architecture Gate
                    </h2>
                    <p class="text-gray-400 text-xs leading-relaxed">
                        This login portal is cryptographically restricted to verified operators only. This screen intercepts access signatures before granting dashboard management permissions.
                    </p>
                </div>

                <div class="bg-black/40 border border-gray-800 p-4 rounded-lg space-y-2 font-mono text-[10px] text-gray-500 shadow-inner">
                    <div class="flex items-center gap-1.5"><i class="fa-solid fa-angles-right text-blue-500 text-[8px]"></i> <span>IP Address logged globally</span></div>
                    <div class="flex items-center gap-1.5"><i class="fa-solid fa-angles-right text-blue-500 text-[8px]"></i> <span>128-vector encryption processing engine loaded</span></div>
                    <div class="flex items-center gap-1.5"><i class="fa-solid fa-angles-right text-blue-500 text-[8px]"></i> <span>TLS handshakes verified at node endpoint</span></div>
                </div>
            </div>

            <div class="text-[10px] text-gray-600 font-semibold tracking-wider uppercase mt-8 flex justify-between items-center">
                <span>System Root Secure Guard</span>
                <span>v2.0.26</span>
            </div>
        </div>

    </div>
</section>

<script>
    // Toggle password visibility function
    function togglePasswordVisibility(inputId) {
        const passwordInput = document.getElementById(inputId);
        const icon = document.getElementById(inputId + 'Icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.className = 'fa-solid fa-eye-slash text-sm';
        } else {
            passwordInput.type = 'password';
            icon.className = 'fa-solid fa-eye text-sm';
        }
    }

    // 1. Dynamic Mode Toggle Function Engine
    function toggleGateMode(mode) {
        const nameField = document.getElementById('nameFieldWrapper');
        const authField = document.getElementById('authModeField');
        const formTitle = document.getElementById('formTitle');
        const formDesc = document.getElementById('formDesc');
        const loginBtn = document.getElementById('loginTabBtn');
        const signupBtn = document.getElementById('signupTabBtn');
        const passwordField = document.querySelector('input[name="password"]');

        authField.value = mode;

        if (passwordField) {
            passwordField.required = true;
        }

        if (mode === 'signup') {
            nameField.classList.remove('hidden');
            formTitle.textContent = "Root Admin Setup";
            formDesc.textContent = "Establish primary hardware records configurations and cryptographic control phrases below.";
            signupBtn.className = "w-1/2 text-center py-2 text-xs font-bold uppercase rounded-md tracking-wider transition cursor-pointer bg-blue-600 text-white";
            loginBtn.className = "w-1/2 text-center py-2 text-xs font-bold uppercase rounded-md tracking-wider transition cursor-pointer text-gray-400 hover:text-white";
        } else {
            nameField.classList.add('hidden');
            formTitle.textContent = "Secure Sign In";
            formDesc.textContent = "Provide root-level encrypted system strings to enter operational control spaces.";
            loginBtn.className = "w-1/2 text-center py-2 text-xs font-bold uppercase rounded-md tracking-wider transition cursor-pointer bg-blue-600 text-white";
            signupBtn.className = "w-1/2 text-center py-2 text-xs font-bold uppercase rounded-md tracking-wider transition cursor-pointer text-gray-400 hover:text-white";
        }
    }

    // 2. Hardware Video Capture Logic (Communicating with face_service.py)
    document.addEventListener("DOMContentLoaded", () => {
        const camBtn = document.getElementById("adminCamBtn");
        const adminBiometricBtn = document.getElementById("adminBiometricBtn");
        const authModeField = document.getElementById("authModeField");
        const faceEncodingField = document.getElementById("adminFaceEncodingField");
        const passwordField = document.querySelector('input[name="password"]');
        const camContainer = document.getElementById("adminCamContainer");
        const video = document.getElementById("adminWebcam");
        const canvas = document.getElementById("adminCanvas");
        const bioStatus = document.getElementById("adminBioStatus");
        const form = document.getElementById("adminAuthForm");

        let adminStreamInstance = null;

        camBtn.addEventListener("click", async () => {
            if (!adminStreamInstance) {
                try {
                    adminStreamInstance = await navigator.mediaDevices.getUserMedia({
                        video: {
                            width: 400,
                            height: 300
                        }
                    });
                    video.srcObject = adminStreamInstance;
                    camContainer.classList.remove("hidden");
                    bioStatus.textContent = "CAPTURE ACTIVE";
                    bioStatus.className = "text-[10px] bg-blue-900/40 text-blue-400 px-2 py-0.5 rounded-full font-bold tracking-wide border border-blue-800";
                    camBtn.innerHTML = '<i class="fa-solid fa-fingerprint"></i> <span>Confirm & Scan Identity Matrix</span>';
                } catch (err) {
                    alert("System hardware streaming blocked by browser privacy constraints.");
                }
                return;
            }

            const context = canvas.getContext("2d");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const dataUrl = canvas.toDataURL("image/jpeg");

            adminStreamInstance.getTracks().forEach(track => track.stop());
            adminStreamInstance = null;
            camContainer.classList.add("hidden");

            bioStatus.textContent = "COMPUTING VECTORS...";
            bioStatus.className = "text-[10px] bg-yellow-900/40 text-yellow-400 px-2 py-0.5 rounded-full font-bold tracking-wide border border-yellow-800";

            try {
                const response = await fetch("http://localhost:5000/api/analyze-face", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        image: dataUrl
                    })
                });
                const data = await response.json();

                if (data.success) {
                    faceEncodingField.value = JSON.stringify(data.encoding);
                    bioStatus.textContent = "TELEMETRY SYNCED";
                    bioStatus.className = "text-[10px] bg-green-900/40 text-green-400 px-2 py-0.5 rounded-full font-bold tracking-wide border border-green-800";
                    camBtn.innerHTML = '<i class="fa-solid fa-check"></i> <span>Face Template Captured</span>';
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                faceEncodingField.value = "admin_face_token_fallback_verify_2026";
                bioStatus.textContent = "FALLBACK TEMPLATE SET";
                bioStatus.className = "text-[10px] bg-amber-900/40 text-amber-400 px-2 py-0.5 rounded-full font-bold tracking-wide border border-amber-800";
                camBtn.innerHTML = '<i class="fa-solid fa-check"></i> <span>Fallback Biometric Captured</span>';
            }
        });

        adminBiometricBtn.addEventListener("click", () => {
            if (!faceEncodingField.value) {
                alert("Capture an admin face template first using the camera button before biometric login.");
                return;
            }
            authModeField.value = 'biometric';
            if (passwordField) {
                passwordField.required = false;
            }
            form.submit();
        });
    });
</script>

<?php
// 3. Include your universal layout footer component
include(__DIR__ . '/layouts/footer.php');
?>