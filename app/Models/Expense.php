<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Expense extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $table = 'expense';
    protected $guarded = ['id'];

    public function createdBy() {
        return $this->belongsTo(Employee::class, 'created_by');
    }

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
            $activity->description = "Has {$eventName} an Expense" ;
        } else {
            $activity->description = "Has {$eventName} an Expense's details" ;
        }
    }


    public function category() {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
    
    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function attachments() {
        return $this->media()->where('collection_name', 'expense_attachments');
    }
}
