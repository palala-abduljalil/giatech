<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class SecurityQuestion extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'security_question';
    protected $fillable = ['question'];

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
            $activity->description = "Has {$eventName} an Security Question";
        } else {
            $activity->description = "Has {$eventName} an Security Question's details";
        }
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_security_question', 'security_question_id', 'user_id');
    }
}
