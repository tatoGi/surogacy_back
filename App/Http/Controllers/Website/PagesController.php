<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Post;
use App\Models\Section;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\SurrogatePeople;
use App\Models\FormSubmission;
use App\Models\Company;
use Illuminate\Support\Facades\Log;

class PagesController extends Controller
{
    public static function index($model, Request $request)
    {
        // dd($request, 'section');
        if (request()->method() == 'POST') {

            $values = request()->all();

            $values['additional'] = getAdditional($values, config('submissionAttr.additional'));

            $submission = Submission::create($values);

            return redirect()->back()->with([

                'message' => trans('website.submission_sent'),

            ]);

        }
        $section = $model;
        $language_slugs = $section->getTranslatedFullSlugs();

        // BreadCrumb ----------------------------

        $breadcrumbs = [];

        $breadcrumbs[] = [

            'name' => $model[app()->getlocale()]->title,

            'url' => $model->getFullSlug(),

        ];

        while ($section->parent_id !== null) {

            $section = Section::where('id', $model->parent_id)->with('translations')->first();

            $breadcrumbs[] = [

                'name' => $section->title,

                'url' => $section->getFullSlug(),

            ];

        }

        $breadcrumbs = array_reverse($breadcrumbs);

           switch ($model->type_id) {

            case 1:
                $homePageController = new HomePageController();
                return $homePageController->homePage($model, $locales = null);

            case 2:
                $post = Post::where('section_id', $model->id)->whereHas('translations', function ($q) {

                    $q->where('active', 1);

                })->first();

            return view('website.pages.contact.index', compact('model', 'language_slugs', 'breadcrumbs', 'post'), ['successMsg' => 'Contact form successfully send']);

            case 3:

                $posts = Post::where('section_id', $model->id)->whereHas('translation', function ($q) {
                    $q->whereActive(true);
                })->orderBy('date', 'desc')->with('files')->paginate(10);

            return view('website.pages.text_page.index', compact('model', 'breadcrumbs', 'language_slugs', 'posts'));

            case 5:

                $posts = Post::where('section_id', $model->id)->whereHas('translation', function ($q) {
                    $q->whereActive(true);
                })->orderBy('date', 'desc')->paginate(settings('publication_pagination'));

            return view('website.pages.learning.index', compact('model', 'breadcrumbs', 'language_slugs', 'posts'));

            case 6:

                $post = Post::where('section_id', $model->id)->whereHas('translation', function ($q) {
                    $q->whereActive(true);
                })->orderBy('date', 'desc')->first();
                $team = Section::where('type_id', 8)->with('translations')->with('posts')->first();
            return view('website.pages.about.about', compact('model', 'breadcrumbs', 'language_slugs', 'post', 'team'   ));

            case 7:

                $surrogatePeople = SurrogatePeople::with('images')
                ->where('active', 1)
                ->with('translations')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('website.pages.surrogate.index', compact('model', 'breadcrumbs', 'language_slugs', 'surrogatePeople'));

        default:

            $posts = Post::where('section_id', $model->id)

                ->join('post_translations', 'posts.id', '=', 'post_translations.post_id')

                ->where('post_translations.locale', '=', app()->getLocale())

                ->select('posts.*', 'post_translations.text', 'post_translations.desc', 'post_translations.title', 'post_translations.locale_additional', 'post_translations.slug')
                ->where('active', 1)->whereLocale(app()->getLocale())
                ->with('files')
                ->orderBy('date', 'desc')

                ->paginate(settings('paginate'));

            $vacancy = Section::where('type_id', 6)->with('translations')->with('posts')->first();

            $popular_vacancy = Post::where('section_id', $vacancy->id)->whereHas('translations', function ($q) {

            $q->where('active', 1);

            })->where('populars', 1)->first();

            $programs = Section::where('type_id', 3)->with('translations')->with('posts')->first();

            return view("website.pages.{$model->type['folder']}.index", compact('model', 'breadcrumbs', 'language_slugs',

                'posts', 'vacancy', 'popular_vacancy', 'programs'

            ));

    }

        return view("website.pages.{$model->type['folder']}.index", compact(['model', 'breadcrumbs',
         'language_slugs', 'posts', 'vacancy', 'popular_vacancy', 'programs']));

    }

