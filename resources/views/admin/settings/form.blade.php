@if (isset($settings))


    <ul class="nav nav-tabs">

        @foreach (config('app.locales') as $locale)
            <li class="nav-item ">
                <a href="#locale-{{ $locale }}" data-toggle="tab" aria-expanded="false"
                    class="nav-link @if ($locale == app()->getLocale()) active @endif">
                    <span class="d-none d-sm-block">{{ trans('admin.locale_' . $locale) }}</span>
                </a>
            </li>
        @endforeach

    </ul>
    <div class="tab-content">
        @foreach (config('app.locales') as $locale)
            <div role="tabpanel" class="tab-pane fade @if ($locale == app()->getLocale()) active show @endif "
                id="locale-{{ $locale }}">
                @foreach (settingTransAttrs($settings) as $key => $field)

                    <div class="form-group">
                        {{ Form::label(trans('admin.' . $key), null, ['class' => 'control-label']) }}
                        @if (isset($field['type']) && $field['type'] == 'setting_files')
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="custom-file">

                                        @if (!empty($settings['logo']['value'][$locale]['name']))
                                            <div class="upload-logo">

                                                <div class="input-group-append">

                                                    <div class="img">
                                                        <img src="{{ asset(config('config.icon_path') . $settings['logo']['value'][$locale]['name']) }}"
                                                            alt="Logo">
                                                    </div>

                                                    <button class="btn btn-danger delete-file" type="button"
                                                        data-file="{{ $settings['logo']['value'][$locale]['name'] }}"
                                                        data-locale="{{ $locale }}" style="height: 40px;">
                                                        <i class="fa fa-trash"></i>
                                                    </button>

                                                </div>

                                            </div>
                                        @else
                                            <input type="file" name="[{{ $key }}][{{ $locale }}]"
                                                class="custom-file-input" id="logo_{{ $locale }}">
                                            <label class="custom-file-label"
                                                for="[{{ $key }}][{{ $locale }}]">{{ trans('admin.choose_file') }}</label>
                                        @endif
                                    </div>

                                </div>

                            </div>
                        @endif


                        @if (isset($field['type']) && $field['type'] == 'textarea')
                            {{ Form::textarea('translatables[' . $key . '][' . $locale . ']', $field['value'][$locale] ?? null, [
                                'class' => 'form-control ckeditor',
                            ]) }}
                        @elseif(isset($field['type']) && $field['type'] == 'text')
                            {{ Form::text('translatables[' . $key . '][' . $locale . ']', $field['value'][$locale], ['class' => 'form-control']) }}
                        @endif

                    </div>
                @endforeach

            </div>
        @endforeach
    </div>
    <br>
    @foreach (settingNonTransAttrs($settings) as $key1 => $field1)
        <div class="form-group">

            {{ Form::label(trans('admin.' . $key1), null, ['class' => 'control-label']) }}

            @if ($field1['title'] == 'eu_vs_disinfo')
                <div class="custom-file">
                    @if (!empty($settings['eu_vs_disinfo_logo']['value']))
                        <div class="upload-logo">
                            <div class="input-group-append">
                                <div class="img">
                                    <img src="{{ asset(config('config.icon_path') . $settings['eu_vs_disinfo_logo']['value']) }}"
                                        alt="Logo" style="width: 130px; height:130px;">
                                </div>
                                <button class="btn btn-danger delete-file" type="button" style="height: 40px;"
                                    data-file="{{ $settings['eu_vs_disinfo_logo']['value'] }}" data-locale="">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        <input type="file" name="{{ $key1 }}" class="custom-file-input"
                            id="logo_{{ $locale }}">
                        <label class="custom-file-label"
                            for="{{ $key1 }}">{{ trans('admin.choose_file') }}</label>
                    @endif
                </div>
            @endif

            @if ($field1['type'] == 'text')
                {{ Form::text('nonTranslatables[' . $key1 . ']', $field1['value'], array_merge(['class' => 'form-control'])) }}
            @endif
        </div>
    @endforeach
@endif

<div class="form-group text-right mb-0">
    <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
        {{ trans('admin.save') }}
    </button>
</div>
@push('scripts')
    <script>
        $(function() {
            $('.custom-file-input').on('change', function() {
                var input = $(this);
                var locale = input.attr('id').split('_')[1];
                var file = input[0].files[0];
                var inputName = input.attr('name');

                var formData = new FormData();
                formData.append('file', file);
                formData.append('locale', locale);
                formData.append('inputName', inputName);
                $.ajax({
                    url: '/' + locale + '/admin/settings/upload-file',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        input.closest('.form-group').find('.custom-file-label').html(response
                            .filename);
                    },
                    error: function() {
                        alert('Error uploading file');
                    }
                });
            });

            $('.delete-file').on('click', function() {
                var button = $(this);
                var locale = button.data('locale');
                var file = button.data('file');

                if (!confirm('Are you sure you want to delete this logo?')) {
                    return;
                }

                var pageurl = document.URL.substr(0, document.URL.lastIndexOf('/'));
                $.ajax({
                    url: pageurl + '/delete-file',
                    type: 'POST',
                    data: {
                        file: file,
                        locale: locale
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove the entire upload-logo div
                            button.closest('.upload-logo').remove();

                            // Add back the file input
                            var fileInput = $('<input>')
                                .attr('type', 'file')
                                .attr('name', locale ? '[logo][' + locale + ']' : 'eu_vs_disinfo_logo')
                                .addClass('custom-file-input')
                                .attr('id', 'logo_' + (locale || ''));

                            var label = $('<label>')
                                .addClass('custom-file-label')
                                .attr('for', 'logo_' + (locale || ''))
                                .text('{{ trans('admin.choose_file') }}');

                            button.closest('.custom-file').append(fileInput).append(label);

                            // Refresh the page to ensure all changes are reflected
                            location.reload();
                        } else {
                            alert('Error deleting file: ' + (response.error || 'Unknown error'));
                        }
                    },
                    error: function(xhr) {
                        alert('Error deleting file: ' + (xhr.responseJSON?.error || 'Unknown error'));
                    }
                });
            });

        });
    </script>
@endpush

@push('styles')
    <style>
        .custom-file {
            height: auto;
        }

        .form-a-img {
            margin-bottom: 80px;
        }

        .form-group1 {
            margin-bottom: 80px;
        }

        .upload-logo {
            margin-top: 55px;
        }
    </style>
@endpush
