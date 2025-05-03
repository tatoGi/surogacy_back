<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'age',
        'location',
        'message',
        'parent_type',
        'terms_accepted'
    ];

    protected $casts = [
        'terms_accepted' => 'boolean',
        'age' => 'integer'
    ];
}
