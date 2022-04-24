<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class EmployeeEmailAddress extends Model
{
    use HasFactory;
    protected $fillable = ['businessEmail', 'alternateEmail'];
    protected $table = 'employee_email_address';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
