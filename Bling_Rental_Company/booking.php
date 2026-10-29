<?php
// booking.php
require_once 'config.php';
include(__DIR__ . '/layouts/header.php');

// Fetch chauffeur drivers from staff table
$drivers = [];
$driverQuery = "SELECT id, full_name, email, license_number, role, rating, reviews_count, age, gender, created_at FROM staff WHERE role = 'Chauffeur Driver' ORDER BY created_at DESC";
$driverResult = @$conn->query($driverQuery);
if ($driverResult && $driverResult->num_rows > 0) {
    while ($driver = $driverResult->fetch_assoc()) {
        $drivers[] = $driver;
    }
}
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="max-w-xl mx-auto mb-12 flex items-center justify-center relative">
        <div class="flex flex-col items-center relative z-10">
            <div id="step1-badge" class="rounded-full h-10 w-10 flex items-center justify-center bg-blue-600 text-white font-bold text-sm shadow-lg shadow-blue-500/30 transition-all duration-300">1</div>
            <span id="step1-label" class="absolute top-12 text-center text-[10px] font-extrabold text-blue-600 uppercase tracking-wider w-24">Select Fleet</span>
        </div>

        <div class="flex-auto h-[2px] bg-gray-200 mx-2 relative -top-3">
            <div id="step-progress-line" class="h-full bg-blue-600 w-0 transition-all duration-500"></div>
        </div>

        <div class="flex flex-col items-center relative z-10">
            <div id="step2-badge" class="rounded-full h-10 w-10 flex items-center justify-center bg-white border-2 border-gray-300 text-gray-400 font-bold text-sm transition-all duration-300">2</div>
            <span id="step2-label" class="absolute top-12 text-center text-[10px] font-extrabold text-gray-400 uppercase tracking-wider w-24">Secure Payment</span>
        </div>
    </div>

    <div id="fleet-screen" class="space-y-12 transition-all duration-300">

        <div class="text-center max-w-2xl mx-auto mt-6">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Find Your Perfect Elite Fleet Match</h1>
            <p class="mt-3 text-sm text-gray-500">Premium choices organized by luxury brand categories. Includes fully certified personal chauffeur coverage options.</p>
        </div>

        <div class="space-y-6">
            <div class="border-b border-gray-200 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-couch text-xl text-blue-600"></i>
                <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Executive Luxury Sedans</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1617814076367-b759c7d7e738?w=600&auto=format&fit=crop&q=80" alt="Mercedes S-Class" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Mercedes-Benz</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">S-Class S500 Executive</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-gas-pump text-blue-500 mr-1"></i> Hybrid Petrol</span>
                                <span><i class="fa-solid fa-gears text-blue-500 mr-1"></i> Automatic</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E2,500 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Mercedes S-Class S500', 'E2,500')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?w=600&auto=format&fit=crop&q=80" alt="BMW 7 Series" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">BMW</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">7 Series M760e iPerformance</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-gas-pump text-blue-500 mr-1"></i> Plug-in Hybrid</span>
                                <span><i class="fa-solid fa-gears text-blue-500 mr-1"></i> Automatic</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E2,400 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('BMW 7 Series M760e', 'E2,400')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1606577924006-27d39b132c29?w=600&auto=format&fit=crop&q=80" alt="Audi A8" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Audi</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Audi A8 L Horch Edition</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-gas-pump text-blue-500 mr-1"></i> Twin Turbo V6</span>
                                <span><i class="fa-solid fa-gears text-blue-500 mr-1"></i> Quattro Auto</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E2,200 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Audi A8 L Horch', 'E2,200')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=600&auto=format&fit=crop&q=80" alt="Porsche Panamera" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Porsche</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Panamera 4S E-Hybrid</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-gas-pump text-blue-500 mr-1"></i> Twin Turbo V6</span>
                                <span><i class="fa-solid fa-gears text-blue-500 mr-1"></i> 8-Speed PDK</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E2,900 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Porsche Panamera 4S', 'E2,900')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1563720223185-11003d516935?w=600&auto=format&fit=crop&q=80" alt="Lexus LS" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Lexus</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Lexus LS 500h Ultra Luxe</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-leaf text-blue-500 mr-1"></i> Multi-Stage Hybrid</span>
                                <span><i class="fa-solid fa-gears text-blue-500 mr-1"></i> CVT Auto</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E2,100 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Lexus LS 500h', 'E2,100')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1523983388277-336a66bf908b?w=600&auto=format&fit=crop&q=80" alt="Maserati Ghibli" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Maserati</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Ghibli Trofeo V8</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-fire text-blue-500 mr-1"></i> Twin Turbo V8</span>
                                <span><i class="fa-solid fa-gears text-blue-500 mr-1"></i> 8-Speed Auto</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E3,100 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Maserati Ghibli Trofeo', 'E3,100')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?w=600&auto=format&fit=crop&q=80" alt="Bentley Flying Spur" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Bentley</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Flying Spur W12 Mulliner</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-crown text-blue-500 mr-1"></i> Twin-Turbo W12</span>
                                <span><i class="fa-solid fa-gears text-blue-500 mr-1"></i> Dual-Clutch 8spd</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E5,900 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Bentley Flying Spur', 'E5,900')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="border-b border-gray-200 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-bolt text-xl text-amber-500"></i>
                <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">High-Performance Supercars</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1583121274602-3e2820c69888?w=600&auto=format&fit=crop&q=80" alt="Ferrari F8" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Ferrari</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Ferrari F8 Tributo V8</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-gauge-high text-amber-500 mr-1"></i> 710 HP</span>
                                <span><i class="fa-solid fa-fire text-amber-500 mr-1"></i> Mid-Engine RWD</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E7,500 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Ferrari F8 Tributo', 'E7,500')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1621135802920-133df287f89c?w=600&auto=format&fit=crop&q=80" alt="Lamborghini Huracan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Lamborghini</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Huracán Evo Spyder</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-gauge-high text-amber-500 mr-1"></i> Naturally Asp V10</span>
                                <span><i class="fa-solid fa-sun text-amber-500 mr-1"></i> Convertible Top</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E8,000 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Lamborghini Huracán Evo', 'E8,000')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?w=600&auto=format&fit=crop&q=80" alt="Porsche 911" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Porsche</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Porsche 911 Turbo S</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-gauge-high text-amber-500 mr-1"></i> 0-100 in 2.7s</span>
                                <span><i class="fa-solid fa-road text-amber-500 mr-1"></i> All-Wheel Drive</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E5,500 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Porsche 911 Turbo S', 'E5,500')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1544829099-b9a0c07fad1a?w=600&auto=format&fit=crop&q=80" alt="Aston Martin Vantage" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Aston Martin</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Vantage F1 Edition</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-gauge-high text-amber-500 mr-1"></i> 528 HP</span>
                                <span><i class="fa-solid fa-music text-amber-500 mr-1"></i> Twin-Turbo V8</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E4,800 <span class="text-xs font-medium text-gray-500">/day</span></span>
                                end
                            </div>
                            <button onclick="advanceStepToCheckout('Aston Martin Vantage', 'E4,800')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1542282088-fe8426682b8f?w=600&auto=format&fit=crop&q=80" alt="Audi R8" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Audi</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">R8 V10 Performance</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-bolt text-amber-500 mr-1"></i> V10 FSI Engine</span>
                                <span><i class="fa-solid fa-shield text-amber-500 mr-1"></i> Quattro AWD</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E5,200 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Audi R8 V10', 'E5,200')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1627454820516-dc767bcb4d3e?w=600&auto=format&fit=crop&q=80" alt="McLaren 720S" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">McLaren</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">McLaren 720S Performance</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-wind text-amber-500 mr-1"></i> Carbon Monocage</span>
                                <span><i class="fa-solid fa-gauge-high text-amber-500 mr-1"></i> 720 HP Twin V8</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E9,000 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('McLaren 720S', 'E9,000')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1605558202138-0c7f28c74b5f?w=600&auto=format&fit=crop&q=80" alt="Nissan GTR" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Nissan</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">GT-R Nismo Track Edition</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-gauge-high text-amber-500 mr-1"></i> Twin-Turbo V6</span>
                                <span><i class="fa-solid fa-road text-amber-500 mr-1"></i> ATTESA E-TS AWD</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E4,500 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Nissan GT-R Nismo', 'E4,500')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="border-b border-gray-200 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-mountain text-xl text-green-600"></i>
                <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Premium Luxury SUVs</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1609521263047-f8f205293f24?w=600&auto=format&fit=crop&q=80" alt="Range Rover" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Land Rover</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Range Rover Autobiography</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-couch text-green-600 mr-1"></i> First-Class Cabin</span>
                                <span><i class="fa-solid fa-water text-green-600 mr-1"></i> Air Suspension</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E3,800 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Range Rover Autobiography', 'E3,800')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=600&auto=format&fit=crop&q=80" alt="Toyota Prado" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Toyota</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Land Cruiser Prado V8</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-shield text-green-600 mr-1"></i> Heavy Armor Setup</span>
                                <span><i class="fa-solid fa-mountain-sun text-green-600 mr-1"></i> Full Terrain Matrix</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E2,000 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Land Cruiser Prado V8', 'E2,000')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1675200231846-99939e6a00f2?w=600&auto=format&fit=crop&q=80" alt="Rolls-Royce Cullinan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Rolls-Royce</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Cullinan Black Badge</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-crown text-green-600 mr-1"></i> Ultimate Opulence</span>
                                <span><i class="fa-solid fa-volume-xmark text-green-600 mr-1"></i> Acoustically Sealed</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E12,500 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Rolls-Royce Cullinan', 'E12,500')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=600&auto=format&fit=crop&q=80" alt="Porsche Cayenne" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Porsche</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Cayenne Turbo E-Hybrid</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-gauge-high text-green-600 mr-1"></i> 729 HP V8 Pack</span>
                                <span><i class="fa-solid fa-bolt text-green-600 mr-1"></i> Hybrid Sports Mode</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E4,200 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Porsche Cayenne Turbo', 'E4,200')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1511919884226-fd3cad34687c?w=600&auto=format&fit=crop&q=80" alt="Lamborghini Urus" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Lamborghini</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Urus Performante</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-gauge-high text-green-600 mr-1"></i> 666 HP Twin Turbo</span>
                                <span><i class="fa-solid fa-fire text-green-600 mr-1"></i> Akrapovič Exhaust</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E6,800 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Lamborghini Urus', 'E6,800')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1520050206274-a1ae446cb3cc?w=600&auto=format&fit=crop&q=80" alt="Mercedes G-Wagon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Mercedes-AMG</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">G 63 AMG Magno Series</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-shield-halved text-green-600 mr-1"></i> Offroad King Edition</span>
                                <span><i class="fa-solid fa-gears text-green-600 mr-1"></i> 9G-TRONIC Auto</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E5,100 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Mercedes G63 AMG', 'E5,100')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative overflow-hidden h-48 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=600&auto=format&fit=crop&q=80" alt="Bentley Bentayga" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-4 left-4 bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-extrabold tracking-widest uppercase px-3 py-1 rounded-full shadow-sm">Bentley</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Bentayga Azure Speed</h3>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span><i class="fa-solid fa-crown text-green-600 mr-1"></i> W12 Ultimate Comfort</span>
                                <span><i class="fa-solid fa-music text-green-600 mr-1"></i> Naim Audio System</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 block uppercase">Daily rate</span>
                                <span class="text-xl font-black text-gray-900">E6,200 <span class="text-xs font-medium text-gray-500">/day</span></span>
                            </div>
                            <button onclick="advanceStepToCheckout('Bentley Bentayga Azure', 'E6,200')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-md transition-all cursor-pointer">Rent Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm space-y-6">
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-amber-100 p-2.5 rounded-lg text-amber-600"><i class="fa-solid fa-id-card-clip text-lg"></i></div>
                        <div>
                            <h3 class="font-bold text-sm text-gray-900">Need a Professional Driver?</h3>
                            <p class="text-xs text-gray-500">Enable this system parameter if you require corporate chauffeur transit execution.</p>
                        </div>
                    </div>
                    <input type="checkbox" id="needs_driver" onchange="toggleDriverRoster(this.checked)" class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                </div>
            </div>

            <div id="driver-roster" class="hidden space-y-4">
                <div>
                    <h3 class="text-sm font-extrabold text-gray-900 tracking-tight"><i class="fa-solid fa-id-card text-blue-600 mr-1"></i> Select Your Personal Certified Chauffeur</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Your chosen driver stays bound with the vehicle for secure point-to-point transport operations.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Driver 1 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Thabo Dlamini" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" checked />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80" alt="Thabo Dlamini" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Thabo Dlamini</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2024-001</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Male</span> &middot; <span>12 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 1234</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>thabo.d@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Mbabane, Ezulwini</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.9 <span class="text-gray-400 font-normal text-[10px]">(245)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 2 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Sarah Mkhize" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&auto=format&fit=crop&q=80" alt="Sarah Mkhize" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Sarah Mkhize</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2023-087</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Female</span> &middot; <span>8 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 2345</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>sarah.m@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Manzini, Fairview</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.8 <span class="text-gray-400 font-normal text-[10px]">(189)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 3 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Jabulani Zwane" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80" alt="Jabulani Zwane" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Jabulani Zwane</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2022-156</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Male</span> &middot; <span>15 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 3456</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>jabulani.z@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Lobamba, Royal Village</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 5.0 <span class="text-gray-400 font-normal text-[10px]">(312)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 4 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Nomsa Simelane" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&auto=format&fit=crop&q=80" alt="Nomsa Simelane" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Nomsa Simelane</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2024-023</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Female</span> &middot; <span>6 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 4567</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>nomsa.s@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Mbabane, The Mall</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.7 <span class="text-gray-400 font-normal text-[10px]">(156)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 5 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Sibusiso Dube" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=150&auto=format&fit=crop&q=80" alt="Sibusiso Dube" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Sibusiso Dube</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2021-098</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Male</span> &middot; <span>18 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 5678</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>sibusiso.d@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Nhlangano, Industrial</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.9 <span class="text-gray-400 font-normal text-[10px]">(278)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 6 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Lerato Mokoena" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80" alt="Lerato Mokoena" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Lerato Mokoena</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2023-134</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Female</span> &middot; <span>7 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 6789</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>lerato.m@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Mbabane, New Mall</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.8 <span class="text-gray-400 font-normal text-[10px]">(201)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 7 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Musa Nkosi" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&auto=format&fit=crop&q=80" alt="Musa Nkosi" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Musa Nkosi</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2020-076</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Male</span> &middot; <span>20 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 7890</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>musa.n@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Siteki, Town Center</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 5.0 <span class="text-gray-400 font-normal text-[10px]">(389)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 8 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Zanele Khumalo" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80" alt="Zanele Khumalo" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Zanele Khumalo</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2024-045</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Female</span> &middot; <span>5 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 8901</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>zanele.k@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Mbabane, Gables</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.6 <span class="text-gray-400 font-normal text-[10px]">(134)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 9 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Kagiso Maseko" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?w=150&auto=format&fit=crop&q=80" alt="Kagiso Maseko" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Kagiso Maseko</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2019-054</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Male</span> &middot; <span>22 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 9012</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>kagiso.m@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Malkerns, Valley</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.9 <span class="text-gray-400 font-normal text-[10px]">(421)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 10 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Refilwe Ndlovu" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1513956589380-bad6acb9b9d4?w=150&auto=format&fit=crop&q=80" alt="Refilwe Ndlovu" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Refilwe Ndlovu</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2023-189</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Female</span> &middot; <span>9 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 0123</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>refilwe.n@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Mbabane, Corporate Park</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.8 <span class="text-gray-400 font-normal text-[10px]">(267)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 11 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Bongani Motsa" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1566492031773-4f4e44671857?w=150&auto=format&fit=crop&q=80" alt="Bongani Motsa" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Bongani Motsa</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2022-112</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Male</span> &middot; <span>14 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 1235</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>bongani.m@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Matsapha, Industrial</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.7 <span class="text-gray-400 font-normal text-[10px]">(198)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 12 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Thandiwe Shongwe" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=150&auto=format&fit=crop&q=80" alt="Thandiwe Shongwe" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Thandiwe Shongwe</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2024-067</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Female</span> &middot; <span>4 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 2346</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>thandiwe.s@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Mbabane, Riverside</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.5 <span class="text-gray-400 font-normal text-[10px]">(112)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 13 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Sipho Mabuza" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150&auto=format&fit=crop&q=80" alt="Sipho Mabuza" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Sipho Mabuza</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2018-032</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Male</span> &middot; <span>25 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 3457</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>sipho.m@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Piggs Peak, Mountain View</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 5.0 <span class="text-gray-400 font-normal text-[10px]">(456)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 14 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Busisiwe Hlatshwayo" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1607746882042-944635dfe10e?w=150&auto=format&fit=crop&q=80" alt="Busisiwe Hlatshwayo" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Busisiwe Hlatshwayo</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2023-201</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Female</span> &middot; <span>8 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 4568</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>busisiwe.h@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Manzini, Hub</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.8 <span class="text-gray-400 font-normal text-[10px]">(223)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 15 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Mpho Motha" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=150&auto=format&fit=crop&q=80" alt="Mpho Motha" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Mpho Motha</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2021-145</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Male</span> &middot; <span>16 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 5679</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>mpho.m@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Big Bend, Sugar Belt</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.9 <span class="text-gray-400 font-normal text-[10px]">(334)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 16 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Nomvula Dlamini" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80" alt="Nomvula Dlamini" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Nomvula Dlamini</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2024-089</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Female</span> &middot; <span>3 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 6780</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>nomvula.d@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Mbabane, Central</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.4 <span class="text-gray-400 font-normal text-[10px]">(98)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 17 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Lucky Mngomezulu" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=150&auto=format&fit=crop&q=80" alt="Lucky Mngomezulu" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Lucky Mngomezulu</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2020-178</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Male</span> &middot; <span>19 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 7891</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>lucky.m@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Nhlangano, Border Post</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.9 <span class="text-gray-400 font-normal text-[10px]">(387)</span></div>
                            </div>
                        </div>
                    </label>

                    <!-- Driver 18 -->
                    <label class="relative flex flex-col justify-between p-5 border border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-blue-50/30 cursor-pointer transition select-none group">
                        <input type="radio" name="selected_driver" value="Precious Dube" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&auto=format&fit=crop&q=80" alt="Precious Dube" />
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Precious Dube</h5>
                                <p class="text-[10px] text-gray-500 font-semibold tracking-wider">Lic: CD-2023-223</p>
                                <div class="flex gap-2 mt-1 text-[11px] font-medium text-gray-600">
                                    <span>Female</span> &middot; <span>10 yrs exp</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200/60 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-phone text-blue-500"></i>
                                <span>+268 7600 8902</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-envelope text-blue-500"></i>
                                <span>precious.d@bling.co.sz</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                                <i class="fa-solid fa-location-dot text-blue-500"></i>
                                <span class="truncate">Mbabane, Embassy</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md font-bold text-[10px]">VVIP Certified</span>
                                <div class="text-amber-500 font-bold flex items-center gap-1"><i class="fa-solid fa-star"></i> 4.8 <span class="text-gray-400 font-normal text-[10px]">(289)</span></div>
                            </div>
                        </div>
                    </label>
                </div>











            </div>
        </div>
    </div>

    <div id="payment-screen" class="hidden max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 dynamic-fade mt-6">

        <div class="md:col-span-2 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm space-y-6">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Select Secure Payment Method</h2>
                <p class="text-xs text-gray-500">Transactions processed under encrypted local regulatory security tokens.</p>
            </div>

            <div class="space-y-3">
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <label class="flex items-center justify-between p-4 bg-gray-50 cursor-pointer" onclick="togglePaymentFields('card')">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="pay_method" id="pay_card" value="Credit/Debit Card" checked>
                            <span class="text-sm font-bold text-gray-800"><i class="fa-solid fa-credit-card text-blue-600 mr-2"></i>Credit or Debit Card</span>
                        </div>
                    </label>
                    <div id="card-fields" class="p-4 border-t border-gray-200 space-y-3 bg-white">
                        <input type="text" placeholder="Cardholder Name" class="w-full text-sm border border-gray-200 rounded-lg p-2.5 bg-gray-50/50 outline-none">
                        <input type="text" placeholder="Card Number (0000 0000 0000 0000)" class="w-full text-sm border border-gray-200 rounded-lg p-2.5 bg-gray-50/50 outline-none">
                    </div>
                </div>

                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <label class="flex items-center justify-between p-4 bg-gray-50 cursor-pointer" onclick="togglePaymentFields('mobile')">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="pay_method" id="pay_mobile" value="Mobile Money Wallet">
                            <span class="text-sm font-bold text-gray-800"><i class="fa-solid fa-mobile-screen-button text-purple-600 mr-2"></i>Mobile Money / Wallet</span>
                        </div>
                    </label>
                    <div id="mobile-fields" class="p-4 border-t border-gray-200 bg-white hidden">
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-sm font-bold text-gray-400">+268</span>
                            <input type="tel" placeholder="7600 0000" class="w-full text-sm border border-gray-200 rounded-lg p-2.5 pl-14 bg-gray-50/50 outline-none">
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <label class="flex items-center justify-between p-4 bg-gray-50 cursor-pointer" onclick="togglePaymentFields('paypal')">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="pay_method" id="pay_paypal" value="PayPal Express Account">
                            <span class="text-sm font-bold text-gray-800"><i class="fa-brands fa-paypal text-blue-500 mr-2"></i>PayPal Digital Wallet</span>
                        </div>
                    </label>
                    <div id="paypal-fields" class="p-4 border-t border-gray-200 bg-white hidden space-y-2">
                        <div class="bg-blue-50/60 p-3 rounded-xl border border-blue-100 flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-info text-blue-600 mt-0.5 text-xs"></i>
                            <p class="text-[11px] leading-relaxed text-blue-800">You will be redirected safely to PayPal's external secure endpoint servers to authorize the instant balance settlement routing token.</p>
                        </div>
                        <input type="email" placeholder="paypal-account-email@domain.com" class="w-full text-sm border border-gray-200 rounded-lg p-2.5 bg-gray-50/50 outline-none">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 space-y-4">
                <div>
                    <h3 class="text-sm font-extrabold text-gray-900 tracking-tight"><i class="fa-solid fa-map-location-dot text-blue-600 mr-1"></i> Delivery / Fulfillment Method</h3>
                    <p class="text-xs text-gray-500">Configure how you intend to take physical operational custody over the fleet asset.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="relative border-2 border-blue-600 bg-blue-50/20 rounded-xl p-4 flex flex-col justify-between cursor-pointer" id="collect-card">
                        <input type="radio" name="transit_method" value="Company Premise Collection" checked onclick="toggleTransitDisplay('collect')" class="absolute top-4 right-4">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Get From Company Premises</h4>
                            <p class="text-xs text-gray-500 mt-1">Collect directly from our main centralized physical office registry address base.</p>
                        </div>
                    </label>

                    <label class="relative border border-gray-200 bg-white rounded-xl p-4 flex flex-col justify-between cursor-pointer" id="drop-card">
                        <input type="radio" name="transit_method" value="Chauffeur Drop-Off Protocol" onclick="toggleTransitDisplay('drop')" class="absolute top-4 right-4">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Pick a Driver to Drop Off</h4>
                            <p class="text-xs text-gray-500 mt-1">An executive deployment team logistics handler drops the vehicle off at your coordinates.</p>
                        </div>
                    </label>
                </div>

                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                    <div id="collect-address-info">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Company Physical Depot Address Location:</div>
                        <p class="text-xs font-bold text-gray-800"><i class="fa-solid fa-location-dot text-red-500 mr-1.5"></i>Suite 402, Bling Towers, Custom Corporate Highway, Mbabane, Eswatini</p>
                    </div>
                    <div id="drop-address-info" class="hidden space-y-2">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Specify Destination Drop-off Address:</div>
                        <input type="text" id="delivery_address_input" placeholder="Enter complete delivery street address data line here..." class="w-full text-sm border border-gray-200 rounded-lg p-2.5 bg-white outline-none">
                    </div>
                </div>
            </div>

            <button id="processPaymentBtn" onclick="executeFinalPaymentProcess()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm py-4 px-6 rounded-xl shadow-lg transition-all active:scale-[0.99] cursor-pointer">
                <i class="fa-solid fa-lock mr-2"></i> Process and Authorize Payment Order
            </button>
        </div>

        <div class="bg-gray-900 rounded-2xl p-6 text-white self-start space-y-6 shadow-xl">
            <div class="border-b border-white/10 pb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-widest text-blue-400">Checkout Ledger</h3>
            </div>
            <div class="space-y-4 text-xs">
                <div class="flex justify-between"><span>Selected Fleet Vehicle:</span><span id="receipt-car-model" class="font-bold text-white">---</span></div>
                <div class="flex justify-between"><span>Operator Status:</span><span id="receipt-driver" class="font-bold text-amber-400">---</span></div>
                <div class="flex justify-between"><span>Base Daily Rate:</span><span id="receipt-base-rate" class="font-mono font-bold text-white">---</span></div>
                <div class="pt-4 border-t border-white/10 flex justify-between items-baseline">
                    <span class="text-sm font-bold">Gross Total Value:</span>
                    <span id="receipt-total-gross" class="text-2xl font-black font-mono text-emerald-400">E0.00</span>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmation-screen" class="hidden max-w-xl mx-auto bg-white border border-gray-100 shadow-xl rounded-3xl p-8 text-center space-y-6 dynamic-fade">
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl mx-auto shadow-md">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Car Rental Order Confirmed!</h1>
            <p class="text-xs text-gray-500 mt-1">Thank you! Your payment has been authorized and your vehicle is successfully reserved.</p>
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 text-left space-y-3.5 text-xs">
            <div class="flex justify-between border-b border-gray-200/60 pb-2"><span>Vehicle Reserved:</span><span id="conf-car-model" class="font-bold text-gray-900">---</span></div>
            <div class="flex justify-between border-b border-gray-200/60 pb-2"><span>Assigned Driver:</span><span id="conf-driver" class="font-bold text-gray-900">---</span></div>
            <div class="flex justify-between border-b border-gray-200/60 pb-2"><span>Payment Method:</span><span id="conf-pay-method" class="text-blue-600 font-bold">---</span></div>
            <div class="flex justify-between border-b border-gray-200/60 pb-2"><span>Fulfillment Method:</span><span id="conf-transit-method" class="text-purple-600 font-bold">---</span></div>
            <div class="pt-1">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Handover Instructions / Location Target:</span>
                <p class="text-xs font-bold text-gray-800 bg-white border border-gray-200 p-2.5 rounded-lg shadow-inner"><i class="fa-solid fa-location-crosshairs text-red-500 mr-1"></i><span id="conf-address-output">---</span></p>
            </div>
            <div class="pt-1">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Booking Reference</span>
                <p id="conf-booking-id" class="text-sm font-bold text-gray-900 bg-white border border-gray-200 p-3 rounded-lg shadow-inner">#Pending</p>
            </div>
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <button type="button" onclick="printReceipt()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-3 px-4 rounded-xl shadow-md transition">
                <i class="fa-solid fa-print mr-2"></i> Print Receipt
            </button>
            <button type="button" onclick="printReceipt()" class="w-full bg-slate-700 hover:bg-slate-800 text-white font-bold text-sm py-3 px-4 rounded-xl shadow-md transition">
                <i class="fa-solid fa-file-pdf mr-2"></i> Save as PDF
            </button>
        </div>

        <div class="pt-2">
            <a href="booking.php" class="block w-full bg-gray-900 hover:bg-black text-white font-bold text-xs py-3.5 px-4 rounded-xl shadow-md transition text-center">
                Return to Fleet View
            </a>
        </div>
    </div>

