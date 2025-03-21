<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sun-Valley Incident Report System</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.jsx')
    <!-- Thank Axel d great For he is the one who made this spaghetti of a code - neil -->
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        .nav-link:hover {
            background-color: #4a5568;
        }

        .btn {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #2d3748;
            transform: translateY(-2px);
        }
    </style>

</head>
<body class="bg-cover bg-center bg-fixed" style="background-image: url('/img/background.png');">

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- jQuery (Required for Toastr) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<nav class="bg-gray-800 shadow-md p-4 sticky top-0 z-50">
    <div class="flex items-center justify-between">
        <img src="/img/sun-valley-logo.jpg" alt="Sun Valley Logo" class="rounded-full h-10 w-10 ml-4">
        <p class="text-sm color white p-2 font-bold text-white">Sun Valley IRS</p>
        
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
                <a href="{{ route('login') }}" class="btn text-white px-3 py-2 rounded-md text-lg font-medium hover:bg-gray-700">Login</a>
                <a href="{{ route('register') }}" class="btn text-white px-3 py-2 rounded-md text-lg font-medium hover:bg-gray-700">Register</a>
            @else
                <!-- logout dropdown -->
            <div class="relative">
                <button onclick="toggleDropdown()" class="text-white px-3 py-2 rounded-md text-sm font-small hover:bg-gray-700 focus:outline-none">
                    {{ Auth::user()->name }}
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-gray-800 text-white rounded shadow-lg opacity-0 scale-95 pointer-events-none transition-all duration-300">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-700">Logout</button>
                    </form>
                </div>
            </div>

            <script>
                function toggleDropdown() {
                    let dropdown = document.getElementById("dropdownMenu");
                    dropdown.classList.toggle("opacity-100");
                    dropdown.classList.toggle("scale-100");
                    dropdown.classList.toggle("pointer-events-auto");
                }

                // Close dropdown when clicking outside
                document.addEventListener("click", function(event) {
                    let dropdown = document.getElementById("dropdownMenu");
                    let button = event.target.closest("button");
                    if (!dropdown.contains(event.target) && button === null) {
                        dropdown.classList.remove("opacity-100", "scale-100", "pointer-events-auto");
                    }
                });
            </script>
            <!-- Logout DropDown -->
            @endguest
        </div>
    </div>
</nav>

