<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Incident Report</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.jsx')
</head>

<body class="bg-cover bg-center bg-fixed" style="background-image: url('/img/background.png');">
<nav class="bg-gray-800 shadow-md p-4">
    <div class="flex items-center justify-between">
        <img src="/img/sun-valley-logo.jpg" alt="Sun Valley Logo" class="rounded-full h-10 w-10 ml-4">
        <div class="flex-1 text-center">
            <a href="{{ route('report') }}" class="nav-link text-white px-3 py-2 rounded-md text-lg font-medium">Home</a>
            <a href="{{ route('') }}"
            <a href="{{ route('track') }}" class="nav-link text-white px-3 py-2 rounded-md text-lg font-medium">Reports</a>
            <a href="{{ route('about') }}" class="nav-link text-white px-3 py-2 rounded-md text-lg font-medium">Contact</a>
        </div>
    <div class="flex items-center">
            <a href="{{ route('login') }}" class="btn text-white px-3 py-2 rounded-md text-lg font-medium hover:bg-gray-700">Login</a>
            <a href="{{ route('register') }}" class="btn text-white px-3 py-2 rounded-md text-lg font-medium hover:bg-gray-700">Register</a>
        </div>
    </div>
</nav>
<div class="container mx-auto py-10 px-6 max-w-4xl flex justify-center items-center h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 text-center">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Track Your Incident Report</h1>

        <form id="trackReportForm" class="mb-6">
            <input type="text" id="incident_id" name="incident_id"
                   class="w-full p-3 border rounded-md" placeholder="Enter Incident Report ID" required>
            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Track Report
            </button>
        </form>

        <div id="reportResult" class="mt-6 hidden">
            <h2 class="text-xl font-semibold">Report Details</h2>
            <p id="status" class="text-lg mt-2"></p>
            <p id="details" class="text-lg mt-2"></p>
            <p id="date_reported" class="text-lg mt-2"></p>
        </div>
    </div>
</div>
<script>
document.getElementById('trackReportForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const incidentId = document.getElementById('incident_id').value;

    console.log("Tracking number entered:", incidentId);

    // Construct the URL using the route name
    const url = `/track/search?incident_id=${encodeURIComponent(incidentId)}`;

    fetch(url, {
        headers: { 'Accept': 'application/json' }
    })
    .then(response => {
        console.log("Response received:", response);
        return response.json();
    })
    .then(data => {
        console.log("Data received:", data);
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
