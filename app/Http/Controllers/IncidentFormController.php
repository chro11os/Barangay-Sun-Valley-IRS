<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            'reporter_last_name' => 'required|string|max:255',
            'reporter_first_name' => 'required|string|max:255',
            'reported_last_name' => 'nullable|string|max:255',
            'reported_first_name' => 'nullable|string|max:255',
            'resident_id' => 'nullable|exists:residents,id',
            'user_id' => 'nullable|exists:users,id',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|string',
            'incident_details' => 'required|string',
            'location' => 'required|string',
            'house_number' => 'nullable|string|max:255',
            'street_name' => 'nullable|string|max:255',
            'incident_date' => 'required|date_format:Y-m-d\TH:i',
            'attachments.*' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);
    
        // Concatenate Reporter Name
        $reporterName = trim("{$request->reporter_last_name}, {$request->reporter_first_name}");
    
        // Concatenate Reported Person's Name (if provided)
        $reportedName = $request->reported_last_name && $request->reported_first_name
            ? trim("{$request->reported_last_name}, {$request->reported_first_name}")
            : null;
    
        // Concatenate House Number and Street Name
        $fullAddress = trim("{$request->house_number} {$request->street_name}");
    
        // Store the reporter information
        $reporter = ReportInfo::create([
            'incident_reporter_name' => $reporterName,
            'incident_suspect_name' => $reportedName,
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
            'address' => $fullAddress,  // Use concatenated address
            'incidentType_id' => $request->incident_type,
            'location' => $request->location,
            'description' => $request->incident_details,
            'date_reported' => $request->incident_date,
            'attachment' => json_encode($attachments),
        ]);
    
        if (!$incident || !$incident->id) {
            return back()->withErrors('Failed to create incident.');
        }
    
        // Insert into `incident_updates`
        $incidentUpdate = IncidentUpdate::create([
            'incident_id' => $incident->id,
            'updated_by' => Auth::check() ? Auth::id() : null,
        ]);
    
        if (!$incidentUpdate || !$incidentUpdate->id) {
            return back()->withErrors('Failed to create incident update.');
        }
    
        return response()->json([
            'track_num' => $incident->update_id
        ]);
        
    }

    
    public function trackIncident(Request $request)
    {
        Log::info('Session Data:', session()->all());
        Log::info('Request Data:', $request->all());
        $request->validate([
            'incident_id' => 'required|string'
        ]);
    
        // Find the incident update using the tracking number
        $incidentUpdate = IncidentUpdate::where('id', $request->incident_id)
                                        ->with('status') // Eager load status
                                        ->first();
    
        if (!$incidentUpdate) {
            return response()->json(['error' => 'Tracking number not found'], 404);
        }
    
        // Find the related incident using the correct key (incident ID)
        $incident = Incident::where('incident_id', $incidentUpdate->incident_id)->first();
    
        if (!$incident) {
            return response()->json([
                'status' => $incidentUpdate->status->status ?? 'No updates available', 
                'details' => 'Incident record not found',
                'date_reported' => 'Unknown date'
            ]);
        } 
    
        return response()->json([
            'status' => $incidentUpdate->status->status ?? 'No updates available', 
            'details' => $incidentUpdate->details ?? 'No details available',
            'date_reported' => $incident->date_reported ?? 'Unknown date'
        ]);
    } 
 
    public function getUserIncidents()
    {
        $userId = Auth::id();
    
        $incidents = Incident::with([
            'IncidentUpdate:id,details,status_updateid',
            'IncidentUpdate.Status:status_update_id,status',
            'incidentType:incidentTypeID,incidentType',
            'reporter:id,incident_reporter_name,phone_number,user_id,incident_suspect_name,method_id',
            'reporter.method:methodID,methodType'
        ])
        ->whereHas('reporter', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->orderBy('date_reported', 'desc')
        ->get();
    
        return view('residentDashboard', compact('incidents'));
    }

    
    

     
    
    
}
