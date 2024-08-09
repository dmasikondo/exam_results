<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    /**
     * To determine if a staff member belongs to a named department
     *
     * @param [string] $departmentName
     * @return void
     */
    public function belongsToDepartment($departmentName)
    {
        return $this->department->name === $departmentName;
    }
}
