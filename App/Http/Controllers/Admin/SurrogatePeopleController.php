<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurrogatePeople;
use Illuminate\Http\Request;
use Astrotomic\Translatable\Translatable;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use App\Models\Slug;
use App\Models\SurrogatePeopleImage;
use Illuminate\Support\Facades\Storage;

class SurrogatePeopleController extends Controller
{
    public function index(Request $request)
    {
        $query = SurrogatePeople::with('translations');

        if ($request->has('search')) {
            $searchTerm = $request->search;

            // Search in non-translatable fields
            $query->where(function($q) use ($searchTerm) {
                $q->where('age', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('height', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('weight', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('blood_type', 'LIKE', "%{$searchTerm}%");
            })
            // Search in translatable fields
            ->orWhereHas('translations', function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('nationality', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('hair_color', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('eye_color', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('skin_complexion', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('education', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('marital_status', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('race', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('donation_experience', 'LIKE', "%{$searchTerm}%");
            });
        }

        $surrogatePeople = $query->orderBy('created_at', 'desc')->get();
        return view('admin.surrogate-people.index', compact('surrogatePeople'));
    }

    public function create()
    {
        return view('admin.surrogate-people.create');
    }

    public function store(Request $request)
    {
        try {
            $validationRules = [
                'age' => 'required|integer|min:18|max:100',
                'height' => 'required|numeric|min:0|max:300',
                'weight' => 'required|numeric|min:0|max:500',
                'blood_type' => 'required|string|max:10',
                'code' => 'required|string|unique:surrogate_people,code|regex:/^[A-Z]{2}-[A-Z][0-9]{3}$/',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ];

            // Add validation rules for each locale
            foreach(config('app.locales') as $locale) {
                $validationRules[$locale.'.title'] = 'required|string|max:255';
                $validationRules[$locale.'.name'] = 'required|string|max:255';
                $validationRules[$locale.'.surname'] = 'required|string|max:255';
                $validationRules[$locale.'.slug'] = 'required|string|max:255';
                $validationRules[$locale.'.nationality'] = 'required|string|max:255';
                $validationRules[$locale.'.hair_color'] = 'required|string|max:255';
                $validationRules[$locale.'.eye_color'] = 'required|string|max:255';
                $validationRules[$locale.'.skin_complexion'] = 'required|string|max:255';
                $validationRules[$locale.'.education'] = 'required|string|max:255';
                $validationRules[$locale.'.marital_status'] = 'required|string|max:255';
                $validationRules[$locale.'.race'] = 'required|string|max:255';
                $validationRules[$locale.'.donation_experience'] = 'required|string';
            }

            $request->validate($validationRules);

            // Validate slugs for each locale
            foreach(config('app.locales') as $locale) {
                $slug = $request->input($locale.'.slug');
                $fullSlug = $locale.'/'.$slug;

                if (Slug::where('fullSlug', $fullSlug)->where('locale', $locale)->exists()) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors([$locale.'.slug' => trans('admin.slug_already_exists')]);
                }
            }

            $surrogate = new SurrogatePeople();

            // Set non-translatable attributes
            $surrogate->age = $request->age;
            $surrogate->height = $request->height;
            $surrogate->weight = $request->weight;
            $surrogate->blood_type = $request->blood_type;
            $surrogate->code = $request->code;

            // Set translations for each locale
            foreach(config('app.locales') as $locale) {
                $surrogate->translateOrNew($locale)->title = $request->input($locale.'.title');
                $surrogate->translateOrNew($locale)->name = $request->input($locale.'.name');
                $surrogate->translateOrNew($locale)->surname = $request->input($locale.'.surname');
                $surrogate->translateOrNew($locale)->slug = $request->input($locale.'.slug');
                $surrogate->translateOrNew($locale)->nationality = $request->input($locale.'.nationality');
                $surrogate->translateOrNew($locale)->hair_color = $request->input($locale.'.hair_color');
                $surrogate->translateOrNew($locale)->eye_color = $request->input($locale.'.eye_color');
                $surrogate->translateOrNew($locale)->skin_complexion = $request->input($locale.'.skin_complexion');
                $surrogate->translateOrNew($locale)->education = $request->input($locale.'.education');
                $surrogate->translateOrNew($locale)->marital_status = $request->input($locale.'.marital_status');
                $surrogate->translateOrNew($locale)->race = $request->input($locale.'.race');
                $surrogate->translateOrNew($locale)->donation_experience = $request->input($locale.'.donation_experience');
            }

            // Save the model with translations
            $surrogate->save();

            // Create slugs for each locale
            foreach(config('app.locales') as $locale) {
                $slug = new Slug();
                $slug->fullSlug = $locale.'/'.$request->input($locale.'.slug');
                $slug->locale = $locale;
                $slug->slugable_id = $surrogate->id;
                $slug->slugable_type = get_class($surrogate);
                $slug->save();
            }

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('surrogate-people', 'public');

                    SurrogatePeopleImage::create([
                        'surrogate_people_id' => $surrogate->id,
                        'image_path' => $path,
                        'order' => $index
                    ]);
                }
            }

            ToastMagic::success(trans('store.successfully_saved'));
            return redirect()->route('admin.surrogations.index', [app()->getLocale()]);
        } catch (\Exception $e) {
            ToastMagic::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit(SurrogatePeople $surrogatePeople)
    {
        return view('admin.surrogate-people.edit', compact('surrogatePeople'));
    }

    public function update(Request $request, SurrogatePeople $surrogatePeople)
    {
        try {
            $validationRules = [
                'age' => 'required|integer|min:18|max:100',
                'height' => 'required|numeric|min:0|max:300',
                'weight' => 'required|numeric|min:0|max:500',
                'blood_type' => 'required|string|max:10',
                'code' => 'required|string|regex:/^[A-Z]{2}-[A-Z][0-9]{3}$/',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ];

            // Add validation rules for each locale
            foreach(config('app.locales') as $locale) {
                $validationRules[$locale.'.title'] = 'required|string|max:255';
                $validationRules[$locale.'.name'] = 'required|string|max:255';
                $validationRules[$locale.'.surname'] = 'required|string|max:255';
                $validationRules[$locale.'.slug'] = 'required|string|max:255';
                $validationRules[$locale.'.nationality'] = 'required|string|max:255';
                $validationRules[$locale.'.hair_color'] = 'required|string|max:255';
                $validationRules[$locale.'.eye_color'] = 'required|string|max:255';
                $validationRules[$locale.'.skin_complexion'] = 'required|string|max:255';
                $validationRules[$locale.'.education'] = 'required|string|max:255';
                $validationRules[$locale.'.marital_status'] = 'required|string|max:255';
                $validationRules[$locale.'.race'] = 'required|string|max:255';
                $validationRules[$locale.'.donation_experience'] = 'required|string';
            }

            $validated = $request->validate($validationRules);

            // Validate slugs for each locale
            foreach(config('app.locales') as $locale) {
                $slug = $request->input($locale.'.slug');
                $fullSlug = $locale.'/'.$slug;

                if (Slug::where('fullSlug', $fullSlug)
                        ->where('locale', $locale)
                        ->where('slugable_id', '!=', $surrogatePeople->id)
                        ->exists()) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors([$locale.'.slug' => trans('admin.slug_already_exists')]);
                }
            }

            // Update non-translatable attributes
            $surrogatePeople->update([
                'age' => $request->age,
                'height' => $request->height,
                'weight' => $request->weight,
                'blood_type' => $request->blood_type,
                'active' => $request->has('active'),
                'code' => $request->code
            ]);

            // Update translations for each locale
            foreach(config('app.locales') as $locale) {
                $surrogatePeople->translateOrNew($locale)->title = $request->input($locale.'.title');
                $surrogatePeople->translateOrNew($locale)->name = $request->input($locale.'.name');
                $surrogatePeople->translateOrNew($locale)->surname = $request->input($locale.'.surname');
                $surrogatePeople->translateOrNew($locale)->slug = $request->input($locale.'.slug');
                $surrogatePeople->translateOrNew($locale)->nationality = $request->input($locale.'.nationality');
                $surrogatePeople->translateOrNew($locale)->hair_color = $request->input($locale.'.hair_color');
                $surrogatePeople->translateOrNew($locale)->eye_color = $request->input($locale.'.eye_color');
                $surrogatePeople->translateOrNew($locale)->skin_complexion = $request->input($locale.'.skin_complexion');
                $surrogatePeople->translateOrNew($locale)->education = $request->input($locale.'.education');
                $surrogatePeople->translateOrNew($locale)->marital_status = $request->input($locale.'.marital_status');
                $surrogatePeople->translateOrNew($locale)->race = $request->input($locale.'.race');
                $surrogatePeople->translateOrNew($locale)->donation_experience = $request->input($locale.'.donation_experience');
            }

            $surrogatePeople->save();

            // Update slugs for each locale
            foreach(config('app.locales') as $locale) {
                $slug = Slug::where('slugable_id', $surrogatePeople->id)
                    ->where('locale', $locale)
                    ->first();

                if ($slug) {
                    $slug->fullSlug = $locale.'/'.$request->input($locale.'.slug');
                    $slug->save();
                } else {
                    $slug = new Slug();
                    $slug->fullSlug = $locale.'/'.$request->input($locale.'.slug');
                    $slug->locale = $locale;
                    $slug->slugable_id = $surrogatePeople->id;
                    $slug->slugable_type = get_class($surrogatePeople);
                    $slug->save();
                }
            }

            // Handle image uploads
            if ($request->hasFile('images')) {
                // Delete old images if requested
                if ($request->has('delete_images')) {
                    foreach ($request->delete_images as $imageId) {
                        $image = SurrogatePeopleImage::find($imageId);
                        if ($image) {
                            Storage::disk('public')->delete($image->image_path);
                            $image->delete();
                        }
                    }
                }

                // Upload new images
                $lastOrder = $surrogatePeople->images()->max('order') ?? -1;
                foreach ($request->file('images') as $image) {
                    $path = $image->store('surrogate-people', 'public');
                    $lastOrder++;

                    SurrogatePeopleImage::create([
                        'surrogate_people_id' => $surrogatePeople->id,
                        'image_path' => $path,
                        'order' => $lastOrder
                    ]);
                }
            }

            ToastMagic::success(trans('store.successfully_saved'));
            return redirect()->route('admin.surrogations.index', [app()->getLocale()]);
        } catch (\Exception $e) {
            ToastMagic::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function toggleStatus(SurrogatePeople $surrogatePeople)
    {
        $surrogatePeople->update([
            'active' => !$surrogatePeople->active
        ]);

        return redirect()->back()->with('success', __('Status updated successfully'));
    }

    public function destroy(SurrogatePeople $surrogatePeople)
    {
        // Delete associated images
        foreach ($surrogatePeople->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $surrogatePeople->delete();
        return redirect()->route('admin.surrogations.index', [app()->getLocale()])
            ->with('success', 'Surrogate person deleted successfully.');
    }

    public function CheckSlug(Request $request)
    {
        $locale = $request->locale;
        $slug = $request->slug;
        $id = $request->id;

        $fullSlug = $locale.'/'.$slug;

        if (Slug::where('fullSlug', $fullSlug)
                ->where('locale', $locale)
                ->when($id, function($query) use ($id) {
                    return $query->where('slugable_id', '!=', $id);
                })
                ->exists()) {
            return response()->json(['error' => trans('admin.slug_already_exists')], 401);
        }

        return response()->json(['message' => trans('admin.slug_available')], 200);
    }
}
