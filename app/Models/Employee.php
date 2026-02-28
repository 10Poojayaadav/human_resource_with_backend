<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'full_name',
        'email',
        'department'
    ];

  
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
