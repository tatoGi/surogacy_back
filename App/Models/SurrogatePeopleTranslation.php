<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurrogatePeopleTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title',
        'name',
        'surname',
        'nationality',
        'hair_color',
        'eye_color',
        'skin_complexion',
        'education',
        'marital_status',
        'race',
        'donation_experience'
    ];
}
