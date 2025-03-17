<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Incident extends Model
{
    use HasFactory;
    protected $table = 'incidents'; // Match database table name

    protected $primaryKey = 'incident_id'; // Match your primary key

    public $timestamps = false; 

    protected $fillable = [
        'incidentType_id', 'method', 'reporter_id', 
        'date_reported', 'location', 'address', 
        'description', 'attachments', 'update_id'
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function incidentType()
    {
        return $this->belongsTo(IncidentType::class, 'incidentType_id', 'incidentTypeID'); // Corrected
    }
    public function incidentUpdate()
    {
        return $this->hasOne(IncidentUpdate::class, 'id', 'update_id'); // Link to tracking table
    }

    public function reporter()
    {
        return $this->hasOne(ReportInfo::class, 'id', 'reporter_id'); // Link to tracking table
    }

}
