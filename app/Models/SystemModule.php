<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemModule extends Model
{
    use HasFactory;

    protected $table = 'module';
    protected $fillable = ['name', 'slug'];
    public const CAN_MANAGE_CONTENT = 1;
    public const CAN_MANAGE_EMPLOYEES = 2;
    public const CAN_MANAGE_USER = 3;
    public const CAN_MANAGE_CLIENTS = 4;
    public const CAN_MANAGE_PROJECTS = 5;
    public const CAN_MANAGE_FINANCE = 6;
    public const CAN_GENERATE_REPORTS = 7;

    public function users() {
        return $this->belongsToMany(User::class, 'user_module', 'module_id', 'user_id');
    }
}
