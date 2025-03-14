<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Barangay Sun Valley</title>

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
<body class="bg-cover bg-center bg-fixed" style="background-image: url('/img/backgound.png');">

<!-- Navigation Bar -->
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

<!-- About Section -->
<div class="container mx-auto py-10 px-6">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-6xl mx-auto text-center">
        <h1 class="text-4xl font-bold mb-6 text-gray-800">About Barangay Sun Valley</h1>
        <img src="/img/sun-valley-logo.jpg" alt="Sun Valley Logo" class="rounded-full h-32 w-32 mb-6 shadow-lg block mx-auto">
        <p class="text-gray-700 text-lg leading-relaxed">
            Barangay Sun Valley is a vibrant community located in Parañaque City, Philippines. Dedicated to providing excellent service to its residents, Barangay Sun Valley strives to create a safe, healthy, and prosperous environment for all.
        </p>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-8 max-w-6xl mx-auto">
    <div class="flex flex-col lg:flex-row gap-10">
        <!-- Left: Contact Information -->
        <div class="lg:w-1/2">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800 text-center">Important Contact Information</h2>
            <p class="text-gray-700 text-lg mb-4 text-center">For emergencies and community concerns, reach out to these hotlines:</p>
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <ul class="space-y-3 text-gray-800 text-lg">
                    <li><strong>Police SS7:</strong> 8875 7725 / 0931 880 0795</li>
                    <li><strong>POPSMO-TANOD:</strong> 8551 9599 / 0951 961 7047</li>
                    <li><strong>Emergency/Rescue:</strong> 8824 7493 / 0961 743 1376 / 0977 723 8175</li>
                    <li><strong>Mega Health Center:</strong> 8252 9813</li>
                    <li><strong>Social Services:</strong> 8551 9599</li>
                    <li><strong>Barangay Secretary:</strong> 8823 0230</li>
                    <li><strong>Treasury Department:</strong> 8821 4143</li>
                </ul>
            </div>
        </div>

        <!-- Right: Google Maps -->
        <div class="lg:w-1/2 text-center">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Our Location</h2>
            <div class="rounded-lg overflow-hidden shadow-lg">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d482.8660523891495!2d121.03218602547796!3d14.488798573107628!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397cefd48a2611d%3A0x573c320977ed0c2c!2sBarangay%20Sun%20Valley%20Administration%20Bldg.!5e0!3m2!1sen!2sph!4v1741767791220!5m2!1sen!2sph" 
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

    <!-- Move the tagline outside the flex container -->
    <div class="text-center mt-6">
        <p class="text-gray-700 text-lg font-semibold">
            "Serbisyong Tapat Para Sa Lahat!" - Serving with integrity for all.
        </p>
    </div>
</div>


</body>
</html>