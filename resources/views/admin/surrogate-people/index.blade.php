@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Surrogate People</h3>
                    <div class="card-tools">
                        <form action="/{{ app()->getLocale() }}/admin/surrogations" method="GET" class="d-inline-block mr-2">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('Search surrogates...') }}" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <a href="/{{ app()->getLocale() }}/admin/surrogations/create" class="btn btn-primary btn-sm">
                            Add New Surrogate
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ __('surrogate.age') }}</th>
                                <th>{{ __('surrogate.title') }}</th>
                                <th>{{ __('surrogate.nationality') }}</th>
                                <th>{{ __('surrogate.height') }}</th>
                                <th>{{ __('surrogate.weight') }}</th>
                                <th>{{ __('surrogate.blood_type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($surrogatePeople as $surrogate)
                                <tr>
                                    <td>{{ $surrogate->id }}</td>
                                    <td>{{ $surrogate->age }}</td>
                                    <td>{{ $surrogate->translate(app()->getLocale())->title }}</td>
                                    <td>{{ $surrogate->translate(app()->getLocale())->nationality }}</td>
                                    <td>{{ $surrogate->height }}</td>
                                    <td>{{ $surrogate->weight }}</td>
                                    <td>{{ $surrogate->blood_type }}</td>
                                    <td>
                                        <form action="/{{ app()->getLocale() }}/admin/surrogations/{{ $surrogate->id }}/toggle-status" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $surrogate->active ? 'btn-success' : 'btn-danger' }}">
                                                {{ $surrogate->active ? __('Active') : __('Inactive') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="/{{ app()->getLocale() }}/admin/surrogations/{{ $surrogate->id }}/edit" class="btn btn-info btn-sm">
                                            {{ __('surrogate.edit') }}
                                        </a>
                                        <form action="/{{ app()->getLocale() }}/admin/surrogations/{{ $surrogate->id }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('Are you sure?') }}')">
                                                {{ __('surrogate.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
