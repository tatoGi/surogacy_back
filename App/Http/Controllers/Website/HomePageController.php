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
                'news' => $this->getNewsSection(),
                'news_posts' => $this->getNewsPosts(),
                'mainBanner' => $this->getMainBanner(),
                'show_room' => $this->getShowroomSection(),
                'product_posts' => $this->getProductPosts(),
                'show_room_post' => $this->getShowroomPosts(),
                'products' => $this->getProductsSection()
            ]);
        } catch (ModelNotFoundException $e) {
            return view('website.404');
        }
    }

    private function getMainBanner(): Collection
    {
        return Banner::whereHas('translation', function ($q) {
            $q->where('active', 1)->whereLocale(app()->getLocale());
        })
        ->where('type_id', 1)
        ->orderBy('date', 'desc')
        ->get();
    }

    private function getProductsSection(): ?Section
    {
        return Section::where('type_id', 3)
            ->with('translation')
            ->first();
    }

    private function getProductPosts(): Collection
    {
        $products = $this->getProductsSection();
        if (!$products) {
            return new Collection();
        }

        return Post::where('section_id', $products->id)
            ->whereHas('translations', function ($q) {
                $q->where('active', 1);
            })
            ->get();
    }

    private function getShowroomSection(): ?Section
    {
        return Section::where('type_id', 8)
            ->with('translations')
            ->first();
    }

    private function getShowroomPosts(): Collection
    {
        $show_room = $this->getShowroomSection();
        if (!$show_room) {
            return new Collection();
        }

        return Post::where('section_id', $show_room->id)
            ->whereHas('translations', function ($q) {
                $q->where('active', 1);
            })
            ->get();
    }

    private function getNewsSection(): ?Section
    {
        return Section::where('type_id', 7)
            ->with('translations')
            ->first();
    }

    private function getNewsPosts(): Collection
    {
        $news = $this->getNewsSection();
        if (!$news) {
            return new Collection();
        }

        return Post::where('section_id', $news->id)
            ->whereHas('translations', function ($q) {
                $q->where('active', 1);
            })
            ->get();
    }
}