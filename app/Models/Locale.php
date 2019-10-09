<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    public function getFullNameAttribute()
    {
        return $this->locale_name . ' (' . $this->native_name . ')';
    }
}
