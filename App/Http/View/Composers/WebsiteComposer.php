<?php

namespace App\Http\View\Composers;

use App\Models\Banner;
use App\Models\Section;
use Illuminate\View\View;

class WebsiteComposer
{
    private $sections;

    private $footerSections;

    private $underfootermenu;

    private $contact;

    private $disclaimer_banner;

    public function __construct()
    {

        $this->sections = Section::whereHas('translation', function ($q) {
            $q->whereActive(true);
        })
        ->whereHas('menuTypes', function ($q) {
            $q->where('menu_type_id', 1);
        })->where('parent_id', null)
        ->orderBy('order', 'asc')
        ->get();

         $this->footerSections = Section::whereHas('translations', function ($q) {
            $q->whereActive(true)->whereLocale(app()->getLocale());
        })
        ->whereHas('menuTypes', function ($q) {
            $q->where('menu_type_id', 2);
        })->where('parent_id', null)
        ->orderBy('order', 'asc')
        ->get();

            $this->contact = Section::where('type_id', sectionTypes()['contact']['id'])->with('translations')->first();



    }

    public function compose(View $view)
    {
        $view->with([
            'sections' => $this->sections,
            'footerSections' => $this->footerSections,
            'contact' => $this->contact,

        ]);
    }
}