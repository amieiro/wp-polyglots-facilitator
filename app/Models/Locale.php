<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $fillable = [
        'locale_name',
        'native_name',
        'locale_code',
        'wordpress_locale',
    ];

    public function getFullNameAttribute()
    {
        return $this->locale_name . ' (' . $this->native_name . ')';
    }
}
