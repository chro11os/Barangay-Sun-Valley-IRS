<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resident Dashboard</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.jsx')

    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
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


        <!-- Display incidents -->
        <div class="overflow-x-auto">
            <div class="container mx-auto mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-3xl font-bold text-center text-white bg-gray-800 px-4 py-2 rounded-lg">
                        Your Reports
                    </h1>
                </div>
    <table id="incident-table" class="min-w-full bg-white shadow-md rounded border border-gray-300">
        <thead>
            <tr class="bg-gray-800 text-yellow-100">
                <th class="px-4 py-2 border border-gray-700">Tracking #</th>
                <th class="px-4 py-2 border border-gray-700">Method</th>
                <th class="px-4 py-2 border border-gray-700">Incident Type</th>
                <th class="px-4 py-2 border border-gray-700">Date Reported</th>
                <th class="px-4 py-2 border border-gray-700">Reporter</th>
                <th class="px-4 py-2 border border-gray-700">Reported</th>
                <th class="px-4 py-2 border border-gray-700">Incident Details</th>
                <th class="px-4 py-2 border border-gray-700">Status</th>
                <th class="px-4 py-2 border border-gray-700">Description</th>
            </tr>
        </thead>
    <tbody>
        @forelse($incidents as $incident)
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 border border-gray-600">{{ $incident->update_id ?? 'N/A' }}</td>
                <td class="px-4 py-2 border border-gray-600">{{ $incident->reporter->method->methodType ?? 'N/A' }}</td>
                <td class="px-4 py-2 border border-gray-600">{{ $incident->incidentType->incidentType ?? 'N/A' }}</td>
                <td class="px-4 py-2 border border-gray-600">{{ $incident->date_reported }}</td>
                <td class="px-4 py-2 border border-gray-600">{{ $incident->reporter->incident_reporter_name ?? 'N/A' }}</td>
                <td class="px-4 py-2 border border-gray-600">{{ $incident->reporter->incident_suspect_name ?? 'N/A' }}</td>
                <td class="px-4 py-2 border border-gray-600">{{ $incident->description }}</td>
                <td class="px-4 py-2 border border-gray-600">{{ $incident->incidentUpdate->status->status ?? 'N/A' }}</td>
                <td class="px-4 py-2 border border-gray-600">{{ $incident->incidentUpdate->details ?? 'N/A'}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="px-4 py-2 text-center text-black-100">No incident reports found.</td>
            </tr>
        @endforelse
    </tbody>
    </table>
</div>

</body>
</html>