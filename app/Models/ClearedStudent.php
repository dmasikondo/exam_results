<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearedStudent extends Model
{
    use HasFactory;
    protected $fillable = [
        'national_id_name','intake_id','department','level',
    ];
}
