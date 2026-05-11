@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h1 class="mb-4">{{ __('messages.about_project') }}</h1>

                <div class="card mb-4">
                    <div class="card-body">
                        <h3>{{ __('messages.project_overview') }}</h3>
                        <p>{{ __('messages.about_description') }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h3>{{ __('messages.technologies') }}</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{ __('messages.backend') }}</h5>
                                <ul>
                                    <li>Laravel 12</li>
                                    <li>PHP 8.2+</li>
                                    <li>MySQL Database</li>
                                    <li>Eloquent ORM</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>{{ __('messages.frontend') }}</h5>
                                <ul>
                                    <li>Bootstrap 5</li>
                                    <li>Blade Templates</li>
                                    <li>Leaflet.js</li>
                                    <li>OpenStreetMap</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h3>{{ __('messages.key_features') }}</h3>
                        <ul>
                            <li><strong>{{ __('messages.user_authentication') }}</strong> - {{ __('messages.secure_registration_login') }}</li>
                            <li><strong>{{ __('messages.location_management') }}</strong> - {{ __('messages.full_crud_operations') }}</li>
                            <li><strong>{{ __('messages.interactive_maps') }}</strong> - {{ __('messages.leaflet_openstreetmap') }}</li>
                            <li><strong>{{ __('messages.search_filter') }}</strong> - {{ __('messages.advanced_filtering') }}</li>
                            <li><strong>{{ __('messages.rest_api') }}</strong> - {{ __('messages.json_api_endpoints') }}</li>
                            <li><strong>{{ __('messages.localization') }}</strong> - {{ __('messages.english_hindi_support') }}</li>
                            <li><strong>{{ __('messages.image_upload') }}</strong> - {{ __('messages.location_image_support') }}</li>
                            <li><strong>{{ __('messages.responsive_design') }}</strong> - {{ __('messages.mobile_friendly') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h3>{{ __('messages.use_cases') }}</h3>
                        <ul>
                            <li>🏥 {{ __('messages.healthcare_facilities') }}</li>
                            <li>🏫 {{ __('messages.educational_institutions') }}</li>
                            <li>🍽️ {{ __('messages.restaurants_dining') }}</li>
                            <li>🎭 {{ __('messages.tourist_attractions') }}</li>
                            <li>🏢 {{ __('messages.office_locations') }}</li>
                            <li>🏞️ {{ __('messages.parks_recreation') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h3>{{ __('messages.api_documentation') }}</h3>
                        <p><strong>Base URL:</strong> <code>/api</code></p>
                        <p><strong>{{ __('messages.authentication') }}:</strong> Bearer Token (Sanctum)</p>
                        <h5>{{ __('messages.main_endpoints') }}</h5>
                        <ul>
                            <li><code>GET /api/locations</code> - {{ __('messages.get_all_locations') }}</li>
                            <li><code>POST /api/locations</code> - {{ __('messages.create_location') }}</li>
                            <li><code>GET /api/locations/{id}</code> - {{ __('messages.get_single_location') }}</li>
                            <li><code>PUT /api/locations/{id}</code> - {{ __('messages.update_location') }}</li>
                            <li><code>DELETE /api/locations/{id}</code> - {{ __('messages.delete_location') }}</li>
                            <li><code>GET /api/categories</code> - {{ __('messages.get_categories') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="text-center">
                    @auth
                        <a href="{{ route('map') }}" class="btn btn-primary btn-lg me-2">
                            <i class="fas fa-map"></i> {{ __('messages.explore_map') }}
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            {{ __('messages.get_started') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
