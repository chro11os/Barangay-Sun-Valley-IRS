<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportInfo extends Model
{
    use HasFactory;

    protected $table = 'reporter_info'; // Ensure it matches the exact table name

    protected $primaryKey = 'id'; // Set primary key

    public $timestamps = false; // Disable timestamps if not using created_at & updated_at

    protected $fillable = [
        'incident_reporter_name',
        'incident_suspect_name',
        'method_id',
        'resident_id',
        'user_id',
        'email', 
        'phone_number'
    ];

    // Relationships

    public function method()
    {
        return $this->belongsTo(Method::class, 'method_id', 'methodID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'id');
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'ResidentID', 'id');
    }
}
