<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeContactNumber extends Model
{
    use HasFactory;

    protected $table = 'employee_contact_number';
    protected $fillable = ['employee_id', 'contactNumber'];

    public function employee() {
        $this->belongsTo(Employee::class);
    }
}
