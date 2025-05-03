@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.form_submission_details') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.form-submissions.index' , ['locale' => app()->getLocale()]) }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> {{ __('admin.back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>{{ __('admin.personal_information') }}</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>{{ __('admin.form_type') }}</th>
                                    <td>{{ $submission->form_type === 'surrogate' ? __('admin.surrogate') : __('admin.parent') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('admin.first_name') }}</th>
                                    <td>{{ $submission->first_name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('admin.last_name') }}</th>
                                    <td>{{ $submission->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('admin.email') }}</th>
                                    <td>{{ $submission->email }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('admin.phone') }}</th>
                                    <td>{{ $submission->phone }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('admin.location') }}</th>
                                    <td>{{ $submission->location }}</td>
                                </tr>
                                @if($submission->form_type === 'surrogate')
                                <tr>
                                    <th>{{ __('admin.age') }}</th>
                                    <td>{{ $submission->age }}</td>
                                </tr>
                                @endif
                                @if($submission->form_type === 'parent')
                                <tr>
                                    <th>{{ __('admin.parent_type') }}</th>
                                    <td>{{ $submission->parent_type }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>{{ __('admin.message') }}</h4>
                            <div class="p-3 bg-light">
                                {{ $submission->message }}
                            </div>
                            <div class="mt-4">
                                <h4>{{ __('admin.submission_details') }}</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>{{ __('admin.submitted_at') }}</th>
                                        <td>{{ $submission->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('admin.terms_accepted') }}</th>
                                        <td>{{ $submission->terms_accepted ? __('admin.yes') : __('admin.no') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('admin.form-submissions.destroy', ['locale' => app()->getLocale(), 'submission' => $submission]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('admin.are_you_sure') }}')">
                            <i class="fas fa-trash"></i> {{ __('admin.delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
