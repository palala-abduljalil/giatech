<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class EmployeeStatus extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'employee_status';
    protected $guarded = [];
    public $timestamps = false;

    public function employees() {
        return $this->hasMany(Employee::class, 'status_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('employee_status')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        if ($eventName == 'created' || $eventName == 'deleted') {
            $activity->description = "Has {$eventName} a Employee Status" ;
        } else {
            $activity->description = "Has {$eventName} a Employee Status's details" ;
        }
    }
}
