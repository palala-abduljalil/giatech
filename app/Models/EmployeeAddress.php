<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAddress extends Model
{
    use HasFactory;
    
    protected $table = 'employee_address';
    protected $fillable = [
        'employee_id', 
        'houseNumber',
        'streetName',
        'barangay',
        'city',
        'province',
        'region'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getFullAddressAttribute() {
        return $this->attributes['streetName']. ', '.$this->attributes['barangay'].', '.$this->attributes['city'].', '.$this->attributes['province'].', '.$this->attributes['region'];
    }
}
