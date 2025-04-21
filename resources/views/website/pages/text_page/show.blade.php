@extends('website.master')
@section('main')
<div class="wraps hover_shine" id="content">
    <div class="wrapper_inner front wide_page">
        <div class="middle ">
            <div class="wrapper_inner wide_page">
                <div class="middle ">
                    <div class="container">
                        <div class="maxwidth-theme">
                            <div class="detail news fixed_wrapper">
                                <div class="inner-page about-page-container">
                                    <section class="inner-content-section" style="padding-top: 10px;">
                                        <div class="">
                                            <div class="top-block myimage-pupup popup-img" style="padding-top: 10px;">
                                                <div class="left-block col-md-5" id="popupcont"
                                                    style="margin-left:10px;">
                                                    <div class="slick-list">
                                                        <div class="slick-track">
                                                            <div class="item popup-button"
                                                                href="{{ image($post->thumb) }}">
                                                                <a onclick="return hs.expand(this)" class="highslide"
                                                                    href="{{ image($post->thumb) }}"
                                                                    style="cursor:zoom-in">
                                                                    <img src="{{ image($post->thumb) }}" style="cursor:zoom-in"
                                                                        alt="{{ $post->translate(app()->getlocale())->title }}">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="right-block">
                                                    <div class="hidden-xs">
                                                        <div class="text-wr fade-top js-anim">
                                                            <h1
                                                                style="margin-bottom:10px; font-weight:bold;">
                                                                {{ $post->translate(app()->getlocale())->title }} </h1>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                       {!!  $post->translate(app()->getlocale())->text  !!}
                                                    </div>
                                                    <div class="popup-buttons-wr">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
