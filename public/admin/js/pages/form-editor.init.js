document.addEventListener('DOMContentLoaded', function() {
    // Initialize snow editor
    const snowEditor = document.querySelector('#snow-editor');
    if (snowEditor) {
        ClassicEditor
            .create(snowEditor, {
                licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3Njk3MzExOTksImp0aSI6ImY2OWFjNjk3LTM0OWUtNDY2Mi05MTRkLWViMzAxYmZmOTYzOCIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6IjI5MTQ5MWFlIn0.kkXZSZYgfAzFiWd9VRMXEaSa0d2_2zjTYezjt4By6iOztaR_AiY_-zehvTHqoXg_prWfec_YzTg9K0NQ1svcCw',
                plugins: [Essentials, Bold, Italic, Font, Paragraph],
                toolbar: [
                    'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                    'alignment', '|',
                    'numberedList', 'bulletedList', '|',
                    'link', 'image', '|',
                    'clean'
                ]
            })
            .then(editor => {
                console.log('Snow editor initialized successfully', editor);
            })
            .catch(error => {
                console.error('Error initializing snow editor:', error);
            });
    }

    // Initialize bubble editor
    const bubbleEditor = document.querySelector('#bubble-editor');
    if (bubbleEditor) {
        ClassicEditor
            .create(bubbleEditor, {
                licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3Njk3MzExOTksImp0aSI6ImY2OWFjNjk3LTM0OWUtNDY2Mi05MTRkLWViMzAxYmZmOTYzOCIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6IjI5MTQ5MWFlIn0.kkXZSZYgfAzFiWd9VRMXEaSa0d2_2zjTYezjt4By6iOztaR_AiY_-zehvTHqoXg_prWfec_YzTg9K0NQ1svcCw',
                plugins: [Essentials, Bold, Italic, Font, Paragraph],
                toolbar: [
                    'bold', 'italic', 'underline', '|',
                    'fontSize', 'fontColor', '|',
                    'link'
                ]
            })
            .then(editor => {
                console.log('Bubble editor initialized successfully', editor);
            })
            .catch(error => {
                console.error('Error initializing bubble editor:', error);
            });
    }
});
