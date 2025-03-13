<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentType extends Model
{
    //
    use HasFactory;
    protected $table = 'incident_type'; // Match database table name

    protected $primaryKey = 'incidentTypeId'; // Match your primary key

    protected $fillable = ['incidentType', 'description'];
}
