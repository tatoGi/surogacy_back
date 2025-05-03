@php
    $fieldName = $field['name'] ?? '';
    $fieldLabel = $field['label'] ?? '';
    $fieldValue = $field['value'] ?? [];
    $fieldFields = $field['fields'] ?? [];
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
                    @foreach($fieldFields as $subFieldName => $subField)
                        <div class="form-group">
                            <label>{{ ucfirst($subFieldName) }}</label>
                            @if($subField['type'] === 'image')
                                <input type="file"
                                       name="{{ $fieldName }}[{{ $index }}][{{ $subFieldName }}]"
                                       class="form-control"
                                       accept="image/*">
                                @if(isset($item[$subFieldName]))
                                    <img src="{{ asset($item[$subFieldName]) }}"
                                         alt="Current image"
                                         class="mt-2"
                                         style="max-width: 200px;">
                                @endif
                            @endif
                        </div>
                    @endforeach
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

        addButton.on('click', function() {
            const index = container.find('.repeater-item').length;
            let html = `
                <div class="repeater-item mb-3 p-3 border rounded">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Item #${index + 1}</h5>
                        <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                    </div>
                    ${Object.keys(fields).map(field => {
                        const fieldConfig = fields[field];
                        return `
                            <div class="form-group">
                                <label>${field.charAt(0).toUpperCase() + field.slice(1)}</label>
                                ${fieldConfig.type === 'image' ? `
                                    <input type="file"
                                           name="${fieldName}[${index}][${field}]"
                                           class="form-control"
                                           accept="image/*">
                                ` : ''}
                            </div>
                        `;
                    }).join('')}
                </div>
            `;
            container.find('.add-item').before(html);
        });

        container.on('click', '.remove-item', function() {
            $(this).closest('.repeater-item').remove();
            // Renumber items
            container.find('.repeater-item').each(function(index) {
                $(this).find('h5').text(`Item #${index + 1}`);
            });
        });
    });
</script>
@endpush
