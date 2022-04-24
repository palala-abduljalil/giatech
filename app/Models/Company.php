<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'company';
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('company')
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->description = "Has {$eventName} ". 
            join(filterArray($activity->properties['attributes']))." in Content Management.";
    }

    public function services() {
        return $this->hasMany(Service::class);
    }

    public function freebies() {
        return $this->hasMany(Freebie::class);
    }

    public function socialMediaAccounts() {
        return $this->hasMany(SocialMedia::class);
    }

    public function stakeholders() {
        return $this->hasMany(StakeHolder::class);
    }
}
