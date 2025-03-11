<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Incident extends Model
{

    protected $table = 'incidents';
    protected $primaryKey = 'incident_id';

    protected $fillable = [
        'user_id',
        'incident_type',
        'description',
        'date_reported',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}