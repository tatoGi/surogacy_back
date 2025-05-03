@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Edit Company</h4>
            <form action="/{{ app()->getLocale() }}/admin/companies/{{ $company->id }}" method="POST" data-parsley-validate novalidate>
                @csrf
                @method('POST')

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
                            <label for="{{ $locale }}-name">Name</label>
                            <input type="text" class="form-control @error($locale.'.name') is-invalid @enderror" id="{{ $locale }}-name" name="{{ $locale }}[name]" value="{{ old($locale.'.name', $company->translate($locale)->name) }}" required>
                            @error($locale.'.name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-slug">Slug</label>
                            <input type="text" class="form-control unique-slug @error($locale.'.slug') is-invalid @enderror" id="{{ $locale }}-slug" name="{{ $locale }}[slug]" value="{{ old($locale.'.slug', $company->translate($locale)->slug) }}" data-locale="{{ $locale }}" required>
                            <span class="print-error-msg"></span>
                            @error($locale.'.slug')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-country">Country</label>
                            <input type="text" class="form-control @error($locale.'.country') is-invalid @enderror" id="{{ $locale }}-country" name="{{ $locale }}[country]" value="{{ old($locale.'.country', $company->translate($locale)->country) }}" required>
                            @error($locale.'.country')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-description">Description</label>
                            <textarea class="form-control ckeditor @error($locale.'.description') is-invalid @enderror" id="{{ $locale }}-description" name="{{ $locale }}[description]" rows="3">{{ old($locale.'.description', $company->translate($locale)->description) }}</textarea>
                            @error($locale.'.description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Common Fields -->
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $company->phone) }}" required>
                    @error('phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $company->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
                    <small class="form-text text-muted">Leave blank to keep current password</small>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                </div>

                <div class="form-group text-right mb-0">
                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="save-button">Update Company</button>
                    <a href="/{{ app()->getLocale() }}/admin/companies" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

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
    </style>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="{{ asset('admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core JS -->
    <script src="{{ asset('admin/js/vendor.min.js') }}"></script>
    <script src="{{ asset('admin/js/app.min.js') }}"></script>

    <!-- Parsley -->
    <script src="{{ asset('admin/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('admin/libs/parsleyjs/i18n/ka.js') }}"></script>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <!-- Plugins -->
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
    <script src="{{ asset('/admin/js/pages/form-validation.init.js') }}"></script>

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
                    removeButtons: 'PasteFromWord',
                    toolbarGroups: [
                        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                        { name: 'forms', groups: [ 'forms' ] },
                        '/',
                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                        { name: 'links', groups: [ 'links' ] },
                        { name: 'insert', groups: [ 'insert' ] },
                        '/',
                        { name: 'styles', groups: [ 'styles' ] },
                        { name: 'colors', groups: [ 'colors' ] },
                        { name: 'tools', groups: [ 'tools' ] },
                        { name: 'others', groups: [ 'others' ] }
                    ]
                });
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
        $('#{{ $locale }}-name').on('change', function() {
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
@endsection
