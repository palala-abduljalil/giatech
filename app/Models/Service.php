<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Company;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Service extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $table = 'service';
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('service')
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        if ($eventName == 'created' || $eventName == 'deleted') {
            $activity->description = "Has {$eventName} a Service in Content Management" ;
        } else {
            $activity->description = "Has {$eventName} a Service's details in Content Management";
        }
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function createdBy() {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function coverImage() {
        return $this->media()->where('collection_name', 'service_cover');
    }

    public function registerMediaCollections() : void {
        $this->addMediaCollection('service_cover')->singleFile();
    }
}
