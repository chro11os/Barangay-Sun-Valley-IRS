<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IncidentType;
use App\Models\Incident;
use App\Models\Method;
use App\Models\ReportInfo;
use App\Models\IncidentUpdate;


class IncidentFormController extends Controller
{
    /**
     * Show the incident report form.
     */
    public function create()
    {
        $incidentTypes = IncidentType::all();
        $locationFile = base_path('resources/views/locations.txt');
        $locations = file_exists($locationFile) ? file($locationFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
        $methods = Method::all();
    
        return view('app', compact('incidentTypes', 'locations', 'methods'));
    }
    /**
     * Store the submitted incident report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'incident_type' => 'required|exists:incident_type,incidentTypeID',
            'method_id' => 'required|exists:method,methodID', 
            'reporter_name' => 'required|string|max:255',
            'reported_name' => 'nullable|string|max:255',
            'resident_id' => 'nullable|exists:residents,id',
            'user_id' => 'nullable|exists:users,id',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|string',
            'incident_details' => 'required|string',
            'location' => 'required|string',
            'address' => 'nullable|string',
            'incident_date' => 'required|date_format:Y-m-d\TH:i',
            'attachments.*' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);
    
        // Store the reporter information
        $reporter = ReportInfo::create([
            'incident_reporter_name' => $request->reporter_name,
            'incident_suspect_name' => $request->reported_name ?? null,
            'method_id' => $request->method_id,
            'resident_id' => $request->resident_id ?? null,
            'user_id' => Auth::check() ? Auth::id() : null,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);
    
        if (!$reporter || !$reporter->id) {
            return back()->withErrors('Failed to create reporter info.');
        }
    
        // Process file uploads
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachments[] = $file->store('incident_reports', 'public');
            }
        }
    
        // Create Incident
        $incident = Incident::create([
            'reporter_id' => $reporter->id,
            'address' =>$request->address,
            'incidentType_id' => $request->incident_type,
            'location' => $request->location,
            'description' => $request->incident_details,
            'date_reported' => $request->incident_date,
            'attachment' => json_encode($attachments),
        ]);
    
        if (!$incident || !$incident->id) {
            return back()->withErrors('Failed to create incident.');
        }
    
        // Insert into `incident_updates` (PostgreSQL automatically generates `id` and `status`)
        $incidentUpdate = IncidentUpdate::create([
            'incident_id' => $incident->id, // Linking to the incident
            'updated_by' => Auth::check() ? Auth::id() : null, // Pass the logged-in user's ID
        ]);
    
        if (!$incidentUpdate || !$incidentUpdate->id) {
            return back()->withErrors('Failed to create incident update.');
        }
    
        // Redirect user to tracking page
        return redirect()->route('report') // Assuming 'report' is the route for your app.blade.php
                 ->with('success', 'Thank you for submitting! Here is your tracking number: ' . $incidentUpdate->id);
    }
    
    
    
}
