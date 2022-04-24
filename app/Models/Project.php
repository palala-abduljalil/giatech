<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $table = 'project';
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
            $activity->description = "Has {$eventName} a Project" ;
        } else {
            $activity->description = "Has {$eventName} a Project's details" ;
        }
    }

    public function createdBy() {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function status() {
        return $this->belongsTo(ProjectStatus::class);
    }

    public function category() {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function activities() {
        return $this->hasMany(ProjectActivity::class);
    } 

    public function attachments() {
        return $this->media()->where('collection_name', 'project_attachments');
    }
}
