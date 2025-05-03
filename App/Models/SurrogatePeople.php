<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class SurrogatePeople extends Model implements TranslatableContract
{
    use Translatable;

    protected $primaryKey = 'id';
    protected $table = 'surrogate_people';

    public $translatedAttributes = [
        'title',
        'name',
        'surname',
        'slug',
        'nationality',
        'hair_color',
        'eye_color',
        'skin_complexion',
        'education',
        'marital_status',
        'race',
        'donation_experience'
    ];

    protected $fillable = [
        'age',
        'height',
        'weight',
        'blood_type',
        'active',
        'code'
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_surrogate_favorites')
            ->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(SurrogatePeopleImage::class)->orderBy('order');
    }

    public function getFullSlug()
    {

        $slug = Slug::where('slugable_type', 'App\Models\SurrogatePeople')->where('slugable_id', $this->id)->where('locale', app()->getlocale())->first();

        if ($slug !== null) {

            return $slug->fullSlug;

        }

        return null;

    }
    public function getTranslatedFullSlugs($slugs = [], $parent = null)
    {

        if (! count($slugs)) {

          $translations = $this->translations;

          foreach ($translations as $key => $value) {

            $slugs[$value->locale] = $value->slug;

          }

          // dd($slugs);

          // $parent = $this->parent;

        } else {

          $translations = $parent->translations;

          foreach ($translations as $key => $value) {

            $slugs[$value->locale] = $value->slug.'/'.$slugs[$value->locale];

          }

          $parent = $parent->parent;

        }

        if ($parent == null) {

          foreach ($slugs as $key => $value) {

            if (count($_GET)) {

              $slugs[$key] = $key.'/'.$value.'?'.http_build_query($_GET);
            } else {

              $slugs[$key] = $key.'/'.$value;

            }

          }

          return $slugs;

        }

        return $this->getTranslatedFullSlugs($slugs, $parent);

      }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Add translated attributes to searchable array
        $array['title'] = $this->translate(app()->getLocale())->title;
        $array['nationality'] = $this->translate(app()->getLocale())->nationality;
        $array['hair_color'] = $this->translate(app()->getLocale())->hair_color;
        $array['eye_color'] = $this->translate(app()->getLocale())->eye_color;
        $array['skin_complexion'] = $this->translate(app()->getLocale())->skin_complexion;
        $array['education'] = $this->translate(app()->getLocale())->education;
        $array['marital_status'] = $this->translate(app()->getLocale())->marital_status;
        $array['race'] = $this->translate(app()->getLocale())->race;
        $array['donation_experience'] = $this->translate(app()->getLocale())->donation_experience;

        return $array;
    }

}
