<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Skill extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'employee_skill';
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
            $activity->description = "Has {$eventName} an Emploeyee Skill" ;
        } else {
            $activity->description = "Has {$eventName} an Emploeyee's Skill details" ;
        }
    }

    public function employee() {
        $this->belongsTo(Employee::class);
    }
}
