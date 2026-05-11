@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <h1>{{ __('messages.edit_location') }}</h1>

                <form action="{{ route('locations.update', $location) }}" method="POST" enctype="multipart/form-data" class="card mt-4">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Location Name -->
                        <div class="mb-3">
                            <label for="location_name" class="form-label">{{ __('messages.location_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location_name') is-invalid @enderror" id="location_name" name="location_name" value="{{ old('location_name', $location->location_name) }}" required>
                            @error('location_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('messages.description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $location->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">{{ __('messages.category') }} <span class="text-danger">*</span></label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $location->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Coordinates -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">{{ __('messages.latitude') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" step="0.00000001" value="{{ old('latitude', $location->latitude) }}" required>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Range: -90 to 90</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">{{ __('messages.longitude') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" step="0.00000001" value="{{ old('longitude', $location->longitude) }}" required>
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Range: -180 to 180</small>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.adjust_location_on_map') }}</label>
                            <div id="map" style="height: 300px; border-radius: 8px;"></div>
                            <small class="form-text text-muted d-block mt-2">{{ __('messages.click_on_map_info') }}</small>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('messages.image') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('messages.leave_blank_to_keep_current') }}</small>
                        </div>

                        <!-- Current Image -->
                        @if($location->image)
                            <div class="mb-3">
                                <label>{{ __('messages.current_image') }}</label>
                                <br>
                                <img src="{{ $location->getImageUrl() }}" alt="{{ $location->location_name }}" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                            </div>
                        @endif

                        <!-- Image Preview -->
                        <div id="imagePreview" class="mb-3" style="display: none;">
                            <label>{{ __('messages.new_image_preview') }}</label>
                            <br>
                            <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                        </div>
                    </div>

                    <div class="card-footer d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('messages.save_changes') }}
                        </button>
                        <a href="{{ route('locations.show', $location) }}" class="btn btn-secondary">
                            {{ __('messages.cancel') }}
                        </a>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('messages.location_info') }}</h5>
                        <small>
                            <strong>{{ __('messages.created') }}:</strong> {{ $location->created_at->format('M d, Y H:i') }}<br>
                            <strong>{{ __('messages.last_updated') }}:</strong> {{ $location->updated_at->format('M d, Y H:i') }}<br>
                            <strong>{{ __('messages.current_category') }}:</strong> {{ $location->category->category_name }}<br>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const map = L.map('map').setView([{{ $location->latitude }}, {{ $location->longitude }}], 14);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        let marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}]).addTo(map);

        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            latInput.value = lat.toFixed(8);
            lngInput.value = lng.toFixed(8);
            marker.setLatLng([lat, lng]);
        });

        latInput.addEventListener('change', updateMapFromInputs);
        lngInput.addEventListener('change', updateMapFromInputs);

        function updateMapFromInputs() {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                marker.setLatLng([lat, lng]);
                map.setView([lat, lng], 14);
            }
        }

        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('previewImg').src = event.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
