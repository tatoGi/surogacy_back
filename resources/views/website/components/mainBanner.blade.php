@if(isset($mainBanner) && $mainBanner->count() > 0)

<section class="banner fade-in">
    <div class="container text-center">
            <h1 class="banner-title">{{ $mainBanner->first()->translate(app()->getLocale())->title }}</h1>

        <div class="banner-images d-flex justify-content-center flex-wrap position-relative">
            <button class="btn btn-danger banner-left-button slide-in-left" data-bs-toggle="modal" data-bs-target="#surrogateModal">{{ settings('banner_surrogate_button') }}</button>
            @if(isset($mainBanner) && $mainBanner->count() > 0)
                @foreach($mainBanner->first()->files as $file)

                    <div class="banner-image slide-in-top">
                        <a href="{{ asset('uploads/img/' . $file->file) }}" data-fancybox="banner-gallery" data-caption="Banner Image">
                            <img src="{{ asset('uploads/img/' . $file->file) }}" alt="Banner Image" class="img-fluid">
                        </a>
                    </div>
                @endforeach
            @endif
            <button class="btn btn-primary banner-right-button slide-in-right" data-bs-toggle="modal" data-bs-target="#parentModal">{{ settings('banner_parent_button') }}</button>
        </div>
    </div>
</section>
@endif