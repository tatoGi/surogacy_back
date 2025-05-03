<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Vendor js -->
<script src="{{ asset('admin/js/vendor.min.js') }}"></script>

<!--Morris Chart-->
<script src="{{ asset('admin/libs/morris-js/morris.min.js') }}"></script>
<script src="{{ asset('admin/libs/raphael/raphael.min.js') }}"></script>

<!-- knob plugin -->
<script src="{{ asset('admin/libs/jquery-knob/jquery.knob.min.js') }}"></script>

@filemanagerScript

<!-- ckeditor script -->
<script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"></script>

<script>
    const {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Font,
        Paragraph
    } = CKEDITOR;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all elements with class 'ckeditor'
        const editorElements = document.querySelectorAll('.ckeditor');

        editorElements.forEach(element => {
            ClassicEditor
                .create(element, {
                    licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3Njk3MzExOTksImp0aSI6ImY2OWFjNjk3LTM0OWUtNDY2Mi05MTRkLWViMzAxYmZmOTYzOCIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6IjI5MTQ5MWFlIn0.kkXZSZYgfAzFiWd9VRMXEaSa0d2_2zjTYezjt4By6iOztaR_AiY_-zehvTHqoXg_prWfec_YzTg9K0NQ1svcCw',
                    plugins: [Essentials, Bold, Italic, Font, Paragraph],
                    toolbar: [
                        'undo', 'redo', '|', 'bold', 'italic', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                    ]
                })
                .then(editor => {
                    console.log('Editor initialized successfully', editor);
                })
                .catch(error => {
                    console.error('Error initializing editor:', error);
                });
        });
    });
</script>

<script src="{{ asset('admin/js/app.min.js') }}"></script>
<script src="{{ asset('admin/js/script.js') }}"></script>

<!-- Form editor init -->
<script src="{{ asset('admin/js/pages/form-editor.init.js') }}"></script>

@stack('scripts')

{!! ToastMagic::scripts() !!}

<!-- Dashboard init js-->
{{-- <script src="{{ asset('admin/js/pages/dashboard.init.js') }}"></script> --}}

<!-- App js -->
