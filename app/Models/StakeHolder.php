<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Employee;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StakeHolder extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'stakeholder';
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('stakeholder')
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        if ($eventName == 'deleted') {
            $activity->description = "Has {$eventName} a stakeholder in Content Management";
        }
        else {
            $employee = StakeHolder::find($activity->subject_id)->employee->employeeNumber;
            if ($eventName == 'created') {
                $activity->description = "Has {$eventName} a stakeholder in Content Management 
                with an employee number - {$employee}" ;
            }
            else if ($eventName == 'updated') {
                $activity->description = "Has {$eventName} a stakeholder's details in Content Management 
                with an employee number - ${employee}";
            }
        }
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
