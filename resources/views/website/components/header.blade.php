<div class="top-header fade-in">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="header-buttons">
            <button class="btn btn-outline-danger rounded-pill me-2">{{ settings('header_get_started_button') }}</button>
            <button class="btn btn-outline-danger rounded-pill">{{ settings('header_contact_button') }}</button>
        </div>
        <div class="d-flex align-items-center">
            <div class="social-icons me-4">
                @if (settings('facebook') != '')
                    <a href="{{ settings('facebook') }}" target="blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                @endif
                @if (settings('twitter') != '')
                    <a href="{{ settings('twitter') }}" target="blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                @endif
                @if (settings('instagram') != '')
                    <a href="{{ settings('instagram') }}" target="blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                @endif
            </div>
            <div class="language-selector">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary rounded-pill dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(app()->getLocale() == 'ka')
                            ქართული
                        @else
                            ENGLISH
                        @endif
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        @foreach (config('app.locales') as $k => $value)
                            <li><a class="dropdown-item" href="@if (isset($language_slugs) && is_array($language_slugs) && isset($language_slugs[$value])) {{ asset($language_slugs[$value]) }} @else {{ $k }} @endif">{{ __('website.' . $value) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @auth('company')
                <div class="company-menu ms-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary rounded-pill dropdown-toggle" type="button" id="companyDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::guard('company')->user()->name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="companyDropdown">
                            <li><a class="dropdown-item" href="/{{ app()->getLocale() }}/company/profile">{{ __('admin.Profile') }}</a></li>
                            <li>
                                <form action="/{{ app()->getLocale() }}/company/logout" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="redirect" value="/{{ app()->getLocale() }}">
                                    <button type="submit" class="dropdown-item">{{ __('admin.Logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <div class="company-auth ms-3">
                    <button type="button" class="btn btn-outline-primary rounded-pill me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                        {{ __('admin.Login') }}
                    </button>
                </div>
            @endauth
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">{{ __('admin.Company_Login') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/{{ app()->getLocale() }}/company/login">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('admin.email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('admin.password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('admin.Remember Me') }}
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            {{ __('admin.Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<header class="main-header fade-in">
    <div class="container d-flex align-items-center justify-content-between position-relative">
        <div class="logo">
            <a href="{{ URL::to('/') }}/{{ app()->getLocale() }}">
                @if(settings('header_logo'))
                    <img src="{{ settings('header_logo')['url'] }}" alt="Surrogate First Logo" class="img-fluid" style="height: 80px;">
                @endif
            </a>
        </div>

        <button class="burger-menu d-lg-none" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="navigation">
            <ul class="nav">
                @foreach($sections as $section)
                    @if($section->type_id != 7 || auth()->guard('company')->check())
                        <li class="nav-item {{ $section->children->count() > 0 ? 'menu-item-has-children' : '' }}">
                            <a class="nav-link" href="/{{ $section->getFullSlug() }}">
                                {{ $section->translate(app()->getLocale())->title }}
                                @if($section->children->count() > 0)
                                    <span>▼</span>
                                @endif
                            </a>
                            @if($section->children->count() > 0)
                                <ul class="sub-menu">
                                    @foreach($section->children as $child)
                                        <li class="menu-item">
                                            <a href="/{{ $child->getFullSlug() }}">
                                                {{ $child->translate(app()->getLocale())->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>

        </nav>
        <div class="header-search">
            <form action="{{ route('search', app()->getLocale()) }}" method="GET" class="search-form">
                <input type="text" name="q" placeholder="Search..." class="search-input">
                <button type="submit" class="search-button">
                    <span class="icon-Group-9991"></span>
                </button>
            </form>
        </div>
    </div>
</header>

<section class="burger-menu">
    <div class="burger-div">
        <div class="search">
            <input type="text" placeholder="Search">
            <button> <span class="icon-Group-9991"></span></button>
        </div>
        <div class="burger-nav">
            @foreach($sections as $section)
                <div class="burger-nav_cont @if(isset($language_slugs) && is_array($language_slugs) && isset($language_slugs[app()->getLocale()]) && $language_slugs[app()->getLocale()] == $section->getFullSlug()) activediv @endif">
                    <a class="burger-nav_link" href="/{{ $section->getFullSlug() }}">
                        {{ $section->translate(app()->getLocale())->title }}
                    </a>
                    @if($section->children->count() > 0)
                        <span id="burgerarrov" class="icon-material-symbols_arrow-back-ios-new-rounded burgerarrov"></span>
                        <div class="burger-nav_submenu">
                            <div>
                                @foreach($section->children as $child)
                                    <a href="/{{ $child->getFullSlug() }}">
                                        {{ $child->translate(app()->getLocale())->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="header1_div2">
            @if (settings('facebook') != '')
                <a href="{{ settings('facebook') }}" target="blank">
                    <span class="icon-Path-171"></span>
                </a>
            @endif
            @if (settings('twitter') != '')
                <a href="{{ settings('twitter') }}" target="blank">
                    <span class="icon-Path-172"></span>
                </a>
            @endif
            @if (settings('instagram') != '')
                <a href="{{ settings('instagram') }}" target="blank">
                    <span class="icon-Path-173"></span>
                </a>
            @endif
        </div>
    </div>
</section>
