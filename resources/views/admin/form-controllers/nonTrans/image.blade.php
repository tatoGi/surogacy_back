<div class="form-group mt-20">
    <div class="row">
        <div class="col-lg-6">
            <label>{{ trans('admin.' . $key) }}</label> <br>
            <input type="file" name="thumb" accept="image/*" class="form-control">
            @if(isset($post) && isset($post->thumb))
                <input type="hidden" name="old_thumb" value="{{ $post->thumb }}">
            @endif
        </div>
        @if (isset($post) && isset($post->thumb))
            <div class="col-lg-6 imagePreview">
                <div class="image-container">
                    <img src="{{ asset(config('config.image_path') . 'thumb/' . $post->thumb) }}"
                        class="slide_image" alt="Preview">
                    <button type="button" class="delete-image" data-id="{{ $post->id }}" data-token="{{ csrf_token() }}"
                        data-route="{{ route('post.delete-image', [app()->getLocale(), $post->id]) }}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.delete-image').on('click', function(e) {
            e.preventDefault();
            var Url = $(this).data('route');
            var TOKEN = $(this).data('token');
            var id = $(this).data('id');

            if (confirm("დოკუმენტის წაშლა!?")) {
                $.ajax({
                    url: Url,
                    method: 'DELETE',
                    data: {
                        _token: TOKEN,
                        id: id
                    },
                    success: function(response) {
                        if(response.success) {
                            $('.image-container').fadeOut(300, function() {
                                $(this).remove();
                            });
                            // Clear the file input
                            $('input[name="thumb"]').val('');
                        }
                    },
                    error: function(error) {
                        console.error('Error deleting image:', error);
                        alert('Error deleting image. Please try again.');
                    }
                });
            }
        });
    });
</script>

<style>
    .imagePreview {
        margin-top: 10px;
    }

    .image-container {
        position: relative;
        display: inline-block;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .slide_image {
        max-width: 200px;
        max-height: 200px;
        object-fit: contain;
        border-radius: 3px;
        display: block;
    }

    .delete-image {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #dc3545;
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }

    .delete-image:hover {
        background-color: #c82333;
        transform: scale(1.1);
    }

    .delete-image i {
        font-size: 14px;
    }

    input[type="file"] {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 100%;
        max-width: 300px;
    }

    input[type="file"]:hover {
        border-color: #80bdff;
    }
</style>
