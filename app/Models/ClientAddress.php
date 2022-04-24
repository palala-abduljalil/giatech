<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientAddress extends Model
{
    use HasFactory;

    protected $table = 'client_address';
    protected $fillable = [
        'client_id', 
        'houseNumber',
        'streetName',
        'barangay',
        'city',
        'province',
        'region'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getFullAddressAttribute() {
        return $this->attributes['streetName']. ', '.$this->attributes['barangay'].', '.$this->attributes['city'].', '.$this->attributes['province'].', '.$this->attributes['region'];
    }
}
