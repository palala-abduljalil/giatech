<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Income extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'income';
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('project')
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        if ($eventName == 'created' || $eventName == 'deleted') {
            $activity->description = "Has {$eventName} a Income" ;
        } else {
            $activity->description = "Has {$eventName} a Income's details" ;
        }
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function createdBy() {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function category() {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

    // public function setCreatedAtAttribute() {
    //     return $this->attribute['created_at'] = Carbon::parse($this->attribute['created_at'])->format('m-d-Y H:i:s');
    // }
}
