@extends('website.master')

@section('main')

@if(isset($model))
<section class="contact-container">
    <div class="container">
        <div class="contact">
            <div class="contact-cont1">
                <div class="contact-display-none">
                    <div class="contact-title">
                        <span>{{$model->translate(app()->getlocale())->title}}</span>
                    </div>
                    <div class="contact-text">{!! $model->translate(app()->getlocale())->desc !!} </div>
                </div>
                <form action="/{{$model->getFullSlug()}}" method="POST" novalidate>
                    @csrf
                <div class="contact-form">
                    <div class="cont-inputs">
                        <label class="star" for="cont-name">{{ trans('website.full_name') }}</label>
                        <input id="cont-name" type="text" name="name">
                        <input type="hidden" name="post_id" value="{{$post->id ?? ''}}">
                    </div>
                    <div class="cont-inputs">
                        <label class="star" for="cont-mail">{{ trans('website.Mail') }}</label>
                        <input id="cont-mail" type="text"  name="email">
                    </div>
                    <div class="cont-inputs cont-input2">
                        <label for="cont-sub">{{ trans('website.subject') }}</label>
                        <input id="cont-sub" type="text"  name="subject">
                    </div>
                    <div class="cont-inputs cont-input2">
                        <label for="cont-text">{{ trans('website.text') }}</label>
                        <textarea name="text" id="cont-text" cols="30" rows="10"></textarea>
                    </div>
                    <div class="cont-inputs cont-input2 cont-button">
                        <button >{{ trans('website.send') }}</button>
                    </div>
                </div>
            </form>
            </div>

            <div class="contact-cont2">
                <h4>{{ trans('website.info') }}</h4>
                <a href="mailto:{{ $post->email ?? '' }}">
                    <span class="icon-Vector-3">
                        <i class="fas fa-envelope"></i> <!-- Font Awesome icon for mail -->
                    </span>
                    <span>{{$post->email ?? ''}}</span>
                </a>
                <a href="tel:{{ $post->phone ?? '' }}">
                    <span class="icon-Vector-4">
                        <i class="fas fa-phone"></i> <!-- Font Awesome icon for phone -->
                    </span>
                    <span>{{$post->phone ?? ''}}</span>
                </a>
                @if($post != null && $post->translate() != null)
                <a href="http://maps.google.com/?q={{$post->translate(app()->getlocale())->adress}}" target="_blank">
                    <span style="margin: 0 30px 0 0;">
                        <i class="fas fa-map-marker-alt" style="font-size: 45px;"></i> <!-- Font Awesome icon for location -->
                    </span>
                    <span>{{$post->translate(app()->getlocale())->adress ?? ''}}</span>
                </a>
                @endif
            </div>
            
        </div>
    </div>
</section>
@endif
@endsection