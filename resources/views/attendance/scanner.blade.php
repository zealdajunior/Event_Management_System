<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Code Scanner - Event Check-in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-3xl shadow-xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">QR Code Scanner</h1>
                    <p class="text-gray-600">Scan attendee tickets for check-in</p>
                </div>
                <a href="@dashboardRoute" class="px-4 py-2 bg-gray-500 text-white rounded-xl hover:bg-gray-600">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Scanner Section -->
            <div class="bg-white rounded-3xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Camera Scanner</h2>
                    <!-- Camera Switch Button -->
                    <div class="flex gap-2">
                        <button id="permission-btn" 
                                onclick="requestCameraPermission()" 
                                class="px-3 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-all duration-300 text-sm font-medium">
                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Allow Camera
                        </button>
                        <button id="switch-camera-btn" 
                                onclick="switchCamera()" 
                                class="hidden px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-300 text-sm font-medium">
                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span id="camera-label">Switch</span>
                        </button>
                        <button id="start-stop-btn" 
                                onclick="toggleScanner()" 
                                class="px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all duration-300 text-sm font-medium">
                            <span id="scanner-status">Stop</span>
                        </button>
                    </div>
                </div>
                
                <!-- QR Reader -->
                <div id="reader" class="rounded-xl overflow-hidden border-4 border-blue-500 mb-4 min-h-[300px]"></div>
                
                <!-- Camera Status -->
                <div id="camera-status" class="hidden text-sm text-center mb-4 p-3 bg-green-50 rounded-lg border border-green-200">
                    <span id="current-camera">Camera Active</span>
                </div>
                
                <!-- Manual QR Code Input -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Or Enter QR Code Manually</label>
                    <div class="flex gap-2">
                        <input type="text" id="manual-qr-input" 
                               class="flex-1 rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                               placeholder="Enter QR code">
                        <button onclick="checkInManual()" 
                                class="px-6 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">
                            Check In
                        </button>
                    </div>
                </div>
            </div>

            <!-- Result Section -->
            <div class="bg-white rounded-3xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Scan Result</h2>
                
                <div id="result-container" class="text-center py-12">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    <p class="text-gray-500">Waiting for scan...</p>
                </div>
            </div>
        </div>

        <!-- Recent Check-ins -->
        <div class="bg-white rounded-3xl shadow-xl p-6 mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Check-ins</h2>
            <div id="recent-checkins" class="space-y-3">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        let html5QrcodeScanner;
        let recentCheckIns = [];

        function onScanSuccess(decodedText, decodedResult) {
            // Stop scanning temporarily
            if (html5QrcodeScanner && isScanning) {
                html5QrcodeScanner.pause();
            }
            
            // Process check-in
            processCheckIn(decodedText);
        }

        function processCheckIn(qrCode) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch('{{ route("attendance.check-in") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ qr_code: qrCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Successfully checked in') {
                    showSuccess(data.attendance);
                    addToRecentCheckIns(data.attendance);
                } else {
                    showError(data.message);
                }
                
                // Resume scanning after 2 seconds
                setTimeout(() => {
                    if (html5QrcodeScanner && isScanning) {
                        html5QrcodeScanner.resume();
                    }
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Failed to process check-in');
                
                // Resume scanning
                setTimeout(() => {
                    if (html5QrcodeScanner && isScanning) {
                        html5QrcodeScanner.resume();
                    }
                }, 2000);
            });
        }

        function showSuccess(attendance) {
            const resultContainer = document.getElementById('result-container');
            resultContainer.innerHTML = `
                <div class="text-center">
                    <svg class="w-24 h-24 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-green-600 mb-2">Check-in Successful!</h3>
                    <div class="bg-green-50 rounded-xl p-4 mt-4 text-left">
                        <p class="text-gray-700"><strong>Name:</strong> ${attendance.user.name}</p>
                        <p class="text-gray-700"><strong>Event:</strong> ${attendance.event.title}</p>
                        <p class="text-gray-700"><strong>Time:</strong> ${new Date().toLocaleString()}</p>
                    </div>
                </div>
            `;
        }

        function showError(message) {
            const resultContainer = document.getElementById('result-container');
            resultContainer.innerHTML = `
                <div class="text-center">
                    <svg class="w-24 h-24 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-red-600 mb-2">Check-in Failed</h3>
                    <p class="text-gray-700">${message}</p>
                </div>
            `;
        }

        function addToRecentCheckIns(attendance) {
            recentCheckIns.unshift(attendance);
            if (recentCheckIns.length > 5) recentCheckIns.pop();
            
            const recentContainer = document.getElementById('recent-checkins');
            recentContainer.innerHTML = recentCheckIns.map(item => `
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl border border-green-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">
                            ${item.user.name.charAt(0)}
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">${item.user.name}</p>
                            <p class="text-sm text-gray-500">${item.event.title}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-green-500 text-white text-xs rounded-full">Checked In</span>
                </div>
            `).join('');
        }

        function checkInManual() {
            const input = document.getElementById('manual-qr-input');
            const qrCode = input.value.trim();
            
            if (!qrCode) {
                alert('Please enter a QR code');
                return;
            }
            
            processCheckIn(qrCode);
            input.value = '';
        }

        // Initialize scanner when page loads
        document.addEventListener('DOMContentLoaded', function() {
            html5QrcodeScanner = new Html5Qrcode("reader");
            
            // Show initial loading message
            document.getElementById('reader').innerHTML = `
                <div class="p-8 text-center">
                    <div class="animate-spin w-12 h-12 mx-auto border-4 border-blue-500 border-t-transparent rounded-full mb-4"></div>
                    <p class="text-gray-600">Requesting camera access...</p>
                    <p class="text-sm text-gray-500 mt-2">Please allow camera permission when prompted</p>
                </div>
            `;
            
            // Reset UI state
            document.getElementById('scanner-status').textContent = 'Start';
            document.getElementById('start-stop-btn').classList.remove('bg-red-500', 'hover:bg-red-600');
            document.getElementById('start-stop-btn').classList.add('bg-green-500', 'hover:bg-green-600');
            isScanning = false;
            
            // Start scanner after a short delay
            setTimeout(() => {
                startScanner();
            }, 1000);

            // Handle manual QR input on Enter key
            document.getElementById('manual-qr-input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    checkInManual();
                }
            });
        });

        // Enhanced camera functionality for mobile devices
        let currentFacingMode = "environment"; // Start with back camera
        let availableCameras = [];
        let currentCameraId = null;
        let isScanning = false;

        async function getCameraDevices() {
            try {
                const devices = await Html5Qrcode.getCameras();
                availableCameras = devices;
                
                if (devices && devices.length > 1) {
                    // Show camera switch button if multiple cameras available
                    document.getElementById('switch-camera-btn').classList.remove('hidden');
                    updateCameraLabel();
                }
                
                return devices;
            } catch (err) {
                console.warn('Unable to enumerate cameras:', err);
                return [];
            }
        }

        function updateCameraLabel() {
            const label = document.getElementById('camera-label');
            const status = document.getElementById('current-camera');
            
            if (currentFacingMode === "environment") {
                label.textContent = "Front";
                status.textContent = "Using: Back Camera";
            } else {
                label.textContent = "Back";
                status.textContent = "Using: Front Camera";
            }
            
            document.getElementById('camera-status').classList.remove('hidden');
        }

        async function switchCamera() {
            if (!html5QrcodeScanner || availableCameras.length < 2) return;
            
            try {
                // Stop current scanner
                await html5QrcodeScanner.stop();
                
                // Switch camera mode
                currentFacingMode = currentFacingMode === "environment" ? "user" : "environment";
                
                // Find appropriate camera
                let cameraToUse = { facingMode: currentFacingMode };
                
                // Try to find specific camera by label
                const targetCamera = availableCameras.find(camera => {
                    const label = camera.label.toLowerCase();
                    return currentFacingMode === "environment" 
                        ? (label.includes('back') || label.includes('rear') || label.includes('environment'))
                        : (label.includes('front') || label.includes('user') || label.includes('face'));
                });
                
                if (targetCamera) {
                    cameraToUse = targetCamera.id;
                    currentCameraId = targetCamera.id;
                }
                
                // Start with new camera
                await startScanner(cameraToUse);
                updateCameraLabel();
                
            } catch (err) {
                console.error('Error switching camera:', err);
                showCameraError('Failed to switch camera. Using default camera.');
            }
        }

        async function startScanner(cameraConfig = null) {
            try {
                console.log('Starting scanner...');
                console.log('Browser:', navigator.userAgent);
                console.log('MediaDevices available:', !!navigator.mediaDevices);
                console.log('getUserMedia available:', !!navigator.mediaDevices?.getUserMedia);
                
                // Reset reader container
                document.getElementById('reader').innerHTML = `
                    <div class="p-8 text-center">
                        <div class="animate-spin w-8 h-8 mx-auto border-4 border-blue-500 border-t-transparent rounded-full mb-4"></div>
                        <p class="text-gray-600">Starting camera...</p>
                    </div>
                `;

                // More lenient browser support check
                let hasCamera = false;
                
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    hasCamera = true;
                    console.log('Using modern mediaDevices API');
                } else if (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia) {
                    hasCamera = true;
                    console.log('Using legacy getUserMedia API');
                }
                
                if (!hasCamera) {
                    console.error('No camera API available');
                    showBrowserNotSupported();
                    return;
                }

                try {
                    console.log('Requesting camera permission...');
                    
                    // Try to get camera access
                    const stream = await navigator.mediaDevices.getUserMedia({ 
                        video: { 
                            facingMode: currentFacingMode,
                            width: { ideal: 640 },
                            height: { ideal: 480 }
                        } 
                    });
                    
                    console.log('Camera permission granted, stream:', stream);
                    // Stop the test stream immediately
                    stream.getTracks().forEach(track => {
                        console.log('Stopping track:', track.kind);
                        track.stop();
                    });
                } catch (permissionError) {
                    console.error('Camera permission denied:', permissionError);
                    showPermissionError();
                    return;
                }

                // Use simple facingMode configuration for better compatibility
                let finalCameraConfig = { facingMode: currentFacingMode };
                
                console.log('Using camera config:', finalCameraConfig);

                const config = {
                    fps: 10,
                    qrbox: function(viewfinderWidth, viewfinderHeight) {
                        // Make QR box responsive to screen size
                        let size = Math.min(viewfinderWidth, viewfinderHeight) * 0.8;
                        return {
                            width: Math.min(size, 250),
                            height: Math.min(size, 250)
                        };
                    },
                    aspectRatio: 1.0,
                };

                console.log('Starting Html5Qrcode scanner...');
                await html5QrcodeScanner.start(finalCameraConfig, config, onScanSuccess);
                
                console.log('Scanner started successfully');
                isScanning = true;
                
                // Hide permission button and show other controls
                document.getElementById('permission-btn').classList.add('hidden');
                
                // Update UI
                document.getElementById('scanner-status').textContent = 'Stop';
                document.getElementById('start-stop-btn').classList.remove('bg-green-500', 'hover:bg-green-600');
                document.getElementById('start-stop-btn').classList.add('bg-red-500', 'hover:bg-red-600');
                
                // Show camera status feedback
                showCameraSuccess();
                
                // Get available cameras for switching
                getCameraDevices();
                
            } catch (err) {
                console.error('Unable to start scanner:', err);
                console.error('Error details:', err.name, err.message);
                
                if (err.name === 'NotAllowedError' || err.message.includes('Permission denied')) {
                    showPermissionError();
                } else if (err.name === 'NotFoundError') {
                    showNoCameraError();
                } else {
                    showCameraError(`Unable to access camera: ${err.message || 'Unknown error'}. Check console for details.`);
                }
            }
        }

        async function stopScanner() {
            try {
                if (html5QrcodeScanner && isScanning) {
                    await html5QrcodeScanner.stop();
                    isScanning = false;
                    
                    // Update UI
                    document.getElementById('scanner-status').textContent = 'Start';
                    document.getElementById('start-stop-btn').classList.remove('bg-red-500', 'hover:bg-red-600');
                    document.getElementById('start-stop-btn').classList.add('bg-green-500', 'hover:bg-green-600');
                    
                    document.getElementById('reader').innerHTML = `
                        <div class="p-8 text-center">
                            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="3 9a9 9 0 019-9m9 0a9 9 0 019 9m-9-3.75h.01"></path>
                            </svg>
                            <p class="text-gray-500">Scanner stopped</p>
                            <button onclick="toggleScanner()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                Start Scanner
                            </button>
                        </div>
                    `;
                }
            } catch (err) {
                console.error('Error stopping scanner:', err);
            }
        }

        async function toggleScanner() {
            if (isScanning) {
                await stopScanner();
            } else {
                await startScanner();
            }
        }

        function showBrowserNotSupported() {
            console.log('Browser details for debugging:');
            console.log('User Agent:', navigator.userAgent);
            console.log('MediaDevices:', !!navigator.mediaDevices);
            console.log('getUserMedia:', !!navigator.mediaDevices?.getUserMedia);
            console.log('Legacy getUserMedia:', !!navigator.getUserMedia);
            console.log('WebKit getUserMedia:', !!navigator.webkitGetUserMedia);
            console.log('Mozilla getUserMedia:', !!navigator.mozGetUserMedia);
            console.log('Protocol:', window.location.protocol);
            console.log('Is HTTPS:', window.location.protocol === 'https:');
            
            // Check if it's an HTTPS issue
            const isHttps = window.location.protocol === 'https:';
            const isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
            
            if (!isHttps && !isLocalhost) {
                // Show HTTPS requirement message
                document.getElementById('reader').innerHTML = `
                    <div class="p-6 text-center">
                        <svg class="w-20 h-20 mx-auto text-orange-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-orange-600 mb-2">HTTPS Required for Camera</h3>
                        <p class="text-gray-700 text-sm mb-4">Chrome requires a secure HTTPS connection to access the camera.</p>
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-4">
                            <div class="text-left text-xs space-y-2">
                                <div class="font-bold text-orange-800">🔒 Current Issue:</div>
                                <div class="text-orange-700">
                                    You're accessing via <strong>HTTP</strong> (${window.location.protocol}//${window.location.host})<br>
                                    Chrome blocks camera access on non-secure connections
                                </div>
                                <div class="font-bold text-orange-800 mt-3">✅ Solutions:</div>
                                <div class="text-orange-700">
                                    <strong>Option 1 (Recommended):</strong><br>
                                    • Access via HTTPS if available<br>
                                    <strong>Option 2 (Desktop Chrome):</strong><br>
                                    • Go to chrome://settings/content/camera<br>
                                    • Add your site to "Allow" list<br>
                                    <strong>Option 3 (Development):</strong><br>
                                    • Use --unsafely-treat-insecure-origin-as-secure flag<br>
                                    • Or test on localhost/127.0.0.1
                                </div>
                            </div>
                        </div>
                        <button onclick="forceEnableCamera()" class="mt-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 text-sm">
                            Try Anyway
                        </button>
                        <p class="text-gray-500 text-xs mt-4">Use manual QR code entry below as alternative.</p>
                    </div>
                `;
            } else {
                // Show general compatibility message
                document.getElementById('reader').innerHTML = `
                    <div class="p-6 text-center">
                        <svg class="w-20 h-20 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-red-600 mb-2">Camera API Not Available</h3>
                        <p class="text-gray-700 text-sm mb-4">Unable to access camera API in this browser context.</p>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                            <div class="text-left text-xs space-y-2">
                                <div class="font-bold text-yellow-800">🔧 Try:</div>
                                <div class="text-yellow-700">
                                    • Refresh the page<br>
                                    • Check if camera is used by another app<br>
                                    • Try a different browser (Chrome/Safari)<br>
                                    • Check browser camera permissions
                                </div>
                                <div class="font-bold text-yellow-800 mt-3">🛠️ Debug Info:</div>
                                <div class="text-yellow-700 text-xs font-mono bg-yellow-100 p-2 rounded mt-1">
                                    Protocol: ${window.location.protocol}<br>
                                    Camera API: ${!!navigator.mediaDevices ? 'Available' : 'Missing'}<br>
                                    getUserMedia: ${!!navigator.mediaDevices?.getUserMedia ? 'Available' : 'Missing'}
                                </div>
                            </div>
                        </div>
                        <button onclick="startScanner()" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm">
                            Try Again
                        </button>
                        <p class="text-gray-500 text-xs mt-4">You can use manual QR code entry below if camera doesn't work.</p>
                    </div>
                `;
            }
        }

        async function forceEnableCamera() {
            try {
                // Try to force camera access even on HTTP
                document.getElementById('reader').innerHTML = `
                    <div class="p-8 text-center">
                        <div class="animate-spin w-8 h-8 mx-auto border-4 border-orange-500 border-t-transparent rounded-full mb-4"></div>
                        <p class="text-gray-600">Attempting camera access...</p>
                        <p class="text-xs text-gray-500">This may not work on HTTP</p>
                    </div>
                `;
                
                await startScanner();
            } catch (error) {
                console.error('Force enable failed:', error);
                showCameraError('Unable to enable camera on non-secure connection. Please try HTTPS or manual QR entry.');
            }
        }

        function showCameraError(message) {
            document.getElementById('reader').innerHTML = `
                <div class="p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-600 font-medium">${message}</p>
                    <button onclick="startScanner()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Try Again
                    </button>
                </div>
            `;
        }

        function showCameraSuccess() {
            // Add visual feedback below the camera view
            const statusDiv = document.getElementById('camera-status');
            if (statusDiv) {
                statusDiv.innerHTML = `
                    <div class="flex items-center justify-center">
                        <div class="flex items-center text-green-600 font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span id="current-camera">Camera Active - Point at QR code to scan</span>
                        </div>
                        <div class="ml-4 animate-pulse">
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                `;
                statusDiv.classList.remove('hidden');
            }
        }

        function showPermissionError() {
            document.getElementById('reader').innerHTML = `
                <div class="p-6 text-center">
                    <svg class="w-20 h-20 mx-auto text-orange-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-orange-600 mb-2">Camera Permission Required</h3>
                    <p class="text-gray-700 text-sm mb-4">To scan QR codes, please allow camera access:</p>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <div class="text-left text-xs space-y-2">
                            <div class="font-bold text-blue-800">📱 Mobile Browsers:</div>
                            <div class="text-blue-700">
                                • Tap the <strong>🔒</strong> lock icon in address bar<br>
                                • Select "Allow" for camera permission<br>
                                • Refresh page and try again
                            </div>
                            <div class="font-bold text-blue-800 mt-3">🌐 Or try:</div>
                            <div class="text-blue-700">
                                • Clear browser data & reload<br>
                                • Use a different browser (Chrome/Safari)<br>
                                • Check device camera settings
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 justify-center">
                        <button onclick="requestCameraPermission()" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 text-sm">
                            Request Permission
                        </button>
                        <button onclick="startScanner()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm">
                            Try Again
                        </button>
                    </div>
                </div>
            `;
        }

        function showNoCameraError() {
            document.getElementById('reader').innerHTML = `
                <div class="p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-600 mb-2">No Camera Found</h3>
                    <p class="text-gray-600 text-sm mb-4">No camera devices were detected on this device.</p>
                    <p class="text-gray-500 text-xs">Please use manual QR code entry below.</p>
                </div>
            `;
        }

        async function requestCameraPermission() {
            try {
                console.log('Manually requesting camera permission...');
                console.log('Browser check - MediaDevices:', !!navigator.mediaDevices);
                console.log('Browser check - getUserMedia:', !!navigator.mediaDevices?.getUserMedia);
                
                document.getElementById('reader').innerHTML = `
                    <div class="p-8 text-center">
                        <div class="animate-spin w-8 h-8 mx-auto border-4 border-blue-500 border-t-transparent rounded-full mb-4"></div>
                        <p class="text-gray-600">Requesting camera permission...</p>
                    </div>
                `;
                
                // Simplified browser support check - just try to use it
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    console.warn('Modern camera API not available, showing debug info');
                    showBrowserNotSupported();
                    return;
                }
                
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: "environment",
                        width: { ideal: 640 },
                        height: { ideal: 480 }
                    } 
                });
                
                console.log('Permission granted, stopping test stream...');
                stream.getTracks().forEach(track => track.stop());
                
                console.log('Permission granted, starting scanner...');
                // Now try to start the scanner
                await startScanner();
                
            } catch (error) {
                console.error('Permission request failed:', error);
                if (error.name === 'NotAllowedError') {
                    showPermissionError();
                } else if (error.name === 'NotFoundError') {
                    showNoCameraError();
                } else {
                    showCameraError(`Camera error: ${error.message}. Check browser console for details.`);
                }
            }
        }

        // Handle page visibility change to manage camera resources
        document.addEventListener('visibilitychange', function() {
            if (document.hidden && isScanning) {
                // Page is hidden, stop scanner to free camera
                stopScanner();
            } else if (!document.hidden && !isScanning) {
                // Page is visible again, restart scanner
                setTimeout(() => {
                    startScanner();
                }, 500);
            }
        });
    </script>
</body>
</html>
