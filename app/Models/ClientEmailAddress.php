<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientEmailAddress extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'emailAddress'];
    protected $table = 'client_email_address';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
