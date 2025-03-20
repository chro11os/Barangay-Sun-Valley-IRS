<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Incident Report</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.jsx')
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-image: url('/img/background.png');
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(10px);
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transition: background-color 0.3s ease;
        }

        .btn {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .acrylic {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-fixed pt-16">
    <nav class="bg-gray-800 shadow-md p-4 fixed top-0 left-0 w-full z-50 acrylic">
        <div class="flex items-center justify-between">
            <img src="/img/sun-valley-logo.jpg" alt="Sun Valley Logo" class="rounded-full h-10 w-10 ml-4">
            <p class="text-sm p-2 font-bold text-white">Sun Valley IRS</p>

            <div class="flex-1 text-center">
                @if(Auth::check() && Auth::user()->role_id != 0)
                    <a href="{{ route('adminDashboard') }}" class="nav-link text-white px-3 py-2 rounded-md text-sm font-small">Admin Dash</a>
                @else
                    <a href="{{ route('adminDashboard') }}" class="nav-link text-white px-3 py-2 rounded-md text-sm font-small" disabled style="visibility:hidden;">Admin Dash</a>
                @endif
                <a href="{{ route('report') }}" class="nav-link text-white px-3 py-2 rounded-md text-md font-small">Home</a>
                <a href="{{ route('track') }}" class="nav-link text-white px-3 py-2 rounded-md text-md font-small">Reports</a>
                <a href="{{ route('about') }}" class="nav-link text-white px-3 py-2 rounded-md text-md font-small">Contact</a>
            </div>

            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="btn text-white px-3 py-2 rounded-md text-lg font-medium">Login</a>
                    <a href="{{ route('register') }}" class="btn text-white px-3 py-2 rounded-md text-lg font-medium">Register</a>
                @else
                <div class="relative">
                    <button onclick="toggleDropdown()" class="text-white px-3 py-2 rounded-md text-sm font-small hover:bg-gray-700 focus:outline-none">
                        {{ Auth::user()->name }}
                    </button>

                    <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-gray-800 text-white rounded shadow-lg opacity-0 scale-95 pointer-events-none transition-all duration-300">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-700">Logout</button>
                        </form>
                    </div>
                </div>
                @endguest
            </div>
        </div>
    </nav>

    <div class="container mx-auto py-10 px-6 max-w-4xl flex justify-center items-center h-screen fade-in">
        <div class="acrylic shadow-lg rounded-lg p-8 text-center text-white">
            <h1 class="text-3xl font-bold mb-6 text-blue-700">Track Your Incident Report</h1>

            <form id="trackReportForm" class="mb-6">
                <input type="text" id="incident_id" name="incident_id"
                    class="w-full p-3 border rounded-md bg-transparent text-gray-900 placeholder-gray-700" placeholder="Enter Incident Report ID" required>
                <button type="submit" class="mt-4 bg-blue-600 text-yellow-100 px-4 py-2 rounded-md hover:bg-blue-800 hover:text-gray-200">
                    Track Report
                </button>
            </form>

            <a href="{{ route('residentDashboard') }}" class="btn text-gray-900 px-3 py-2 rounded-md text-lg font-medium hover:bg-gray-700 hover:text-white">View Dashboard</a>

            <div id="reportResult" class="mt-6 hidden">
                <h2 class="text-xl font-semibold">Report Details</h2>
                <p id="status" class="text-lg mt-2"></p>
                <p id="details" class="text-lg mt-2"></p>
                <p id="date_reported" class="text-lg mt-2"></p>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            let dropdown = document.getElementById("dropdownMenu");
            dropdown.classList.toggle("opacity-100");
            dropdown.classList.toggle("scale-100");
            dropdown.classList.toggle("pointer-events-auto");
        }

        document.addEventListener("click", function(event) {
            let dropdown = document.getElementById("dropdownMenu");
            let button = event.target.closest("button");
            if (!dropdown.contains(event.target) && button === null) {
                dropdown.classList.remove("opacity-100", "scale-100", "pointer-events-auto");
            }
        });

        document.getElementById('trackReportForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const incidentId = document.getElementById('incident_id').value;

            const url = `/track/search?incident_id=${encodeURIComponent(incidentId)}`;

            fetch(url, {
                headers: { 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('reportResult').classList.add('hidden');
                    alert(data.error);
                } else {
                    document.getElementById('reportResult').classList.remove('hidden');
                    document.getElementById('status').innerText = "Status: " + data.status;
                    document.getElementById('details').innerText = "Details: " + data.details;
                    document.getElementById('date_reported').innerText = "Date Reported: " + data.date_reported;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
