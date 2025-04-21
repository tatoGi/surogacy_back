<section class="burger-menu">
    <div class="burger-div">
        <div class="search">
            <input type="text" placeholder="Search">
            <button> <span class="icon-Group-9991"></span></button>
        </div>
        <div class="burger-nav">
            @if (isset($sections) && count($sections) > 0)
            @foreach ($sections as $section)
            <div class="burger-nav_cont @if($language_slugs[app()->getLocale()] == $section->getFullSlug()) activediv @endif ">
                <a class="burger-nav_link" href="/{{ $section->getFullSlug() }}">{{ $section->translate(app()->getlocale())->title }} </a> <span id="burgerarrov" class="icon-material-symbols_arrow-back-ios-new-rounded burgerarrov"></span>
                @if ($section->children->count() > 0)
                <div class="burger-nav_submenu">
                    <div>
                        @foreach ($section->children as $subSec)
                        <a href="/{{ $subSec->getFullSlug() }}">{{ $subSec->translate(app()->getlocale())->title }}</a>
                        @endforeach
                    </div>

                </div>
                @endif
            </div>
            @endforeach
            @endif
           <!--  <div class="burger-nav_cont">
                <a class="burger-nav_link" href="#">Publications</a> <span class="icon-material-symbols_arrow-back-ios-new-rounded burgerarrov"></span>
                <div class="burger-nav_submenu">
                    <div>
                        <a href="#">Our Mission</a>
                    </div>
                    <div>
                        <a href="#">Our Vision</a>
                    </div>
                    <div>
                        <a href="#">Our History</a>
                    </div>
                    <div>
                        <a href="#">What We DoWhat We Do WhatDoWhat We Do What</a>
                    </div>
                    <div>
                        <a href="#">What we Offer</a>
                    </div>
                </div>
            </div>
            <div class="burger-nav_cont">
                <a class="burger-nav_link" href="#">Updates Updates Updates Updates</a> <span class="icon-material-symbols_arrow-back-ios-new-rounded burgerarrov"></span>
            </div>
            <div class="burger-nav_cont">
                <a class="burger-nav_link" href="#">EU vs DiSiNFO</a>
            </div>
            <div class="burger-nav_cont">
                <a class="burger-nav_link" href="#">Campaigns</a>
            </div>
            <div class="burger-nav_cont">
                <a class="burger-nav_link" href="#">Contact</a>
            </div> -->
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