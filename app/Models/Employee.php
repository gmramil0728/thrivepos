<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function advance(){
        return $this->belongsTo(AdvanceSalary::class,'id','employee_id');
    }

    /**
     * Get the attendance records for the employee.
     */
    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'employee_id', 'id');
    }
}
