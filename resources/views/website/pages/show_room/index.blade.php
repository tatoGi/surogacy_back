@extends('website.master')

@section('main')
<div class="container">
    <div class="image-list">
        <div class="row" id="big-slider">
            @foreach($posts as $post)
            @if (isset($post->files) && count($post->files) > 0)
                @foreach ($post->files as $image)
                <div class="item_block col-4 col-md-3 col-sm-6 col-xs-6 shorooomwmodule">
                    <a data-fancybox="gallery" href="{{ image($image->file) }}" class="boxhref highslide">
                        <img src="{{ image($image->file) }}" alt="{{ $post->translate(app()->getlocale())->title }}" class="img-fluid p-2"> <!-- Added p-2 class for padding -->
                    </a>
                </div>
                @endforeach
            @endif
            @endforeach
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Fancybox.bind('[data-fancybox="gallery"]', {
            loop: false,
            thumbs: true
        });
    });
</script>
@endsection

@push('styles')
<style>
    .image-item {
        display: block;
        text-align: center;
    }

    .image-item img {
        max-width: 100%; /* Ensure images don't exceed container width */
        height: auto;
    }
</style>
@endpush
