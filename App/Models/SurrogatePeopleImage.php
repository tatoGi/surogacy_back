<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurrogatePeopleImage extends Model
{
    protected $fillable = [
        'surrogate_people_id',
        'image_path',
        'order'
    ];

    public function surrogatePeople()
    {
        return $this->belongsTo(SurrogatePeople::class);
    }
}
