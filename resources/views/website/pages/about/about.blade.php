@extends('website.master')

@section('content')
    <!-- About Hero Section -->
    <section class="about-hero">
        <div class="container">
            <h1>{{ $model->translate(app()->getlocale())->title }}</h1>
        </div>
    </section>

    <!-- Story Section -->
    <section class="story-section">
        <div class="story-content">
            <div class="photo-collage">
                <img src="{{ asset('uploads/img/thumb/' . $post->files[0]->file) }}" alt="SurrogateFirst Journey" class="img-fluid">
            </div>
            <div class="story-text">
                <h2 class="story-title">{{ $model->translate(app()->getlocale())->title }}</h2>
                <p class="story-paragraph">
                    {!! $model->translate(app()->getlocale())->text !!}
                </p>

            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section py-5">
        <div class="container">
            <h1 class="text-center mb-5 team-title">{{ $team->translate(app()->getlocale())->title }}</h1>
            <div class="row justify-content-center">
                @foreach ($team->posts as $member)
                <div class="col-lg-8 mb-5">
                    <div class="team-member-large">
                        <div class="member-photo-wrapper">
                            <img src="{{ asset('uploads/img/thumb/' . $member->thumb) }}" alt="{{ $member->translate(app()->getlocale())->title }}" class="member-photo">
                        </div>
                        <div class="member-info">
                            <h2 class="member-name">{{ $member->translate(app()->getlocale())->title }}</h2>
                            <p class="member-position">{{ $member->translate(app()->getlocale())->position }}</p>
                            <div class="member-description">
                                {!! $member->translate(app()->getlocale())->text !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
    .team-title {
        color: #B88E8E;
        font-size: 3rem;
        margin-bottom: 3rem;
    }

    .team-member-large {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .member-photo-wrapper {
        width: 300px;
        height: 300px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 2rem;
        background: #f8f9fa;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .member-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .member-photo:hover {
        transform: scale(1.05);
    }

    .member-name {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .member-position {
        font-size: 1.5rem;
        color: #B88E8E;
        margin-bottom: 1.5rem;
        font-weight: 500;
    }

    .member-description {
        color: #666;
        font-size: 1.1rem;
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .member-photo-wrapper {
            width: 250px;
            height: 250px;
        }

        .member-name {
            font-size: 2rem;
        }

        .member-position {
            font-size: 1.2rem;
        }

        .member-description {
            font-size: 1rem;
            padding: 0 20px;
        }
    }
    </style>
@endsection
