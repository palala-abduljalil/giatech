<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientContactNumber extends Model
{
    use HasFactory;

    protected $table = 'client_contact_number';
    protected $fillable = ['client_id', 'contactNumber'];

    public function client() 
    {
        return $this->belongsTo(Client::class);
    }
}
