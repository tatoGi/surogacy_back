<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerFile;
use App\Models\BannerTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index($type)
    {
        $type = collect(bannerTypes())->where('id', $type)->first();

        $banners = Banner::where('type_id', $type['id'])->orderBy('date', 'desc')->with('translations')->paginate(9);

        return view('admin.banners.list', compact('type', 'banners'));
    }

    public function create($type)
    {
        $type = collect(bannerTypes())->where('id', $type)->first();

        return view('admin.banners.add', compact('type'));
    }

    public function store($type, Request $request)
    {
        $type = collect(bannerTypes())->where('id', $type)->first();
        $values = $request->all();
        $banner = null;
        $this->storeBanner($values, $type, $banner);

        return Redirect::route('banner.list', [app()->getLocale(), $type['id']]);
    }

    public function edit($banner)
    {
        $banner = Banner::where('id', $banner)->with(['translations', 'files'])->first();
        foreach ($banner->additional as $key => $value) {
            $banner->{$key} = $value;
        }
        $type = collect(bannerTypes())->where('id', $banner->type_id)->first();

        return view('admin.banners.edit', compact('type', 'banner'));
    }

    public function update($banner, Request $request)
    {
        $values = $request->all();

        $banner = Banner::where('id', $banner)->with(['translations', 'files'])->first();

        $type = collect(bannerTypes())->where('id', $banner->type_id)->first();
        $this->storeBanner($values, $type, $banner);

        return Redirect::route('banner.list', [app()->getLocale(), $type['id']]);
    }

    public function destroy($banner)
    {

        $banner = Banner::find($banner);

        $type = collect(bannerTypes())->where('id', $banner->type_id)->first();

        $files = BannerFile::where('banner_id', $banner->id)->get();
        foreach ($files as $file) {
            if (File::exists(config('config.image_path').$file->file)) {
                File::delete(config('config.image_path').$file->file);
            }
            if (File::exists(config('config.image_path').'thumb/'.$file->file)) {
                File::delete(config('config.image_path').'thumb/'.$file->file);
            }

            $file->delete();
        }

        BannerTranslation::where('banner_id', $banner->id)->delete();

        $banner->delete();

        return Redirect::route('banner.list', [app()->getLocale(), $type['id']]);

    }

    protected function storeBanner($values, $type, $banner)
    {

        $values['type_id'] = $type['id'];
        $values['author_id'] = auth()->user()->id;
        $bannerFillable = (new Banner)->getFillable();
        $bannerTransFillable = (new BannerTranslation)->getFillable();
        // Validator::validate($values, genValidation($type['fields']['nonTrans']));
        if (isset($values['thumb']) && ($values['thumb'] != '')) {

            $newfileName = uniqid().'.'.$values['thumb']->getClientOriginalExtension();
            $orignalName = $values['thumb']->getClientOriginalName();
            $values['thumb']->move(config('config.image_path'), $newfileName);
            $values['thumb'] = $newfileName;
            $values['filename'] = $orignalName;
        }
        $values['additional'] = getAdditional($values, array_diff(array_keys($type['fields']['nonTrans']), $bannerFillable));

        foreach (locales() as $locale) {

                if (isset($values[$locale]['image']) && ($values[$locale]['image'] != '')) {

                    $newfileName = uniqid().'.'.$values[$locale]['image']->getClientOriginalExtension();
                    $orignalName = $values[$locale]['image']->getClientOriginalName();
                    $values[$locale]['image']->move(config('config.image_path'), $newfileName);
                    $values[$locale]['image'] = $newfileName;
                    $values[$locale]['filename'] = $orignalName;
                }

                if (isset($values[$locale]['slug'])) {
                $values[$locale]['slug'] = str_replace(' ', '', $values[$locale]['slug']);
                } else {
                $values[$locale]['slug'] = str_replace(' ', '', $values[$locale]['title']);
                }

                $values[$locale]['slug'] = str_replace(' ', '', $values[$locale]['slug']);

                Validator::validate($values[$locale], genValidation($type['fields']['trans']));

                $values[$locale]['locale_additional'] = getAdditional($values[$locale], array_diff(array_keys($type['fields']['trans']), $bannerTransFillable));

        }
        if (isset($banner) && $banner !== null) {

            $allOldFiles = BannerFile::where('banner_id', $banner->id)->get();

            foreach ($allOldFiles as $key => $fil) {
                if (isset($values['old_file']) && count($values['old_file']) > 0) {
                if (! in_array($fil->id, array_keys($values['old_file']))) {
                    $fil->delete();
                }
                } else {
                $fil->delete();
                }

            }
            Banner::find($banner->id)->update($values);

        } else {
            $banner = Banner::create($values);
        }

        if (isset($values['files']) && count($values['files']) > 0) {
            if ($values['file']->getSize() > 2097152) {
                return redirect()->back()->with('error', 'File size is greater than 2MB.');
            }
            foreach ($values['files'] as $key => $files) {
                foreach ($files['file'] as $k => $file) {
                    $bannerFile = new BannerFile;
                    $bannerFile->file = $file;
                    $bannerFile->banner_id = $banner->id;
                    $bannerFile->save();
                }
            }
        }
    }

    public function CheckSlug(Request $request)
    {

        $locale = $request->locale;

        $slug = $request->slug;

        $id = $request->id;

        if (BannerTranslation::where('slug', $slug)->where('locale', $locale)->where('banner_id', '!=', $id)->exists()) {

            return response()->json(['error' => 'This slug already exists'], 401);
        } else {
            return response()->json(['message' => 'Slug is available'], 200);
        }

        return response()->json(['Slug' => $slug]);
     }

     public function deleteImage($id)
     {
         $banner = Banner::findOrFail($id);
         $locale = request('locale'); // Get the locale parameter from the request

         // Find translation for the specified locale
         $translation = $banner->translations()->where('locale', $locale)->first();

         if (isset($translation)) {
             // Delete image file for this translation
             $imagePath = config('config.image_path').'/'.$translation->image;
             if (File::exists($imagePath)) {
                 File::delete($imagePath);
             }

             // Remove image from database for this translation
             $translation->image = null;
             $translation->save();

             return response()->json(['success' => true]);
         } else {
            $imagePath = config('config.image_path').'/'.$banner->thumb;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            // Remove image from database for this translation
            $banner->thumb = null;
            $banner->save();

             return response()->json(['success' => false, 'message' => 'Translation not found']);
         }
     }
}
