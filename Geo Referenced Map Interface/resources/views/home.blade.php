@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1>{{ __('messages.welcome_to_geo') }}</h1>
            <p>{{ __('messages.discover_and_manage_locations') }}</p>
            @auth
                <a href="{{ route('map') }}" class="btn btn-light btn-lg me-2">
                    <i class="fas fa-map"></i> {{ __('messages.explore_map') }}
                </a>
                <a href="{{ route('locations.create') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-plus"></i> {{ __('messages.add_location') }}
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-light btn-lg me-2">
                    <i class="fas fa-user-plus"></i> {{ __('messages.get_started') }}
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-sign-in-alt"></i> {{ __('messages.sign_in') }}
                </a>
            @endauth
        </div>
    </div>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('messages.key_features') }}</h2>
            <div class="row">
                <div class="col-md-4 mb-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h5>{{ __('messages.interactive_maps') }}</h5>
                    <p>{{ __('messages.feature_interactive_maps') }}</p>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h5>{{ __('messages.location_crud') }}</h5>
                    <p>{{ __('messages.feature_location_management') }}</p>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-api"></i>
                    </div>
                    <h5>{{ __('messages.rest_api') }}</h5>
                    <p>{{ __('messages.feature_rest_api') }}</p>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h5>{{ __('messages.search_filter') }}</h5>
                    <p>{{ __('messages.feature_search') }}</p>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <h5>{{ __('messages.image_upload') }}</h5>
                    <p>{{ __('messages.feature_image_upload') }}</p>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h5>{{ __('messages.categorization') }}</h5>
                    <p>{{ __('messages.feature_categorization') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>{{ __('messages.start_mapping_today') }}</h2>
                    <p>{{ __('messages.cta_description') }}</p>
                </div>
                <div class="col-md-6 text-end">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            {{ __('messages.create_account') }}
                        </a>
                    @else
                        <a href="{{ route('map') }}" class="btn btn-primary btn-lg">
                            {{ __('messages.open_map') }}
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>
@endsection
