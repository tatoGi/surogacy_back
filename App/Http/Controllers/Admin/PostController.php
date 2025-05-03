<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail;
use App\Models\Post;
use App\Models\PostFile;
use App\Models\PostTranslation;
use App\Models\Section;
use App\Models\Slug;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index($sec)
    {
        $section = Section::where('id', $sec)->with('translations')->first();

        if (isset($section->type) && in_array($section->type['type'], [6, 2])) {
            $post = Post::where('section_id', $sec)->with(['translations', 'slugs'])->first();
            if (isset($post) && $post !== null) {
                return Redirect::route('post.edit', [app()->getLocale(), $post->id]);
            }

            return Redirect::route('post.create', [app()->getLocale(), $sec]);
        }
        $posts = Post::where('section_id', $sec)->orderBy('date', 'desc')->orderBy('created_at', 'asc')
        ->join('post_translations', 'posts.id', '=', 'post_translations.post_id')
        ->where('post_translations.locale', '=', app()->getLocale())

        ->select('posts.*', 'post_translations.text', 'post_translations.desc', 'post_translations.title', 'post_translations.locale_additional', 'post_translations.slug');

        $posts = $posts->with(['translations', 'slugs'])->paginate(settings('Paginate'));

        return view('admin.posts.list', compact(['section', 'posts']));
    }

    public function create($sec)
    {
        $section = Section::where('id', $sec)->with('translations')->first();

        return view('admin.posts.add', compact(['section']));
    }

    public function store($sec, Request $request)
    {

        $section = Section::where('id', $sec)->with('translations')->first();
        $values = $request->all();
        $values['section_id'] = $sec;
        $values['author_id'] = auth()->user()->id;
        $postFillable = (new Post)->getFillable();
        $postTransFillable = (new PostTranslation)->getFillable();


        $values['additional'] = getAdditional($values, array_diff(array_keys($section->fields['nonTrans']), $postFillable));
        foreach (config('app.locales') as $locale) {
            if (isset($values[$locale]['slug'])) {
                $values[$locale]['slug'] = str_replace(' ', '-', $values[$locale]['slug']);
            } else {
                // If no slug is provided, use the title as the slug
                $values[$locale]['slug'] = str_replace(' ', '-', $values[$locale]['title']);
            }

            if (isset($values[$locale]['file']) && $values[$locale]['file'] != '') {
                if ($values[$locale]['file']->getSize() > 2097152) {
                    return redirect()->back()->with('error', 'File size is greater than 2MB.');
                }
                $newfileName = uniqid().'.'.$values[$locale]['file']->getClientOriginalExtension();
                $orignalName = $values[$locale]['file']->getClientoriginalname();
                $values[$locale]['file']->move(config('config.file_path'), $newfileName);
                $values[$locale]['file'] = '';
                $values[$locale]['file'] = $newfileName;
                $values[$locale]['filename'] = $orignalName;
                if (isset($values[$locale]['old_file'])) {
                    // Delete the old file if it exists
                    Storage::delete(config('config.file_path').$values[$locale]['old_file']);
                }
            }
            if (isset($values[$locale]['image']) && $values[$locale]['image'] != '') {
                if ($values[$locale]['image']->getSize() > 2097152) {
                    return redirect()->back()->with('error', 'File size is greater than 2MB.');
                }
                $newimageName = uniqid().'.'.$values[$locale]['image']->getClientOriginalExtension();
                $orignalName = $values[$locale]['image']->getClientoriginalname();
                $values[$locale]['image']->move(config('config.image_path'), $newimageName);
                $values[$locale]['image'] = $newimageName;
                $values[$locale]['imagename'] = $orignalName;
                if (isset($values[$locale]['old_image'])) {
                    // Delete the old file if it exists
                    Storage::delete(config('config.image_path').$values[$locale]['old_image']);
                }
            }

            $fullslug[$locale] = $locale.'/'.$values[$locale]['slug'];

            $values[$locale]['locale_additional'] = getAdditional($values[$locale], array_diff(array_keys($section->fields['trans']), $postTransFillable));
        }
        $post = Post::create($values);
        foreach (config('app.locales') as $locale) {
            $post->translateOrNew($locale)->slug = $values[$locale]['slug'];

            $post->save();
            $post->slugs()->create([
                'fullSlug' => $locale.'/'.$values[$locale]['slug'],
                'slugable_id' => $post->id,
                'locale' => $locale,
            ]);
        }

        if (isset($values['files']) && count($values['files']) > 0) {
            foreach ($values['files'] as $key => $files) {
                foreach ($files['file'] as $k => $file) {
                    $postFile = new PostFile;
                    $postFile->type = $key;
                    $postFile->file = $file;

                    $postFile->post_id = $post->id;
                    $postFile->save();
                }
            }
        }

        return Redirect::route('post.list', [app()->getLocale(), $section->id]);
    }

    public function edit($id)
    {
        $post = Post::where('id', $id)->with(['translations', 'files'])->first();
        // dd($post);
        $section = Section::where('id', $post->section_id)->with('translations')->first();

        return view('admin.posts.edit', compact('section', 'post'));
    }

    public function update($id, Request $request)
    {
        $post = Post::where('id', $id)->with('translations', 'files')->first();
        $section = Section::where('id', $post->section_id)->with('translations')->first();

        // Delete existing slugs for the post
        Post::find($id)->slugs()->delete();

        $values = $request->all();
        $values['section_id'] = $section->id;
        $values['author_id'] = auth()->user()->id;
        $postFillable = (new Post)->getFillable();
        $postTransFillable = (new PostTranslation)->getFillable();

        // Handle main image upload
        if ($request->hasFile('thumb')) {
            if ($request->file('thumb')->getSize() > 2097152) {
                return redirect()->back()->with('error', 'File size is greater than 2MB.');
            }

            // Create thumb directory if it doesn't exist
            $thumbPath = config('config.image_path') . 'thumb/';
            if (!File::exists($thumbPath)) {
                File::makeDirectory($thumbPath, 0755, true);
            }

            $newfileName = uniqid().'.'.$request->file('thumb')->getClientOriginalExtension();
            $request->file('thumb')->move($thumbPath, $newfileName);
            $values['thumb'] = $newfileName;

            // Delete old thumb if exists
            if ($post->thumb) {
                Storage::delete($thumbPath . $post->thumb);
            }
        }

        // Get additional values for non-translatable fields
        $values['additional'] = getAdditional($values, array_diff(array_keys($section->fields['nonTrans']), $postFillable));

        foreach (config('app.locales') as $locale) {
            if (isset($values[$locale]['slug']) && isset($post[$locale]->slug) && $values[$locale]['slug'] != $post[$locale]->slug) {
                $values[$locale]['slug'] = str_replace(' ', '-', $values[$locale]['slug']);
            }

            // Handle file upload for this language
            if (isset($values[$locale]['file']) && ($values[$locale]['file'] != '')) {
                if ($values[$locale]['file']->getSize() > 2097152) {
                    return redirect()->back()->with('error', 'File size is greater than 2MB.');
                }
                $newfileName = uniqid().'.'.$values[$locale]['file']->getClientOriginalExtension();
                $values[$locale]['file']->move(config('config.file_path'), $newfileName);
                $values[$locale]['file'] = $newfileName;
            } elseif (isset($values[$locale]['old_file'])) {
                $values[$locale]['file'] = $values[$locale]['old_file'];
            } else {
                $values[$locale]['file'] = $post[$locale]->file;
            }

            if (isset($values[$locale]['image']) && ($values[$locale]['image'] != '')) {
                if ($values[$locale]['image']->getSize() > 2097152) {
                    return redirect()->back()->with('error', 'File size is greater than 2MB.');
                }

                // Generate unique filename
                $newfileName = uniqid().'.'.$values[$locale]['image']->getClientOriginalExtension();
                $originalName = $values[$locale]['image']->getClientOriginalName();

                // Move file to uploads directory
                $values[$locale]['image']->move(config('config.image_path'), $newfileName);

                // Save only the filename in the database
                $values[$locale]['image'] = $newfileName;
                $values[$locale]['imagename'] = $originalName;

                // Delete old image if it exists
                if (isset($values[$locale]['old_image']) && $values[$locale]['old_image']) {
                    Storage::delete(config('config.image_path').$values[$locale]['old_image']);
                }
            } elseif (isset($values[$locale]['old_image'])) {
                $values[$locale]['image'] = $values[$locale]['old_image'];
            } else {
                $values[$locale]['image'] = $post[$locale]->image;
            }

            // Update slug for this language
            if (isset($post->translate($locale)->slug)) {
                $post->slugs()->updateOrCreate([
                    'locale' => $locale,
                ], [
                    'fullSlug' => $locale.'/'.$post->translate($locale)->slug,
                ]);
            }

            // Get additional values for translatable fields
            $values[$locale]['locale_additional'] = getAdditional($values[$locale], array_diff(array_keys($section->fields['trans']), $postTransFillable));
        }

        $allOldFiles = PostFile::where('post_id', $post->id)->get();

        foreach ($allOldFiles as $key => $fil) {
            if (isset($values['old_file']) && count($values['old_file']) > 0) {
                if (!in_array($fil->id, array_keys($values['old_file']))) {
                    $fil->delete();
                } else {
                    $fil->save();
                }
            } else {
                $fil->delete();
            }
        }

        if (isset($values['files']) && count($values['files']) > 0) {
            foreach ($values['files'] as $key => $files) {
                foreach ($files['file'] as $k => $file) {
                    $postFile = new PostFile;
                    $postFile->type = $key;
                    $postFile->file = $file;
                    $postFile->post_id = $post->id;
                    $postFile->save();
                }
            }
        }

        Post::find($post->id)->update($values);

        return redirect()->back();
    }

    public function destroy($id)
    {

        $post = Post::where('id', $id)->first();
        // foreach (Post::find($id)->slugs()->get() as $slug) {

        //     // Post::find($id)->delete();
        // }
        $section = Section::where('id', $post->section_id)->with('translations')->first();

        $files = PostFile::where('post_id', $post->id)->get();
        foreach ($files as $file) {

            if (file_exists(config('config.image_path').$file->file)) {
                unlink(config('config.image_path').$file->file);
                } else {
                dd('File does not exists.');
                }
                if (file_exists(config('config.image_path').'thumb/'.$file->file)) {
                    unlink(config('config.image_path').'thumb/'.$file->file);
                    } else {
                    dd('File does not exists.');
                    }
            $file->delete();
        }
        PostTranslation::where('post_id', $post->id)->delete();
        Post::find($id)->slugs()->delete();
        $post->delete();

        return Redirect::route('post.list', [app()->getLocale(), $section->id]);
    }

    public function DeleteFile(Request $request)
    {
        $lang = $request->lang;
        $que = $request->que;
        $post = Post::where('id', $que)->whereHas('translations', function ($q) use ($lang) {
            $q->where('locale', $lang);
        })->with('translation')->first();

        $localeAdditional = $post->$lang->locale_additional;

        if (isset($localeAdditional['image']) && file_exists(config('config.image_path').$localeAdditional['image'])) {
            unlink(config('config.image_path').$localeAdditional['image']);
            unset($localeAdditional['image']);
        }

        if (isset($localeAdditional['file']) && file_exists(config('config.file_path').$localeAdditional['file'])) {
            unlink(config('config.file_path').$localeAdditional['file']);
            unset($localeAdditional['file']);
        }

        $post->$lang->locale_additional = $localeAdditional;
        $post->save();

        return response()->json(['success' => 'Files Deleted']);
    }

         public function sendNewsletter($post)
         {
            $post = Post::where('id', $post)->with('translations', 'files')->first();

            $subscribers = Subscription::all();

            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)->queue(new NewsletterMail($post));
            }

             return redirect()->back()->with('success', 'Newsletter sent successfully!');
         }
         public function deleteImage($id)
    {
        $post = Post::findOrFail($id);

        if ($post->thumb) {
            $imagePath = public_path(config('config.image_path') . config('config.thumb_path') . $post->thumb);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $post->update(['thumb' => null]);
        }

        return response()->json(['success' => 'File Deleted']);
    }
}
