<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Employee extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $table = 'employee';
    protected $guarded = [];

    public function account() {
        return $this->hasOne(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('employee')
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $employee = Employee::find($activity->subject_id)->employeeNumber;
        if ($eventName == 'deleted') {
            $activity->description = "Has {$eventName} a employee" ;
        } else {
            if ($eventName == 'created') {
                $activity->description = "Has {$eventName} a employee with an employee number {$employee}" ;
            } else  {
                $activity->description = "Has {$eventName} a employee's details with an employee number {$employee}" ;
            }
        }
    }

    public function createdBy() {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function expenses() {
        return $this->hasMany(Expense::class);
    }

    public function transportationExpenses() {
        return $this->hasMany(ExpenseTransportation::class);
    }

    public function stakeholder() {
        return $this->hasOne(Stakeholder::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function degree() {
        return $this->belongsTo(Degree::class);
    }

    public function school() {
        return $this->belongsTo(School::class);
    }
    
    public function status() {
        return $this->belongsTo(EmployeeStatus::class);
    }

    public function emailAddress() {
        return $this->hasOne(EmployeeEmailAddress::class);
    }

    public function achievements() {
        return $this->hasMany(Achievement::class);
    }
    
    public function skills() {
        return $this->hasMany(Skill::class);
    }

    public function address() {
        return $this->hasOne(EmployeeAddress::class);
    }

    public function contactNumber() {
        return $this->hasOne(EmployeeContactNumber::class);
    }

    public function attachments() {
        return $this->media()->where('collection_name', 'employee_attachments');
    }
    
    public function profilePicture() {
        return $this->media()->where('collection_name', 'employee_profile_picture');
    }

    public function registerMediaCollections() : void {
        $this->addMediaCollection('employee_profile_picture')->singleFile();
    }

    public function getFullNameAttribute() {
        return $this->attributes['firstName']. ' ' .strtoupper($this->attributes['middleName'][0]). '. '.$this->attributes['lastName']. ' '.$this->attributes['suffix'];
    }
}
