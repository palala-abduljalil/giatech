<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Employee;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable // implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, LogsActivity, CausesActivity;

    protected $table = 'user';

    protected $fillable = [
        'username', 'password', 'email', 'employee_id', 'role_id', 'isActivated', 'isRenewed'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontLogIfAttributesChangedOnly(['remember_token', 'password', 'updated_at', 'isActivated']);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function createdBy() {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function securityQuestions() {
        return $this->belongsToMany(SecurityQuestion::class, 'user_security_question', 'user_id', 'security_question_id')->withPivot('id', 'answer');
    }

    public function activityLogs() {
        return $this->hasMany(ActivityLog::class);
    }

    public function status() {
        return $this->belongsTo(UserStatus::class, 'user_status_id');
    }

    public function modules() {
        return $this->belongsToMany(SystemModule::class, 'user_module', 'user_id', 'module_id');
    }

    public function isAdmin()
    {
        return $this->role()->where('id', '1')->exists();
    }
    
    public function isUser()
    {
        return $this->role()->where('id', '2')->exists();
    }
}
