<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Client extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $table = 'client';
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('client')
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        if ($eventName == 'created' || $eventName == 'deleted') {
            $activity->description = "Has {$eventName} a Client" ;
        } else {
            $activity->description = "Has {$eventName} a Client's details" ;
        }
    }

    public function createdBy() {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function address() {
        return $this->hasOne(ClientAddress::class);
    }

    public function contactNumber() {
        return $this->hasOne(ClientContactNumber::class);
    }

    public function emailAddress() {
        return $this->hasOne(ClientEmailAddress::class);
    }

    public function organization() {
        return $this->hasOne(ClientOrganization::class);
    }

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function profilePicture() {
        return $this->media()->where('collection_name', 'client_profile_picture');
    }

    public function registerMediaCollections() : void {
        $this->addMediaCollection('client_profile_picture')->singleFile();
    }

    public function getFullNameAttribute() {
        return $this->attributes['firstName']. ' ' .strtoupper($this->attributes['middleName'][0]). '. '.$this->attributes['lastName']. ' '.$this->attributes['suffix'];
    }
}
