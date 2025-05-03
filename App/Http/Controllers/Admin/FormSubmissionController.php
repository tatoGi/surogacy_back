<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
    public function index()
    {
        $submissions = FormSubmission::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.form-submissions.index', compact('submissions'));
    }

    public function show(FormSubmission $submission)
    {
        return view('admin.form-submissions.show', compact('submission'));
    }

    public function destroy(FormSubmission $submission)
    {
        $submission->delete();
        return redirect()->route('admin.form-submissions.index', app()->getLocale())
            ->with('success', __('admin.submission_deleted_successfully'));
    }
}
