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
<body class="bg-gray-100">
<nav class="bg-gray-800 shadow-md p-4">
    <div class="flex items-center justify-between">
        <img src="/img/sun-valley-logo.jpg" alt="Sun Valley Logo" class="rounded-full h-10 w-10 ml-4">
        <div class="flex-1 text-center">
            <a href="{{ route('report') }}" class="nav-link text-white px-3 py-2 rounded-md text-lg font-medium">Home</a>
            <a href="{{ route('track') }}" class="nav-link text-white px-3 py-2 rounded-md text-lg font-medium">Reports</a>
            <a href="{{ route('about') }}" class="nav-link text-white px-3 py-2 rounded-md text-lg font-medium">Contact</a>
        </div>
    <div class="flex items-center">
            <a href="{{ route('login') }}" class="btn text-white px-3 py-2 rounded-md text-lg font-medium hover:bg-gray-700">Login</a>
            <a href="{{ route('register') }}" class="btn text-white px-3 py-2 rounded-md text-lg font-medium hover:bg-gray-700">Register</a>
        </div>
    </div>
</nav>
<div class="container mx-auto p-7 flex justify-center items-center h-screen">
    <div class="bg-white shadow-md rounded-lg p-8 text-center w-full md:w-3/4 lg:w-1/2">
        <h1 class="text-4xl font-bold mb-4 text-gray-800">Sun-Valley Incident Report System</h1>
        <p class="text-gray-600 mb-6 text-lg">Report incidents promptly and efficiently.</p>
        <button id="reportButton"
                class="btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
            Report an Incident
        </button>

        <div id="reportForm" class="hidden mt-8">
            <form id="incidentForm" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="method" class="block text-gray-700 text-sm font-bold mb-2">Method:</label>
                        <select id="method" name="method"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="SMS">SMS</option>
                            <option value="Walk-in">Walk-in</option>
                            <option value="Website">Website</option>
                        </select>
                    </div>
                    <div>
                        <label for="incident_type" class="block text-gray-700 text-sm font-bold mb-2">Incident
                            Type:</label>
                        <select id="incident_type" name="incident_type"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="Theft">Theft</option>
                            <option value="Assault">Assault</option>
                            <option value="Vandalism">Vandalism</option>
                            <!-- Add more incident types as needed -->
                        </select>
                    </div>

                    <div>
                        <label for="reporter_name" class="block text-gray-700 text-sm font-bold mb-2">Name of
                            Reporter (Required):</label>
                        <input type="text" id="reporter_name" name="reporter_name" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="reported_name" class="block text-gray-700 text-sm font-bold mb-2">Reported Name (Optional):</label>
                        <input type="text" id="reported_name" name="reported_name"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder ="Name of the one being Reported">
                    </div>

                    <div>
                        <label for="incident_date" class="block text-gray-700 text-sm font-bold mb-2">Date Reported:</label>
                        <input type="date" id="incident_date" name="incident_date"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Location:</label>
                        <select id="location" name="location"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @php
                                $locationFile = base_path('resources/views/locations.txt');
                                $locations = file($locationFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                            @endphp
                            @foreach ($locations as $location)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="email" id="email" name="email"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Phone
                            Number:</label>
                        <input type="tel" id="phone_number" name="phone_number"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="md:col-span-2">
                        <label for="incident_details" class="block text-gray-700 text-sm font-bold mb-2">Incident
                            Details:</label>
                        <textarea id="incident_details" name="incident_details" rows="4"
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="attachments" class="block text-gray-700 text-sm font-bold mb-2">Upload
                            Attachments:</label>
                        <input type="file" id="attachments" name="attachments[]" multiple
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <button id="submitButton"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                        Submit Report
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