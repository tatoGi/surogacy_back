@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Edit Surrogate Person</h4>
            <form action="{{ route('admin.surrogations.update', [app()->getLocale(), $surrogatePeople->id]) }}" method="POST" data-parsley-validate novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Common Fields -->
                <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $surrogatePeople->code) }}" required pattern="[a-zA-Z0-9]+" title="Please enter only letters and numbers">
                    <small class="form-text text-muted">Enter a unique code for this surrogate person (e.g., t12323t)</small>
                    @error('code')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" value="{{ old('age', $surrogatePeople->age) }}" required min="18">
                    @error('age')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="height">Height (cm)</label>
                    <input type="number" step="0.01" class="form-control @error('height') is-invalid @enderror" id="height" name="height" value="{{ old('height', $surrogatePeople->height) }}" required>
                    @error('height')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $surrogatePeople->weight) }}" required>
                    @error('weight')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="blood_type">Blood Type</label>
                    <input type="text" class="form-control @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type" value="{{ old('blood_type', $surrogatePeople->blood_type) }}" required>
                    @error('blood_type')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="active">Status</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ old('active', $surrogatePeople->active) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="active">Active</label>
                    </div>
                    @error('active')
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

                    <!-- Existing Images -->
                    @if($surrogatePeople->images->count() > 0)
                        <div class="mt-3">
                            <h5>Existing Images</h5>
                            <div class="existing-images">
                                @foreach($surrogatePeople->images as $image)
                                    <div class="existing-image">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Surrogate Image">
                                        <button type="button" class="remove-image" data-image-id="{{ $image->id }}" title="Remove image">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <input type="hidden" name="delete_images[]" value="{{ $image->id }}" class="delete-image-input">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
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
                            <input type="text" class="form-control @error($locale.'.title') is-invalid @enderror" id="{{ $locale }}-title" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $surrogatePeople->translate($locale)->title) }}" required>
                            @error($locale.'.title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.name') is-invalid @enderror" id="{{ $locale }}-name" name="{{ $locale }}[name]" value="{{ old($locale.'.name', $surrogatePeople->translate($locale)->name) }}" required>
                            @error($locale.'.name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-surname">Surname <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error($locale.'.surname') is-invalid @enderror" id="{{ $locale }}-surname" name="{{ $locale }}[surname]" value="{{ old($locale.'.surname', $surrogatePeople->translate($locale)->surname) }}" required>
                            @error($locale.'.surname')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-slug">Slug</label>
                            <input type="text" class="form-control unique-slug @error($locale.'.slug') is-invalid @enderror" id="{{ $locale }}-slug" name="{{ $locale }}[slug]" value="{{ old($locale.'.slug', $surrogatePeople->translate($locale)->slug) }}" data-locale="{{ $locale }}" required>
                            <span class="print-error-msg"></span>
                            @error($locale.'.slug')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-nationality">Nationality</label>
                            <input type="text" class="form-control @error($locale.'.nationality') is-invalid @enderror" id="{{ $locale }}-nationality" name="{{ $locale }}[nationality]" value="{{ old($locale.'.nationality', $surrogatePeople->translate($locale)->nationality) }}" required>
                            @error($locale.'.nationality')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-hair_color">Hair Color</label>
                            <input type="text" class="form-control @error($locale.'.hair_color') is-invalid @enderror" id="{{ $locale }}-hair_color" name="{{ $locale }}[hair_color]" value="{{ old($locale.'.hair_color', $surrogatePeople->translate($locale)->hair_color) }}" required>
                            @error($locale.'.hair_color')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-eye_color">Eye Color</label>
                            <input type="text" class="form-control @error($locale.'.eye_color') is-invalid @enderror" id="{{ $locale }}-eye_color" name="{{ $locale }}[eye_color]" value="{{ old($locale.'.eye_color', $surrogatePeople->translate($locale)->eye_color) }}" required>
                            @error($locale.'.eye_color')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-skin_complexion">Skin Complexion</label>
                            <input type="text" class="form-control @error($locale.'.skin_complexion') is-invalid @enderror" id="{{ $locale }}-skin_complexion" name="{{ $locale }}[skin_complexion]" value="{{ old($locale.'.skin_complexion', $surrogatePeople->translate($locale)->skin_complexion) }}" required>
                            @error($locale.'.skin_complexion')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-education">Education</label>
                            <input type="text" class="form-control @error($locale.'.education') is-invalid @enderror" id="{{ $locale }}-education" name="{{ $locale }}[education]" value="{{ old($locale.'.education', $surrogatePeople->translate($locale)->education) }}" required>
                            @error($locale.'.education')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-marital_status">Marital Status</label>
                            <input type="text" class="form-control @error($locale.'.marital_status') is-invalid @enderror" id="{{ $locale }}-marital_status" name="{{ $locale }}[marital_status]" value="{{ old($locale.'.marital_status', $surrogatePeople->translate($locale)->marital_status) }}" required>
                            @error($locale.'.marital_status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-race">Race</label>
                            <input type="text" class="form-control @error($locale.'.race') is-invalid @enderror" id="{{ $locale }}-race" name="{{ $locale }}[race]" value="{{ old($locale.'.race', $surrogatePeople->translate($locale)->race) }}" required>
                            @error($locale.'.race')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="{{ $locale }}-donation_experience">Donation Experience</label>
                            <textarea class="form-control ckeditor @error($locale.'.donation_experience') is-invalid @enderror" id="{{ $locale }}-donation_experience" name="{{ $locale }}[donation_experience]" rows="3" required>{{ old($locale.'.donation_experience', $surrogatePeople->translate($locale)->donation_experience) }}</textarea>
                            @error($locale.'.donation_experience')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="form-group text-right mb-0">
                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="save-button">Update Surrogate Person</button>
                    <a href="/{{ app()->getLocale() }}/admin/surrogations" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        console.log('Document ready');

        // Handle image preview
        $('#images').on('change', function() {
            console.log('Image input changed');
            var files = this.files;
            var preview = $('#image-preview');
            preview.empty();

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function(e) {
                    var wrapper = $('<div class="image-wrapper"></div>');
                    var img = $('<img class="image-preview">').attr('src', e.target.result);
                    var removeBtn = $('<button type="button" class="remove-image" title="Remove image"><i class="fas fa-times"></i></button>');

                    wrapper.append(img);
                    wrapper.append(removeBtn);
                    preview.append(wrapper);
                }

                reader.readAsDataURL(file);
            }
        });

        // Handle new image removal
        $(document).on('click', '.image-wrapper .remove-image', function(e) {
            console.log('New image remove clicked');
            e.preventDefault();
            e.stopPropagation();
            var $wrapper = $(this).closest('.image-wrapper');
            $wrapper.fadeOut(300, function() {
                $wrapper.remove();
            });
        });

        // Handle existing image removal
        $(document).on('click', '.existing-image .remove-image', function(e) {
            console.log('Existing image remove clicked');
            e.preventDefault();
            e.stopPropagation();
            var $imageContainer = $(this).closest('.existing-image');
            var imageId = $(this).data('image-id');
            console.log('Image ID:', imageId);

            // Add to delete_images array if not already present
            if (!$('input[name="delete_images[]"][value="' + imageId + '"]').length) {
                var input = $('<input>').attr({
                    type: 'hidden',
                    name: 'delete_images[]',
                    value: imageId,
                    class: 'delete-image-input'
                });
                $('form').append(input);
            }

            // Visual feedback
            $imageContainer.addClass('removed');
            $(this).hide();
        });

        // Initialize Parsley with options
        window.Parsley.setLocale('{{ app()->getLocale() }}');
        $('form').parsley({
            errorsContainer: function(ParsleyField) {
                return ParsleyField.$element.siblings('.invalid-feedback');
            },
            errorsWrapper: '<div class="invalid-feedback"></div>',
            errorTemplate: '<span></span>'
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

        // Initialize CKEditor with unique instance names
        @foreach (config('app.locales') as $locale)
        if (CKEDITOR.instances['{{ $locale }}-donation_experience']) {
            CKEDITOR.instances['{{ $locale }}-donation_experience'].destroy();
        }
        CKEDITOR.replace('{{ $locale }}-donation_experience', {
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
        @endforeach

        // Add passive event listeners for touch events
        document.addEventListener('touchstart', function() {}, {passive: true});
        document.addEventListener('touchmove', function() {}, {passive: true});
        document.addEventListener('mousewheel', function() {}, {passive: true});
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
@endsection


