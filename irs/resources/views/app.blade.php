<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #2d3748;
        }
    </style>
</head>

<body class="bg-gray-100">
    <nav class="bg-gray-800 shadow-md p-4">
        <div class="flex items-center justify-between">
            <img src="/img/sun-valley-logo.jpg" alt="Sun Valley Logo" class="rounded-full h-10 w-10 ml-4">
            <div class="flex-1 text-center">
                <a href="#app.blade.php" class="nav-link text-white px-3 py-2 rounded-md text-lg font-medium">Home</a>
                <a href="#" class="nav-link text-white px-3 py-2 rounded-md text-lg font-medium">Reports</a>
                <a href="#" class="nav-link text-white px-3 py-2 rounded-md text-lg font-medium">Contact</a>
            </div>
            <div class="flex items-center">
                <a href="{{ route('login') }}" class="btn text-white px-3 py-2 rounded-md text-lg font-medium">Login</a>
                <a href="{{ route('register') }}" class="btn text-white px-3 py-2 rounded-md text-lg font-medium">Register</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-7">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-4xl font-bold mb-4 text-gray-800">Sun-Valley Incident Report System</h1>
            <p class="text-gray-600 mb-6">Report incidents promptly and efficiently.</p>
            <button class="btn bg-blue-500 text-white px-4 py-2 rounded-md">Report an Incident</button>
            
        </div>
    </div>
</body>

</html>