    public static function submenu($model)
    {

        $breadcrumbs = [];

        $sec = $model;

        $breadcrumbs[] = [

            'name' => $model->title,

            'url' => $model->getFullSlug(),

        ];

        while ($sec->parent_id !== null) {

            $sec = Section::where('id', $model->parent_id)->with('translations')->first();

            $breadcrumbs[] = [

                'name' => $sec->title,

                'url' => $sec->getFullSlug(),

            ];

        }

        $sec = Section::where('type_id', sectionTypes()['home']['id'])->with('translations')->first();

        $breadcrumbs[] = [

            'name' => $sec->title,

            'url' => $sec->getFullSlug(),

        ];

        $breadcrumbs = array_reverse($breadcrumbs);

        $submenu_sections = Section::where('parent_id', $model->id)->orderBy('order', 'asc')->get();

        return view('website.pages.submenu.index', compact('model', 'submenu_sections', 'breadcrumbs'));

    }

    public static function show($model)
    {
        if (request()->method() == 'POST') {
            $values = request()->all();
            $values['additional'] = getAdditional($values, config('submissionAttr.additional'));
            $submission = Submission::create($values);
            return redirect()->back()->with(['message' => trans('website.submission_sent')]);
        }

        $language_slugs = $model->getTranslatedFullSlugs();

        // Handle different model types
        if ($model instanceof SurrogatePeople) {
            return view('website.pages.surrogate.show', [
                'model' => $model,
                'language_slugs' => $language_slugs
            ]);
        }

        // Handle Post model
        if ($model->section_id !== null) {
            $section = Section::where('id', $model->section_id)->with('translation')->first();
            return view("website.pages.{$section->type['folder']}.show", [
                'model' => $model,
                'section' => $section,
                'post' => $model,
                'language_slugs' => $language_slugs
            ]);
        }

        abort(404);
    }

    public function submitSurrogateForm(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:255',
                'age' => 'required|integer|min:18',
                'location' => 'required|string|max:255',
                'message' => 'required|string',
                'terms_accepted' => 'required|accepted'
            ]);

            $submission = FormSubmission::create([
                'form_type' => 'surrogate',
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'age' => $validated['age'],
                'location' => $validated['location'],
                'message' => $validated['message'],
                'terms_accepted' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => __('admin.form_submitted_successfully')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again.'
            ], 500);
        }
    }

    public function submitParentForm(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'parent_type' => 'required|string|in:single,couple,lgbtq',
            'message' => 'required|string',
            'terms_accepted' => 'required|accepted'
        ]);

        $submission = FormSubmission::create([
            'form_type' => 'parent',
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'location' => $validated['location'],
            'parent_type' => $validated['parent_type'],
            'message' => $validated['message'],
            'terms_accepted' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => __('admin.form_submitted_successfully')
        ]);
    }

    public function toggleFavorite(SurrogatePeople $id)
    {
        try {
            $company = auth('company')->user();
            \Log::info('Company:', ['id' => $company->id, 'email' => $company->email]);
            \Log::info('Surrogate Person:', ['id' => $id->id]);

            $isFavorite = $company->favoriteSurrogatePeople()->where('surrogate_people_id', $id->id)->exists();
            \Log::info('Is Favorite:', ['status' => $isFavorite]);

            if ($isFavorite) {
                $company->favoriteSurrogatePeople()->detach($id->id);
                \Log::info('Detached favorite');
            } else {
                $company->favoriteSurrogatePeople()->attach($id->id);
                \Log::info('Attached favorite');
            }

            return response()->json([
                'is_favorite' => !$isFavorite,
                'message' => 'Successfully updated favorite status'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in toggleFavorite:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