</main>

<script>
    let reservationState = {
        carModel: null,
        dailyRate: null,
        driver: "Self-Drive Base",
        paymentMethod: null,
        transitMethod: null,
        handoverAddress: null,
        bookingId: null
    };

    function toggleDriverRoster(isChecked) {
        document.getElementById('driver-roster').classList.toggle('hidden', !isChecked);
    }

    function advanceStepToCheckout(modelName, rate) {
        reservationState.carModel = modelName;
        reservationState.dailyRate = rate;

        const driverCheckbox = document.getElementById('needs_driver');
        if (driverCheckbox && driverCheckbox.checked) {
            const checkedDriver = document.querySelector('input[name="selected_driver"]:checked');
            reservationState.driver = checkedDriver ? checkedDriver.value : "Assigned Professional Driver";
        } else {
            reservationState.driver = "Self-Drive Base Options Selected";
        }

        document.getElementById('receipt-car-model').innerText = reservationState.carModel;
        document.getElementById('receipt-driver').innerText = reservationState.driver;
        document.getElementById('receipt-base-rate').innerText = reservationState.dailyRate;
        document.getElementById('receipt-total-gross').innerText = reservationState.dailyRate;

        document.getElementById('fleet-screen').classList.add('hidden');
        document.getElementById('payment-screen').classList.remove('hidden');

        document.getElementById('step-progress-line').style.width = '100%';
        document.getElementById('step1-badge').className = "rounded-full h-10 w-10 flex items-center justify-center bg-gray-200 text-gray-600 font-bold text-sm transition-all duration-300";
        document.getElementById('step1-label').className = "absolute top-12 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider w-24";
        document.getElementById('step2-badge').className = "rounded-full h-10 w-10 flex items-center justify-center bg-blue-600 text-white font-bold text-sm shadow-lg shadow-blue-500/30 transition-all duration-300";
        document.getElementById('step2-label').className = "absolute top-12 text-center text-[10px] font-extrabold text-blue-600 uppercase tracking-wider w-24";

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function togglePaymentFields(type) {
        document.getElementById('card-fields').classList.toggle('hidden', type !== 'card');
        document.getElementById('mobile-fields').classList.toggle('hidden', type !== 'mobile');
        document.getElementById('paypal-fields').classList.toggle('hidden', type !== 'paypal');

        document.getElementById('pay_card').checked = (type === 'card');
        document.getElementById('pay_mobile').checked = (type === 'mobile');
        document.getElementById('pay_paypal').checked = (type === 'paypal');
    }

    function toggleTransitDisplay(method) {
        const collectCard = document.getElementById('collect-card');
        const dropCard = document.getElementById('drop-card');
        const collectInfo = document.getElementById('collect-address-info');
        const dropInfo = document.getElementById('drop-address-info');

        if (method === 'collect') {
            collectCard.className = "relative border-2 border-blue-600 bg-blue-50/20 rounded-xl p-4 flex flex-col justify-between cursor-pointer";
            dropCard.className = "relative border border-gray-200 bg-white rounded-xl p-4 flex flex-col justify-between cursor-pointer";
            collectInfo.classList.remove('hidden');
            dropInfo.classList.add('hidden');
        } else {
            dropCard.className = "relative border-2 border-blue-600 bg-blue-50/20 rounded-xl p-4 flex flex-col justify-between cursor-pointer";
            collectCard.className = "relative border border-gray-200 bg-white rounded-xl p-4 flex flex-col justify-between cursor-pointer";
            collectInfo.classList.add('hidden');
            dropInfo.classList.remove('hidden');
        }
    }

    async function executeFinalPaymentProcess() {
        const selectedPaymentMethod = document.querySelector('input[name="pay_method"]:checked').value;
        const selectedTransitMethod = document.querySelector('input[name="transit_method"]:checked').value;
        let finalAddressString = "Suite 402, Bling Towers, Custom Corporate Highway, Mbabane, Eswatini";

        if (selectedTransitMethod !== "Company Premise Collection") {
            const inputVal = document.getElementById('delivery_address_input').value.trim();
            if (inputVal === "") {
                alert("Validation Error: Please provide a valid drop-off location address.");
                return;
            }
            finalAddressString = inputVal;
        }

        reservationState.paymentMethod = selectedPaymentMethod;
        reservationState.transitMethod = selectedTransitMethod;
        reservationState.handoverAddress = finalAddressString;
        reservationState.totalPayment = parseCurrencyValue(reservationState.dailyRate);

        const payButton = document.getElementById('processPaymentBtn');
        payButton.disabled = true;
        payButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

        try {
            const result = await submitBookingData();
            if (!result.success) {
                throw new Error(result.message || 'Booking could not be completed.');
            }

            reservationState.bookingId = result.booking_id;
            
            // Redirect to payment receipt page
            window.location.href = `payment.php?booking_id=${reservationState.bookingId}`;
        } catch (error) {
            alert(error.message || 'Booking could not be completed. Please try again.');
            payButton.disabled = false;
            payButton.innerHTML = '<i class="fa-solid fa-lock mr-2"></i> Process and Authorize Payment Order';
        }
    }

    function parseCurrencyValue(value) {
        if (!value || typeof value !== 'string') return 0;
        const normalized = value.replace(/[^0-9\.]/g, '').replace(/,/g, '');
        return parseFloat(normalized) || 0;
    }

    async function submitBookingData() {
        const payload = {
            car_model: reservationState.carModel,
            daily_rate: reservationState.dailyRate,
            driver_name: reservationState.driver,
            payment_method: reservationState.paymentMethod,
            transit_method: reservationState.transitMethod,
            handover_address: reservationState.handoverAddress,
            total_payment: reservationState.totalPayment
        };

        const response = await fetch('process_booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        return await response.json();
    }

    function printReceipt() {
        window.print();
    }
</script>

<style>
    .dynamic-fade {
        animation: entryEffect 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes entryEffect {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #confirmation-screen,
        #confirmation-screen * {
            visibility: visible;
        }

        #confirmation-screen {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
            margin: 0;
        }

        #confirmation-screen a,
        button {
            display: none !important;
        }
    }
</style>

<?php
include(__DIR__ . '/layouts/footer.php');

// Fetch available drivers from database
require_once 'config.php';

$drivers = [];

// Create staff table if it doesn't exist
$createTableQuery = "CREATE TABLE IF NOT EXISTS staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    license_number VARCHAR(50) NOT NULL UNIQUE,
    role VARCHAR(50) NOT NULL DEFAULT 'Chauffeur Driver',
    profile_image VARCHAR(255) DEFAULT NULL,
    rating DECIMAL(3,1) DEFAULT 4.5,
    reviews_count INT DEFAULT 0,
    age INT DEFAULT NULL,
    gender VARCHAR(20) DEFAULT 'Male',
    license_class VARCHAR(10) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
@$conn->query($createTableQuery);

// Fetch drivers where role is 'Chauffeur Driver'
$driverQuery = "SELECT id, full_name, email, license_number, rating, reviews_count, age, gender FROM staff WHERE role = 'Chauffeur Driver' ORDER BY rating DESC LIMIT 12";
$driverResult = @$conn->query($driverQuery);

if ($driverResult && $driverResult->num_rows > 0) {
    while ($row = $driverResult->fetch_assoc()) {
        $drivers[] = $row;
    }
}

// If no drivers in database, provide defaults
if (empty($drivers)) {
    $drivers = [
        ['id' => 1, 'full_name' => 'Sibusiso Mamba', 'license_number' => 'SZL-90122', 'rating' => 4.9, 'reviews_count' => 142, 'age' => 38, 'gender' => 'Male'],
        ['id' => 2, 'full_name' => 'Thabo Dlamini', 'license_number' => 'SZL-90123', 'rating' => 4.8, 'reviews_count' => 128, 'age' => 42, 'gender' => 'Male'],
        ['id' => 3, 'full_name' => 'Melusi Shongwe', 'license_number' => 'SZL-90124', 'rating' => 4.7, 'reviews_count' => 115, 'age' => 35, 'gender' => 'Male'],
        ['id' => 4, 'full_name' => 'Zweli Nxumalo', 'license_number' => 'SZL-90125', 'rating' => 4.9, 'reviews_count' => 156, 'age' => 40, 'gender' => 'Male'],
        ['id' => 5, 'full_name' => 'Nomsa Tsabedze', 'license_number' => 'SZL-90126', 'rating' => 4.8, 'reviews_count' => 133, 'age' => 32, 'gender' => 'Female'],
        ['id' => 6, 'full_name' => 'Sipho Nxumalo', 'license_number' => 'SZL-90127', 'rating' => 4.7, 'reviews_count' => 121, 'age' => 45, 'gender' => 'Male'],
        ['id' => 7, 'full_name' => 'Lungelo Gamedze', 'license_number' => 'SZL-90128', 'rating' => 4.6, 'reviews_count' => 98, 'age' => 38, 'gender' => 'Male'],
        ['id' => 8, 'full_name' => 'Tfobile Simelane', 'license_number' => 'SZL-90129', 'rating' => 4.8, 'reviews_count' => 145, 'age' => 41, 'gender' => 'Male'],
        ['id' => 9, 'full_name' => 'Nhlanhla Fakudze', 'license_number' => 'SZL-90130', 'rating' => 4.7, 'reviews_count' => 112, 'age' => 36, 'gender' => 'Male'],
        ['id' => 10, 'full_name' => 'Mcebo Masuku', 'license_number' => 'SZL-90131', 'rating' => 4.9, 'reviews_count' => 167, 'age' => 39, 'gender' => 'Male'],
        ['id' => 11, 'full_name' => 'Bongiwe Khumalo', 'license_number' => 'SZL-90132', 'rating' => 4.8, 'reviews_count' => 139, 'age' => 34, 'gender' => 'Female'],
        ['id' => 12, 'full_name' => 'Sandile Mazibuko', 'license_number' => 'SZL-90133', 'rating' => 4.6, 'reviews_count' => 105, 'age' => 43, 'gender' => 'Male']
    ];
}
?>