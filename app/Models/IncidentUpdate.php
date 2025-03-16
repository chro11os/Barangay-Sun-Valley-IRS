<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentUpdate extends Model
{
    use HasFactory;

    protected $table = 'incident_updates'; // Ensure correct table name
    protected $primaryKey = 'id'; // The tracking number is the primary key
    public $incrementing = false; // Because it's a VARCHAR, not an auto-incrementing ID
    protected $keyType = 'string';

    protected $fillable = ['incident_id', 'status_updateid', 'update_time', 'updated_by', 'details'];

    public function incident()
    {
        return $this->belongsTo(Incident::class, 'update_id', 'id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_updateid', 'status_update_id'); // Corrected foreign key
    }
}
 