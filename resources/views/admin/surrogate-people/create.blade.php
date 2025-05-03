@extends('admin.layouts.app')

@section('styles')
    <!-- Plugins css -->
    <link href="{{ asset('/admin/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/libs/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/admin/libs/multiselect/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/admin/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/admin/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/admin/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/admin/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('/admin/libs/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <style>
        .danger {
            border: 1px solid rgb(239, 83, 80) !important;
        }

        .ck.ck-editor__main>.ck-editor__editable {
            min-height: 200px
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-danger ul {
            margin-bottom: 0;
            padding-left: 20px;
        }

        .validation-error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .field-error {
            border-color: #dc3545 !important;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin: 10px;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .image-wrapper {
            position: relative;
            display: inline-block;
        }

        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }
    </style>
@endsection

@if($errors->any())
    <div class="alert alert-danger">
        <h4 class="alert-heading">Validation Error!</h4>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <h4 class="alert-heading">Error!</h4>
        <p>{{ session('error') }}</p>
    </div>
@endif

@if(config('app.debug'))
    @if(session('errors'))
        <div class="alert alert-info">
            <h4 class="alert-heading">Debug Information</h4>
            <pre>{{ print_r(session('errors'), true) }}</pre>
        </div>
    @endif
@endif

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Create Surrogate Person</h4>
            <form action="/{{ app()->getLocale() }}/admin/surrogations" method="POST" data-parsley-validate novalidate enctype="multipart/form-data">
                @csrf

                <!-- Common Fields -->
                <div class="form-group">
                    <label for="code">Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                           id="code" name="code" value="{{ old('code') }}"
                           required pattern="[A-Z]{2}-[A-Z][0-9]{3}"
                           title="Please enter code in format: GE-T372"
                           data-parsley-pattern="[A-Z]{2}-[A-Z][0-9]{3}"
                           data-parsley-pattern-message="Code must be in format: GE-T372">
                    <small class="form-text text-muted">Enter code in format: GE-T372 (2 uppercase letters, hyphen, 1 uppercase letter, 3 numbers)</small>
                    @error('code')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="age">Age <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('age') is-invalid @enderror"
                           id="age" name="age" value="{{ old('age') }}"
                           required min="18" max="100"
                           data-parsley-type="integer"
                           data-parsley-min="18"
                           data-parsley-max="100">
                    @error('age')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="height">Height (cm) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('height') is-invalid @enderror"
                           id="height" name="height" value="{{ old('height') }}"
                           required min="0" max="300"
                           data-parsley-type="number"
                           data-parsley-min="0"
                           data-parsley-max="300">
                    @error('height')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="weight">Weight (kg) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror"
                           id="weight" name="weight" value="{{ old('weight') }}"
                           required min="0" max="500"
                           data-parsley-type="number"
                           data-parsley-min="0"
                           data-parsley-max="500">
                    @error('weight')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="blood_type">Blood Type <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('blood_type') is-invalid @enderror"
                           id="blood_type" name="blood_type" value="{{ old('blood_type') }}"
                           required maxlength="10"
                           data-parsley-maxlength="10">
                    @error('blood_type')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image Upload Section -->
                <div class="form-group">
                    <label for="images">Images</label>
                    <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                           id="images" name="images[]" multiple
                           accept="image/jpeg,image/png,image/jpg,image/gif">
                    <small class="form-text text-muted">You can select multiple images. Maximum file size: 2MB</small>
                    @error('images.*')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div id="image-preview" class="image-container"></div>
                </div>

                <!-- Language Tabs -->
                <ul class="nav nav-tabs">
                    @foreach (config('app.locales') as $locale)
                    <li class="nav-item">
                        <a href="#locale-{{ $locale }}" data-toggle="tab" aria-expanded="false" class="nav-link @if($locale == app()->getLocale()) active @endif">
                            <span class="d-none d-sm-block">{{ trans('admin.locale_'.$locale) }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach (config('app.locales') as $locale)
                    <div role="tabpanel" class="tab-pane fade @if($locale == app()->getLocale()) active show @endif" id="locale-{{ $locale }}">
                        <div class="form-group">
                            <label for="{{ $locale }}-title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.title') is-invalid @enderror" id="{{ $locale }}-title" name="{{ $locale }}[title]" value="{{ old($locale.'.title') }}" required>
                            @error($locale.'.title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.name') is-invalid @enderror" id="{{ $locale }}-name" name="{{ $locale }}[name]" value="{{ old($locale.'.name') }}" required>
                            @error($locale.'.name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-surname">Surname <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.surname') is-invalid @enderror" id="{{ $locale }}-surname" name="{{ $locale }}[surname]" value="{{ old($locale.'.surname') }}" required>
                            @error($locale.'.surname')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-slug">Slug</label>
                            <input type="text" class="form-control unique-slug @error($locale.'.slug') is-invalid @enderror" id="{{ $locale }}-slug" name="{{ $locale }}[slug]" value="{{ old($locale.'.slug') }}" data-locale="{{ $locale }}" required>
                            <span class="print-error-msg"></span>
                            @error($locale.'.slug')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-nationality">Nationality <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.nationality') is-invalid @enderror"
                                   id="{{ $locale }}-nationality" name="{{ $locale }}[nationality]"
                                   value="{{ old($locale.'.nationality') }}" required maxlength="255"
                                   data-parsley-maxlength="255">
                            @error($locale.'.nationality')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-hair_color">Hair Color <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.hair_color') is-invalid @enderror"
                                   id="{{ $locale }}-hair_color" name="{{ $locale }}[hair_color]"
                                   value="{{ old($locale.'.hair_color') }}" required maxlength="255"
                                   data-parsley-maxlength="255">
                            @error($locale.'.hair_color')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-eye_color">Eye Color <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.eye_color') is-invalid @enderror"
                                   id="{{ $locale }}-eye_color" name="{{ $locale }}[eye_color]"
                                   value="{{ old($locale.'.eye_color') }}" required maxlength="255"
                                   data-parsley-maxlength="255">
                            @error($locale.'.eye_color')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-skin_complexion">Skin Complexion <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.skin_complexion') is-invalid @enderror"
                                   id="{{ $locale }}-skin_complexion" name="{{ $locale }}[skin_complexion]"
                                   value="{{ old($locale.'.skin_complexion') }}" required maxlength="255"
                                   data-parsley-maxlength="255">
                            @error($locale.'.skin_complexion')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-education">Education <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.education') is-invalid @enderror"
                                   id="{{ $locale }}-education" name="{{ $locale }}[education]"
                                   value="{{ old($locale.'.education') }}" required maxlength="255"
                                   data-parsley-maxlength="255">
                            @error($locale.'.education')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-marital_status">Marital Status <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.marital_status') is-invalid @enderror"
                                   id="{{ $locale }}-marital_status" name="{{ $locale }}[marital_status]"
                                   value="{{ old($locale.'.marital_status') }}" required maxlength="255"
                                   data-parsley-maxlength="255">
                            @error($locale.'.marital_status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-race">Race <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.race') is-invalid @enderror"
                                   id="{{ $locale }}-race" name="{{ $locale }}[race]"
                                   value="{{ old($locale.'.race') }}" required maxlength="255"
                                   data-parsley-maxlength="255">
                            @error($locale.'.race')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-donation_experience">Donation Experience <span class="text-danger">*</span></label>
                            <textarea class="form-control ckeditor @error($locale.'.donation_experience') is-invalid @enderror"
                                      id="{{ $locale }}-donation_experience" name="{{ $locale }}[donation_experience]"
                                      rows="3" required>{{ old($locale.'.donation_experience') }}</textarea>
                            @error($locale.'.donation_experience')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="form-group text-right mb-0">
                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="save-button">Create Surrogate Person</button>
                    <a href="/{{ app()->getLocale() }}/admin/surrogations" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Parsley
            $('form').parsley({
                locale: '{{ app()->getLocale() }}'
            });

            // Handle Parsley validation events
            $('form').on('parsley:field:error', function(parsleyField) {
                var fieldName = parsleyField.$element.attr('name');
                var tabId = $("input[name='" + fieldName + "']").closest('.tab-pane').attr('id');
                $("a[href='#" + tabId + "']").addClass('danger');
            });

            $('form').on('parsley:field:success', function(parsleyField) {
                var fieldName = parsleyField.$element.attr('name');
                var tabId = $("input[name='" + fieldName + "']").closest('.tab-pane').attr('id');
                $("a[href='#" + tabId + "']").removeClass('danger');
            });

            // Handle input changes
            $("input").on("input", function() {
                if ($(this).val().length > 0) {
                    var tabId = $(this).closest('.tab-pane').attr('id');
                    $("a[href='#" + tabId + "']").removeClass('danger');
                }
            });

            // Handle save button click
            $(document).on('click', 'button[name="save"]', function() {
                $(".danger").removeClass("danger");
            });

            // Initialize CKEditor
            $('.ckeditor').each(function() {
                CKEDITOR.replace(this, {
                    height: 300,
                    removePlugins: 'elementspath,resize',
                    toolbar: [
                        { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                        { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                        { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                        '/',
                        { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
                        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                        { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak' ] },
                        '/',
                        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] }
                    ]
                });
            });

            // Handle image preview
            $('#images').on('change', function() {
                var files = this.files;
                var preview = $('#image-preview');
                preview.empty();

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var wrapper = $('<div class="image-wrapper"></div>');
                        var img = $('<img class="image-preview">').attr('src', e.target.result);
                        var removeBtn = $('<div class="remove-image"><i class="fas fa-times"></i></div>');

                        wrapper.append(img);
                        wrapper.append(removeBtn);
                        preview.append(wrapper);
                    }

                    reader.readAsDataURL(file);
                }
            });

            // Handle image removal
            $(document).on('click', '.remove-image', function() {
                $(this).closest('.image-wrapper').remove();
            });
        });

        function slugify(text) {
            return text.toString()
                .toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        }

        function generateSlug(title, locale) {
            var slug = slugify(title);
            $('#' + locale + '-slug').val(slug).blur();
        }

        @foreach (config('app.locales') as $locale)
        $('#{{ $locale }}-title').on('change', function() {
            var title = $(this).val().trim();
            var slug = $('#{{ $locale }}-slug').val().trim();
            if (slug === '') {
                generateSlug(title, '{{ $locale }}');
            }
        });
        @endforeach

        $('.unique-slug').on('change', function(){
            $(this).val(slugify($(this).val()));
        });

        $('.unique-slug').on("blur", function (){
            const $input = $(this);
            const locale = $input.data('locale');
            const slug = $input.val();
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url:("/{{ app()->getLocale() }}/admin/check-slug"),
                data: {slug: slug, _token: token, locale},
                success: function(data) {
                    $input.parent().find('.print-error-msg').html('').css('color', '');
                    const btn = $('#save-button');
                    btn.css('pointer-events', 'initial');
                },
                error: function(data) {
                    $input.parent().find('.print-error-msg').html(data.responseJSON.error).css('color', 'red');
                    const btn = $('#save-button');
                    btn.css('pointer-events', 'none');
                }
            });
        });
    </script>
@endpush
