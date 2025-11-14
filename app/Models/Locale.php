<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $fillable = [
        'locale_name',
        'native_name',
        'locale_code',
        'wordpress_locale',
    ];

    /**
     * Get the full name attribute.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->locale_name} ({$this->native_name})"
        );
    }
}
