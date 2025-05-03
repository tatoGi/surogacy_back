<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public static function subscribe(Request $request)
    {

        $email = $request->validate([
            'email' => 'required|email',

        ]);
        $subscriber = Subscription::where('email', $email)->first();
        if ($subscriber == null) {
            $subscription = new Subscription;
            $subscription->locale = app()->getLocale();
            $subscription->email = $email['email'];

            $subscription->save();

            return redirect()->back()->with([
                'subscribe' => trans('website.successfuly_subscribed'),
            ]);

        } else {
            $subscriber !== null;

            return redirect()->back()->with([
                'subscribe' => trans('website.allready_subscribed'),
            ]);

        }

    }

    public static function submission(Request $request)
    {
        $values = request()->all();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if (isset($values['file']) && ($values['file'] != null)) {
                $newfileName = uniqid().'.'.$values['file']->getClientOriginalExtension();
                $orignalName = $values['file']->getClientoriginalname();
                $values['file']->move(config('config.file_path'), $newfileName);
                $values['file'] = '';
                $values['file'] = $newfileName;
                $values['filename'] = $orignalName;
            }

            // Convert message to text for database
            $values['text'] = $values['message'];
            unset($values['message']);

            $values['additional'] = getAdditional($values, config('submissionAttr.additional'));

            // Get the contact page post ID
            $contactPost = \App\Models\Post::join('sections', 'posts.section_id', '=', 'sections.id')
                ->where('sections.type_id', 2)
                ->select('posts.*')
                ->first();

            $values['post_id'] = $contactPost ? $contactPost->id : 1; // Fallback to 1 if no contact post found

            $submission = Submission::create($values);

            return response()->json([
                'success' => true,
                'message' => trans('website.submission_sent')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again.'
            ], 500);
        }
    }
}
