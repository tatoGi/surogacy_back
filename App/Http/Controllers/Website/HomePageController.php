<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Post;
use App\Models\Section;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class HomePageController extends Controller
{
    public function homePage(?Section $model = null, ?array $locales = null): View
    {
        try {
            $model = $model ?? Section::where('type_id', 1)->firstOrFail();
            $locales = $locales ?? array_map(function($value) {
                return '/'.$value;
            }, config('app.locales'));

            $language_slugs = $model->getTranslatedFullSlugs();

            return view('website.home', [
                'model' => $model,
                'language_slugs' => $language_slugs,
                'about_us' => $this->getAboutUsSection(),
                'mainBanner' => $this->getMainBanner(),
                'contact_us' => $this->getContactUsSection(),
            ]);
        } catch (ModelNotFoundException $e) {
            return view('website.404');
        }
    }

    private function getMainBanner()
    {
        return Banner::whereHas('translation', function ($q) {
            $q->where('active', 1)->whereLocale(app()->getLocale());
        })
        ->where('type_id', 1)
        ->orderBy('date', 'desc')
        ->get();
    }

    private function getAboutUsSection()
    {
        return Section::where('type_id', 6)
            ->with('translation')
            ->with(['post' => function($query) {
                $query->with('files');
            }])
            ->first();
    }

    private function getContactUsSection()
    {
        return Section::where('type_id', 2)
            ->with('translation')
            ->with(['post' => function($query) {
                $query->with('files', 'translations');
            }])
            ->first();
    }



}
