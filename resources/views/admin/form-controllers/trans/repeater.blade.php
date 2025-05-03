@php
    $fieldName = $field['name'] ?? '';
    $fieldLabel = $field['label'] ?? '';
    $fieldValue = $field['value'] ?? [];
    $fieldFields = $field['fields'] ?? [];
    $languages = config('app.locales', []);
@endphp

<div class="form-group">
    <label>{{ $fieldLabel }}</label>
    <div class="repeater-container" data-field-name="{{ $fieldName }}">
        @if(!empty($fieldValue))
            @foreach($fieldValue as $index => $item)
                <div class="repeater-item mb-3 p-3 border rounded">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Item #{{ $index + 1 }}</h5>
                        <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                    </div>
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($languages as $lang)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                   data-toggle="tab"
                                   href="#{{ $fieldName }}_{{ $index }}_{{ $lang }}"
                                   role="tab">
                                    {{ strtoupper($lang) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content p-3 border border-top-0">
                        @foreach($languages as $lang)
                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}"
                                 id="{{ $fieldName }}_{{ $index }}_{{ $lang }}"
                                 role="tabpanel">
                                @foreach($fieldFields as $subFieldName => $subField)
                                    <div class="form-group">
                                        <label>{{ ucfirst($subFieldName) }}</label>
                                        @if($subField['type'] === 'text')
                                            <input type="text"
                                                   name="{{ $fieldName }}[{{ $index }}][{{ $lang }}][{{ $subFieldName }}]"
                                                   value="{{ $item[$lang][$subFieldName] ?? '' }}"
                                                   class="form-control"
                                                   required>
                                        @elseif($subField['type'] === 'textarea')
                                            <textarea name="{{ $fieldName }}[{{ $index }}][{{ $lang }}][{{ $subFieldName }}]"
                                                      class="form-control ckeditor"
                                                      required>{{ $item[$lang][$subFieldName] ?? '' }}</textarea>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
        <button type="button" class="btn btn-primary add-item">Add New Item</button>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        const container = $('.repeater-container');
        const addButton = container.find('.add-item');
        const fieldName = container.data('field-name');
        const fields = @json($fieldFields);
        const languages = @json($languages);

        // Initialize CKEditor for existing textareas
        $('.ckeditor').each(function() {
            CKEDITOR.replace(this);
        });

        addButton.on('click', function() {
            const index = container.find('.repeater-item').length;
            let html = `
                <div class="repeater-item mb-3 p-3 border rounded">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Item #${index + 1}</h5>
                        <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                    </div>
                    <ul class="nav nav-tabs" role="tablist">
                        ${languages.map((lang, i) => `
                            <li class="nav-item">
                                <a class="nav-link ${i === 0 ? 'active' : ''}"
                                   data-toggle="tab"
                                   href="#${fieldName}_${index}_${lang}"
                                   role="tab">
                                    ${lang.toUpperCase()}
                                </a>
                            </li>
                        `).join('')}
                    </ul>
                    <div class="tab-content p-3 border border-top-0">
                        ${languages.map((lang, i) => `
                            <div class="tab-pane ${i === 0 ? 'active' : ''}"
                                 id="${fieldName}_${index}_${lang}"
                                 role="tabpanel">
                                ${Object.keys(fields).map(field => {
                                    const fieldConfig = fields[field];
                                    return `
                                        <div class="form-group">
                                            <label>${field.charAt(0).toUpperCase() + field.slice(1)}</label>
                                            ${fieldConfig.type === 'text' ? `
                                                <input type="text"
                                                       name="${fieldName}[${index}][${lang}][${field}]"
                                                       class="form-control"
                                                       required>
                                            ` : fieldConfig.type === 'textarea' ? `
                                                <textarea name="${fieldName}[${index}][${lang}][${field}]"
                                                          class="form-control ckeditor"
                                                          required></textarea>
                                            ` : ''}
                                        </div>
                                    `;
                                }).join('')}
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
            container.find('.add-item').before(html);

            // Initialize CKEditor for the newly added textareas
            const newTextareas = container.find('.repeater-item:last-child .ckeditor');
            newTextareas.each(function() {
                CKEDITOR.replace(this);
            });
        });

        container.on('click', '.remove-item', function() {
            const item = $(this).closest('.repeater-item');
            // Destroy CKEditor instances before removing the item
            item.find('.ckeditor').each(function() {
                const editor = CKEDITOR.instances[$(this).attr('id')];
                if (editor) {
                    editor.destroy();
                }
            });
            item.remove();
            // Renumber items
            container.find('.repeater-item').each(function(index) {
                $(this).find('h5').text(`Item #${index + 1}`);
            });
        });
    });
</script>
@endpush