<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Orchid\Screen\AsSource;

class Lead extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'tags',
        'field_search',
        'lead_id',
        'responsible_user_id',
        'status_id',
        'contact_id',
        'pipeline_id',
        'utm_source',
        'utm_content',
        'utm_term',
        'utm_campaign',
        'utm_medium',
        'responsible_user_id',
        'telephony',
    ];
}
