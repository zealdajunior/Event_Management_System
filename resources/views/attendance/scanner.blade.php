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
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded-xl hover:bg-gray-600">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Scanner Section -->
            <div class="bg-white rounded-3xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Camera Scanner</h2>
                
                <!-- QR Reader -->
                <div id="reader" class="rounded-xl overflow-hidden border-4 border-blue-500 mb-4"></div>
                
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
            html5QrcodeScanner.pause();
            
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
                    if (html5QrcodeScanner) {
                        html5QrcodeScanner.resume();
                    }
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Failed to process check-in');
                
                // Resume scanning
                setTimeout(() => {
                    if (html5QrcodeScanner) {
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
            
            html5QrcodeScanner.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },
                onScanSuccess
            ).catch(err => {
                console.error('Unable to start scanner:', err);
                document.getElementById('reader').innerHTML = `
                    <div class="p-8 text-center">
                        <p class="text-red-600">Camera access denied or unavailable</p>
                        <p class="text-gray-600 mt-2">Please use manual QR code entry below</p>
                    </div>
                `;
            });
        });
    </script>
</body>
</html>
