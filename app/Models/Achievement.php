<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Achievement extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'employee_achievement';
    protected $fillable = ['employee_id', 'description'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('expense')
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        if ($eventName == 'created' || $eventName == 'deleted') {
            $activity->description = "Has {$eventName} an Employee Achievement" ;
        } else {
            $activity->description = "Has {$eventName} an Employee's Achievement details" ;
        }
    }

    public function employee() {
        $this->belongsTo(Employee::class);
    }
}
