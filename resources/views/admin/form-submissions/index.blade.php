@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.form_submissions') }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead></thead>
                                <tr>
                                    <th>{{ __('admin.form_type') }}</th>
                                    <th>{{ __('admin.name') }}</th>
                                    <th>{{ __('admin.email') }}</th>
                                    <th>{{ __('admin.phone') }}</th>
                                    <th>{{ __('admin.location') }}</th>
                                    <th>{{ __('admin.date') }}</th>
                                    <th>{{ __('admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->form_type === 'surrogate' ? __('admin.surrogate') : __('admin.parent') }}</td>
                                    <td>{{ $submission->first_name }} {{ $submission->last_name }}</td>
                                    <td>{{ $submission->email }}</td>
                                    <td>{{ $submission->phone }}</td>
                                    <td>{{ $submission->location }}</td>
                                    <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.form-submissions.show', ['locale' => app()->getLocale(), 'submission' => $submission]) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.form-submissions.destroy', ['locale' => app()->getLocale(), 'submission' => $submission]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('admin.are_you_sure') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
