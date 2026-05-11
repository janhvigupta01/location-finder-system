@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col">
                <h1>{{ $location->location_name }}</h1>
            </div>
            <div class="col-auto">
                <a href="{{ route('locations.edit', $location) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                </a>
                <form action="{{ route('locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> {{ __('messages.delete') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Image -->
                <div class="card mb-4">
                    <img src="{{ $location->getImageUrl() }}" alt="{{ $location->location_name }}" class="card-img-top" style="height: 400px; object-fit: cover;">
                </div>

                <!-- Details -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.location_details') }}</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>{{ __('messages.category') }}:</strong><br>
                                <span class="category-badge category-{{ strtolower($location->category->category_name ?? 'other') }}">
                                    {{ $location->category->category_name ?? 'Other' }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>{{ __('messages.created') }}:</strong><br>
                                {{ $location->created_at->format('M d, Y H:i') }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>{{ __('messages.latitude') }}:</strong><br>
                                {{ number_format($location->latitude, 8) }}
                            </div>
                            <div class="col-md-6">
                                <strong>{{ __('messages.longitude') }}:</strong><br>
                                {{ number_format($location->longitude, 8) }}
                            </div>
                        </div>

                        @if($location->description)
                            <div class="mb-3">
                                <strong>{{ __('messages.description') }}:</strong><br>
                                {{ $location->description }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Map -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('messages.location_on_map') }}</h5>
                    </div>
                    <div id="map" style="height: 400px;"></div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>{{ __('messages.quick_info') }}</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>{{ __('messages.owner') }}:</strong><br>
                                {{ $location->user->name }}
                            </li>
                            <li class="mb-2">
                                <strong>{{ __('messages.category') }}:</strong><br>
                                {{ $location->category->category_name }}
                            </li>
                            <li class="mb-2">
                                <strong>{{ __('messages.created') }}:</strong><br>
                                {{ $location->created_at->diffForHumans() }}
                            </li>
                            <li>
                                <strong>{{ __('messages.last_updated') }}:</strong><br>
                                {{ $location->updated_at->diffForHumans() }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5>{{ __('messages.coordinates_info') }}</h5>
                        <p class="small mb-0">
                            <strong>Lat:</strong> {{ number_format($location->latitude, 8) }}<br>
                            <strong>Lng:</strong> {{ number_format($location->longitude, 8) }}<br>
                            <a href="https://maps.google.com/?q={{ $location->latitude }},{{ $location->longitude }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                {{ __('messages.open_in_google_maps') }}
                            </a>
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('messages.actions') }}</h5>
                        <div class="d-grid gap-2">
                            <a href="{{ route('locations.edit', $location) }}" class="btn btn-warning">
                                {{ __('messages.edit_location') }}
                            </a>
                            <a href="{{ route('locations.index') }}" class="btn btn-secondary">
                                {{ __('messages.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const map = L.map('map').setView([{{ $location->latitude }}, {{ $location->longitude }}], 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        L.marker([{{ $location->latitude }}, {{ $location->longitude }}])
            .bindPopup('<strong>{{ $location->location_name }}</strong><br>{{ $location->category->category_name ?? 'Other' }}')
            .addTo(map)
            .openPopup();
    </script>
@endpush
