<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>

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
            <a href="{{ route('adminDashboard') }}" class="nav-link text-white px-3 py-2 rounded-md text-sm font-small">Admin Dash</a>
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

 
    <div class="container mx-auto mt-8">
        <div class="flex justify-end mb-4">
        <!-- @if(auth()->check() && auth()->user()->role_id >= 1 && auth()->user()->role_id <= 2)
            <button class="bg-green-600 hover:bg-green-900 text-yellow-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Add New Report
            </button>
        @else   
            <button class="bg-green-600 hover:bg-green-900 text-yellow-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" disabled style="visibility: hidden;">
                Add New Report
            </button>
        @endif -->
        </div>
        <div id="app"></div>
    </div>



</body>
</html>
