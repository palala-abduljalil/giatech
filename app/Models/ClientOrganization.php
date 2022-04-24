<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientOrganization extends Model
{
    use HasFactory;

    protected $table = 'client_organization';
    protected $fillable = ['client_id', 'name'];

    public function client() 
    {
        return $this->belongsTo(Client::class);
    }
}
