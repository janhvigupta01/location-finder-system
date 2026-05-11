@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col">
                <h1>{{ __('messages.interactive_map') }}</h1>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('map') }}" class="row g-3">
                            <div class="col-md-5">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('messages.search_location_name') }}" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-5">
                                <select name="category_id" class="form-control">
                                    <option value="">{{ __('messages.all_categories') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('messages.filter') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <!-- Map -->
                <div id="map" style="height: 600px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></div>
            </div>

            <div class="col-lg-3">
                <!-- Sidebar with location list -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list"></i> {{ __('messages.locations') }} 
                            <span class="badge bg-primary">{{ count($locations) }}</span>
                        </h5>
                    </div>
                    <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">
                        @forelse($locations as $location)
                            <a href="{{ route('locations.show', $location) }}" class="list-group-item list-group-item-action location-item" data-lat="{{ $location->latitude }}" data-lng="{{ $location->longitude }}">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <strong>{{ $location->location_name }}</strong>
                                    <span class="category-badge category-{{ strtolower($location->category->category_name ?? 'other') }}" style="font-size: 0.7rem;">
                                        {{ substr($location->category->category_name ?? 'Other', 0, 3) }}
                                    </span>
                                </div>
                                <small class="text-muted">{{ $location->category->category_name }}</small><br>
                                <small class="text-muted">{{ number_format($location->latitude, 4) }}, {{ number_format($location->longitude, 4) }}</small>
                            </a>
                        @empty
                            <div class="list-group-item text-center py-3">
                                <p class="text-muted mb-0">{{ __('messages.no_locations_found') }}</p>
                                <a href="{{ route('locations.create') }}" class="btn btn-sm btn-primary mt-2">
                                    {{ __('messages.add_location') }}
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('locations.create') }}" class="btn btn-success w-100">
                        <i class="fas fa-plus"></i> {{ __('messages.add_new_location') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const map = L.map('map').setView([28.7041, 77.1025], 10);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Marker cluster group
        const markers = {};
        const categoryColors = {
            'Hospital': '#cc0000',
            'School': '#0066cc',
            'Restaurant': '#cc6600',
            'Park': '#008000',
            'Tourist Place': '#ff6600',
            'Office': '#9900ff',
            'Library': '#00cccc',
            'Museum': '#990000',
            'Shopping Mall': '#ffcc00',
            'Other': '#666666'
        };

        // Load locations from server
        const locations = @json($locations);
        
        locations.forEach(function(location) {
            const categoryName = location.category?.category_name || 'Other';
            const color = categoryColors[categoryName] || '#666666';
            
            // Create custom icon
            const icon = L.divIcon({
                html: `<div style="background-color: ${color}; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">📍</div>`,
                iconSize: [32, 32],
                className: 'custom-marker'
            });

            const marker = L.marker([location.latitude, location.longitude], { icon: icon })
                .bindPopup(`
                    <div style="text-align: center;">
                        <img src="${location.getImageUrl || '{{ asset('images/placeholder.png') }}'}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px; margin-bottom: 8px;">
                        <strong>${location.location_name}</strong><br>
                        <small>${categoryName}</small><br>
                        <a href="{{ url('locations') }}/${location.id}" class="btn btn-sm btn-primary mt-2">{{ __('messages.view_details') }}</a>
                    </div>
                `)
                .addTo(map);
            
            markers[location.id] = marker;
        });

        // Click on list item to focus map on location
        document.querySelectorAll('.location-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const lat = parseFloat(this.dataset.lat);
                const lng = parseFloat(this.dataset.lng);
                map.setView([lat, lng], 16);
                
                // Find and open popup
                locations.forEach(loc => {
                    if (loc.latitude === lat && loc.longitude === lng) {
                        if (markers[loc.id]) {
                            markers[loc.id].openPopup();
                        }
                    }
                });
            });
        });

        // Allow map centering with zoom
        map.on('dblclick', function(e) {
            map.setView(e.latlng, map.getZoom() + 1);
        });
    </script>
@endpush
