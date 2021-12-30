<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Check extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'result',
        'setting_id',
        'source_name',
    ];

    protected $table = 'check';

    public function setting()
    {
        return $this->hasOne(Setting::class, 'id', 'setting_id');
    }
}
