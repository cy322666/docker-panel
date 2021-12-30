<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;

    protected $table = 'access';

    protected $fillable = [
        'account_id',
        'name',
        'subdomain',
        'access_token',
        'refresh_token',
        'client_secret',
        'redirect_uri',
        'token_type',
        'expires_in',
        'client_id',
        'api_key',
        'code',
    ];
}
