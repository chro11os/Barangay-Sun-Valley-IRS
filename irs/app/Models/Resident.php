<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $table = 'residents'; // Ensure it matches your table name

    protected $primaryKey = 'id'; // The primary key column

    public $timestamps = true; // Enable timestamps since you have `created_at` & `updated_at`

    protected $fillable = [
        'name',
        'address',
        'birthday',
        'phone_number',
    ];
}
