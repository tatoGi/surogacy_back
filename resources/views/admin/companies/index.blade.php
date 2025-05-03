@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('companies.Companies') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.companies.create' , app()->getLocale()) }}" class="btn btn-primary btn-sm">
                            {{ __('companies.Add New Company') }}
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
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('companies.Name') }}</th>
                                <th>{{ __('companies.Country') }}</th>
                                <th>{{ __('companies.Phone') }}</th>
                                <th>{{ __('companies.Email') }}</th>
                                <th>{{ __('companies.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                                <tr>
                                    <td>{{ $company->id }}</td>
                                    <td>{{ $company->translate(app()->getLocale())->name }}</td>
                                    <td>{{ $company->translate(app()->getLocale())->country }}</td>
                                    <td>{{ $company->phone }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>
                                        <a href="{{ route('admin.companies.edit', [app()->getLocale(), $company->id]) }}" class="btn btn-info btn-sm">
                                            {{ __('companies.Edit') }}
                                        </a>
                                        <form action="{{ route('admin.companies.destroy', [app()->getLocale(), $company->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('companies.Are you sure?') }}')">
                                                {{ __('companies.Delete') }}
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
