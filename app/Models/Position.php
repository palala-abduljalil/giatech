<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Position extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'position';
    protected $fillable = ['name'];

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('position')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        if ($eventName == 'created' || $eventName == 'deleted') {
            $activity->description = "Has {$eventName} a Position" ;
        } else {
            $activity->description = "Has {$eventName} a Position's details" ;
        }
    }
}
