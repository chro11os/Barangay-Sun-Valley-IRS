<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    //
    use HasFactory;
    protected $table = 'method'; // Match database table name

    protected $primaryKey = 'methodID'; // Match your primary key

    protected $fillable = ['methodType', 'description'];
}
