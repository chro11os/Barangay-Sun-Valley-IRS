<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sun-Valley Incident Report System</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.jsx')

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
<nav class="bg-gray-800 shadow-md p-4 sticky top-0 z-50">
    <div class="flex items-center justify-between">
        <img src="/img/sun-valley-logo.jpg" alt="Sun Valley Logo" class="rounded-full h-10 w-10 ml-4">
        <p class="text-sm color white p-2 font-bold text-white">Sun Valley IRS</p>

        <div class="flex-1 text-center">
            @if(Auth::check() && Auth::user()->role_id != 0)
                <a href="{{ route('adminDashboard') }}" class="nav-link text-white px-3 py-2 rounded-md text-sm font-small">Admin Dash</a>
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

    <div class="bg-green-700 shadow-md shadow-green-950 rounded-lg p-8 text-center w-full md:w-3/4 lg:w-1/2">
        <h1 class="text-4xl font-bold mb-4 text-yellow-500">Sun-Valley Incident Report System</h1>
        @if(Auth::check())
            <button id="reportButton"
                    class="btn bg-green-700 hover:bg-green-900 text-yellow-100 font-bold py-3 px-6 rounded-full shadow-lg shadow-green-950 transition duration-300 ease-in-out transform hover:scale-105">
                Report an Incident
            </button>
        @else
            <a href="{{ route('login') }}"
            class="btn bg-red-600 hover:bg-red-800 text-white font-bold py-3 px-6 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                Login to Report
            </a>
        @endif 

        <div id="reportForm" class="hidden mt-8">
            <form id="incidentForm" action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="method" class="block text-yellow-500 text-sm font-bold mb-2">Method:</label>
                        @if(isset($methods) && $methods->count())
                            <select id="method" name="method_id">
                                @foreach ($methods as $method)
                                    <option value="{{ $method->methodID }}">{{ $method->methodType }}</option>
                                @endforeach
                            </select>
                        @else
                            <p>No methods found.</p>
                        @endif
                    </div>
                    <div>
                        <label for="incident_type" class="block text-yellow-500 text-sm font-bold mb-2">Incident Type:</label>
                        @if(isset($incidentTypes) && $incidentTypes->count())
                        <select name="incident_type">
                            @foreach ($incidentTypes as $type)
                                <option value="{{ $type->incidentTypeID }}">{{ $type->incidentType }}</option>
                            @endforeach
                        </select>
                        @else
                            <p>No incident types found.</p>
                        @endif
                    </div>

                    <div>
                        <label for="reporter_name" class="block text-yellow-500 text-sm font-bold mb-2">Name of
                            Reporter (Required):</label>
                        <input type="text" id="reporter_name" name="reporter_name" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-yellow-500 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="reported_name" class="block text-yellow-500 text-sm font-bold mb-2">Reported Name (Optional):</label>
                        <input type="text" id="reported_name" name="reported_name"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-yellow-500 leading-tight focus:outline-none focus:shadow-outline" placeholder ="Name of the one being Reported">
                    </div>

                    <div>
                        <label for="incident_date" class="block text-yellow-500 text-sm font-bold mb-2">Date Reported:</label>
                        <input type="datetime-local" id="incident_date" name="incident_date"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-yellow-500 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="location" class="block text-yellow-500 text-sm font-bold mb-2">Location:</label>
                        @if(isset($locations) && count($locations) > 0)
                            <select id="location" name="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach ($locations as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                @endforeach
                            </select>
                        @else
                            <p>No locations found.</p>
                        @endif
                    </div>
                    <!-- Yellow -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-yellow-500 text-sm font-bold mb-2">Reported Address:</label>
                        <input type="text" id="address" name="address"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-yellow-500 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Enter the address that you are reporting">
                    </div>

                    <div>
                        <label for="email" class="block text-yellow-500 text-sm font-bold mb-2">Email:</label>
                        <input type="email" id="email" name="email"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-yellow-500 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="phone_number" class="block text-yellow-500 text-sm font-bold mb-2">Phone
                            Number:</label>
                        <input type="tel" id="phone_number" name="phone_number"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-yellow-500 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="md:col-span-2">
                        <label for="incident_details" class="block text-yellow-500 text-sm font-bold mb-2">Incident
                            Details:</label>
                        <textarea id="incident_details" name="incident_details" rows="4"
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-yellow-500 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="attachments" class="block text-yellow-500 text-sm font-bold mb-2">Upload
                            Attachments:</label>
                        <input type="file" id="attachments" name="attachments[]" multiple
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-yellow-500 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <button id="submitButton"
                            class="bg-green-600 hover:bg-green-900 text-yellow-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                        Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
 
    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif

<script>
    document.getElementById('reportButton').addEventListener('click', function () {
        document.getElementById('reportForm').classList.remove('hidden');
        this.classList.add('hidden'); // Hide the button after clicking
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