<div class="container mx-auto p-7 flex justify-center items-center h-screen">
    <div class="bg-white/30 shadow-lg rounded-lg p-8 text-center w-full md:w-3/4 lg:w-1/2 backdrop-blur-md border border-white/20">
        <h1 class="text-4xl font-extrabold mb-6 text-gray-800 drop-shadow-lg">Sun-Valley Incident Report System</h1>
        @if(Auth::check())
            <button id="reportButton"
                    class="btn bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-3 px-6 rounded-full shadow-md transition-transform duration-300 ease-in-out transform hover:scale-105">
                Report an Incident
            </button>
        @else
            <br>
            <a href="{{ route('login') }}"
               class="btn bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-full shadow-md transition-transform duration-300 ease-in-out transform hover:scale-105">
                Login to Report
            </a>
        @endif
        <div id="notification" class="fixed bottom-5 right-5 bg-green-500 text-white p-4 rounded shadow-lg hidden">
            <span id="notification-message"></span>
        </div>

        <div id="reportForm" class="hidden mt-8">
            <form id="incidentForm" action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center drop-shadow-md">Report an Incident</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Method -->
                    <div>
                        <label for="method" class="block text-gray-700 text-sm font-semibold mb-2">Method:</label>
                        @if(isset($methods) && $methods->count())
                            <select id="method" name="method_id" class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                @foreach ($methods as $method)
                                    <option value="{{ $method->methodID }}">{{ $method->methodType }}</option>
                                @endforeach
                            </select>
                        @else
                            <p class="text-red-500">No methods found.</p>
                        @endif
                    </div>

                    <!-- Incident Type -->
                    <div>
                        <label for="incident_type" class="block text-gray-700 text-sm font-semibold mb-2">Incident Type:</label>
                        @if(isset($incidentTypes) && $incidentTypes->count())
                            <select name="incident_type" class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                @foreach ($incidentTypes->sortBy('incidentType') as $type)
                                    <option value="{{ $type->incidentTypeID }}">{{ $type->incidentType }}</option>
                                @endforeach
                            </select>
                        @else
                            <p class="text-red-500">No incident types found.</p>
                        @endif
                    </div>

                    <!-- Reporter Name -->
                    <div>
                        <label for="reporter_last_name" class="block text-gray-700 text-sm font-semibold mb-2">Reporter Last Name (Required):</label>
                        <input type="text" id="reporter_last_name" name="reporter_last_name" required
                               class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="reporter_first_name" class="block text-gray-700 text-sm font-semibold mb-2">Reporter First Name (Required):</label>
                        <input type="text" id="reporter_first_name" name="reporter_first_name" required
                               class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Reported Person Name -->
                    <div>
                        <label for="reported_last_name" class="block text-gray-700 text-sm font-semibold mb-2">Reported Last Name (Optional):</label>
                        <input type="text" id="reported_last_name" name="reported_last_name"
                               class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500"
                               placeholder="Last Name of the one being reported">
                    </div>
                    <div>
                        <label for="reported_first_name" class="block text-gray-700 text-sm font-semibold mb-2">Reported First Name (Optional):</label>
                        <input type="text" id="reported_first_name" name="reported_first_name"
                               class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500"
                               placeholder="First Name of the one being reported">
                    </div>

                    <!-- Date and Location -->
                    <div>
                        <label for="incident_date" class="block text-gray-700 text-sm font-semibold mb-2">Date Reported:</label>
                        <input type="datetime-local" id="incident_date" name="incident_date"
                               class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="location" class="block text-gray-700 text-sm font-semibold mb-2">Subdivision:</label>
                        @if(isset($locations) && count($locations) > 0)
                            <select id="location" name="location"
                                    class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                @foreach ($locations as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                @endforeach
                            </select>
                        @else
                            <p class="text-red-500">No locations found.</p>
                        @endif
                    </div>

                    <!-- Address Fields -->
                    <div>
                        <label for="house_number" class="block text-gray-700 text-sm font-semibold mb-2">House Number:</label>
                        <input type="text" id="house_number" name="house_number"
                               class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500"
                               placeholder="Enter house number">
                    </div>
                    <div>
                        <label for="street_name" class="block text-gray-700 text-sm font-semibold mb-2">Street Name:</label>
                        <input type="text" id="street_name" name="street_name"
                               class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500"
                               placeholder="Enter street name">
                    </div>

                    <!-- Contact Details -->
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email:</label>
                        <input type="email" id="email" name="email"
                               class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="phone_number" class="block text-gray-700 text-sm font-semibold mb-2">Phone Number:</label>
                        <input type="tel" id="phone_number" name="phone_number"
                               class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Incident Details -->
                    <div class="md:col-span-2">
                        <label for="incident_details" class="block text-gray-700 text-sm font-semibold mb-2">Incident Details:</label>
                        <textarea id="incident_details" name="incident_details" rows="4"
                                  class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>

                    <!-- Upload Attachments -->
                    <div class="md:col-span-2">
                        <label for="attachments" class="block text-gray-700 text-sm font-semibold mb-2">Upload Attachments:</label>
                        <input type="file" id="attachments" name="attachments[]" multiple
                               class="shadow-md border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between mt-6">
                    <button class="bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-2 px-4 rounded-full shadow-md transition-transform duration-300 ease-in-out transform hover:scale-105" type="submit">
                        Submit Report
                    </button>
                    <button class="bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 text-white font-bold py-2 px-4 rounded-full shadow-md transition-transform duration-300 ease-in-out transform hover:scale-105" type="button" onclick="document.getElementById('reportForm').classList.add('hidden')">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.getElementById('reportButton').addEventListener('click', function () {
        document.getElementById('reportForm').classList.remove('hidden');
        this.classList.add('hidden'); // Hide the button after clicking
        //console.log(Auth::user()->id);
    });

    document.getElementById('closeButton').addEventListener('click', function () {
        document.getElementById('reportForm').classList.add('hidden');
        document.getElementById('reportButton').classList.remove('hidden'); // Show the button again
    });

    document.getElementById('incidentForm').addEventListener('submit', function (event) {
        const email = document.getElementById('email').value;
        const phoneNumber = document.getElementById('phone_number').value;

        if (!email && !phoneNumber) {
            alert('Please enter either an email address or a phone number.');
            event.preventDefault(); // Prevent form submission
        }

    });
</script>
</body>
</html>
