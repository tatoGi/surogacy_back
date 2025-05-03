<!-- Footer Section -->
<footer class="footer fade-in">
    <div class="container">
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="{{ settings('header_logo')['url'] ?? '' }}" alt="Surrogate First Logo" class="img-fluid" style="height: 80px;">
                <p class="footer-tagline">Helping families one blessing at a time.</p>
            </div>
            @foreach($footerSections as $section)
            <div class="col-md-3">
                <h5>{{ $section->translate(app()->getLocale())->title }}</h5>
                <ul class="footer-links">
                    @foreach($section->children as $child)
                        <li><a href="/{{ $child->getFullSlug() }}">{{ $child->translate(app()->getLocale())->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
        <div class="footer-bottom text-center mt-4">
            <div class="social-icons">
                @if(settings('facebook_url'))
                    <a href="{{ settings('facebook_url') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                @endif
                @if(settings('instagram_url'))
                    <a href="{{ settings('instagram_url') }}" target="_blank"><i class="fab fa-instagram"></i></a>
                @endif
                @if(settings('tiktok_url'))
                    <a href="{{ settings('tiktok_url') }}" target="_blank"><i class="fab fa-tiktok"></i></a>
                @endif
            </div>
            <p class="mt-3">{{ trans('website.all_rights_reserved') }}</p>
        </div>
    </div>
</footer>