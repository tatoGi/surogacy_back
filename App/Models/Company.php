<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable implements TranslatableContract
{
    use Translatable, Notifiable;

    public $translatedAttributes = ['name', 'country', 'description', 'slug'];
    protected $fillable = ['phone', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    protected $with = ['translations'];

    public function favoriteSurrogatePeople()
    {
        return $this->belongsToMany(SurrogatePeople::class, 'company_surrogate_favorites')
            ->withTimestamps();
    }

    public function surrogatePeople()
    {
        return $this->belongsToMany(SurrogatePeople::class, 'company_surrogate_favorites')
            ->withTimestamps();
    }
}
