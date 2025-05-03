<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTranslation extends Model
{
    protected $fillable = [
        'company_id',
        'locale',
        'name',
        'country',
        'description'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
