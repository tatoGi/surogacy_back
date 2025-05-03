<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Slug;
use Illuminate\Http\Request;

class RoutesController extends Controller
{
    public function index($url, Request $request)
    {
        if ($url == 'search') {
            return SearchController::search($request);
        }

        $slug = Slug::where('fullSlug', app()->getLocale()."/{$url}")->first();

        if (!$slug) {
            abort(404);
        }

        $model = $slug->slugable()->first();

        if (!$model) {
            abort(404);
        }

        if ($slug->slugable_type === "App\Models\Section") {
            // Check if section is type_id 7 and user is not logged in as company
            if ($model->type_id === 7 && !auth()->guard('company')->check()) {
                return redirect()->route('company.login');
            }
            return PagesController::index($model, $request);
        }

        if ($slug->slugable_type === "App\Models\Post") {
            return PagesController::show($model);
        }

        if ($slug->slugable_type === "App\Models\SurrogatePeople") {
            return PagesController::show($model);
        }



        abort(404);
    }
}
