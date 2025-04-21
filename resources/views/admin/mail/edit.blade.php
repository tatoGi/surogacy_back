@extends('admin.layouts.app')


@section('content')
<div class="row">
    <div class="col-xl-12">
            <div class="card-box">
                <h4 class="header-title mt-0 mb-3">{{ trans('admin.edit_post') }}</h4>
                <form class="emailers-form"  action="/{{ app()->getLocale() }}/admin/mailers/update/{{$post->id}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <label for="image">Name</label>
                    <input type="text" name="title" value="{{$post->title}}">
                    <label for="image">Slug</label>
                    <input type="text" name="buttonslug" value="{{$post->buttonslug}}">
                    <label for="image">Description</label>
                    <textarea type="text" name="desc" placeholder="{{$post->desc}}"></textarea>
                    <div class="form-group">
                        <label for="image">Choose Image</label>
                        
                        <span><input id="image" type="file" name="thumb" >{{$post->thumb}}</span>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('/admin/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />  
    <!-- Plugins css -->
    <link href="{{ asset('/admin/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/libs/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('/admin/libs/multiselect/multi-select.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('/admin/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/admin/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/libs/switchery/switchery.min.css') }}" rel="stylesheet" />
    
    <link href="{{ asset('/admin/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/admin/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/admin/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('/admin/libs/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">


        <style>
            .danger{
                border: 1px solid rgb(239, 83, 80) !important;
            }
            .emailers-form input{
                width: 100%;
                height: 40px;
                border: 1px solid #ced4da;
            }
            .emailers-form label{
                margin-top: 5px
            }
            .card-box{
                height: 600px;
            }
        </style>
@endpush

@push('scripts')

<script src="{{ asset('/admin/js/dropupload.js') }}"></script>

    

    <!-- Validation js (Parsleyjs) -->
    <script src="{{ asset('admin/libs/parsleyjs/parsley.min.js') }}"></script>

    <!-- validation init -->
    <script src="{{ asset('admin/js/pages/form-validation.init.js') }}"></script>

   
    <!-- init js -->
    {{-- <script src="{{ asset('admin/js/pages/form-editor.init.js') }}"></script> --}}


    <!-- Plugins Js -->
    <script src="{{ asset('/admin/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/multiselect/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('/admin/libs/jquery-quicksearch/jquery.quicksearch.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('/admin/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/admin/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>


    
    <!-- Init js-->
    <script src="{{ asset('/admin/js/pages/form-advanced.init.js') }}"></script>

@endpush