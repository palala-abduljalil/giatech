<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ExpenseTransportation extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'expense_transportation';
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('expense_transportation')
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        if ($eventName == 'created' || $eventName == 'deleted') {
            $activity->description = "Has {$eventName} a Expense Transportation" ;
        } else {
            $activity->description = "Has {$eventName} a Expense Transportation's details" ;
        }
    }

    public function createdBy() {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
