<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    //
    use HasFactory;
    protected $table = 'status'; // Match database table name

    protected $primaryKey = 'status_update_id'; // Match your primary key

    protected $fillable = ['status', 'description'];

    public function incidentUpdates()
    {
        return $this->hasMany(IncidentUpdate::class, 'status_updateid', 'status_update_id'); // Corrected: foreignKey is now status_updateid
    }
}
